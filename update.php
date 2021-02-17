<!DOCTYPE html>
<html>
<head>
	<title>Check In</title>
	<?php include "head.php"?>
</head>
<body>

<script type="text/javascript">
		//connect index db
		var db;
		var request = window.indexedDB.open("visitors_db", 3);
		
		request.onupgradeneeded = function()
		{
			//tables created here
			 var db = request.result;
			const visitorDetails = db.createObjectStore("visitor_details", {keyPath: "email_id"}); //more like a table
			
			console.log(`database created by the name ${db.name}`);
		}

		request.onsuccess = function(event) {
        db = request.result;
		getData();
        console.log("success: "+ db);
    };
	</script>

<section class="form">
	<div class="container">
		<form action="update.php" method="post" onsubmit="return updateData()">
			<input type="hidden" name="email_id" id="email_id" value="">
		<div class="row">
			<label>Update Check-In Details</label>
		</div>
		<div class="alert-row" style="display: none;">
			<div class="alerts"></div>
		</div>
		<div class="row">
			<div class="col-1"><label for="name">Name</label></div>
			<div class="col-2"><input type="text" name="name" id="name"/></div>
		</div>
		<div class="row">
			<div class="col-1"><label for="surname">Surname</label></div>
			<div class="col-2"><input type="text" name="surname" id="surname" /></div>
		</div>
		<div class="row">
			<div class="col-1">
				<label for="contact_no">Contact No</label>
			</div>
			<div class="col-2">
				<input type="text" name="contact_no" id="contact_no">
			</div>
		</div>
		<div class="row">
			<div class="col-1"><label for="email_id">Email Id</label></div>
			<div class="col-2"><span id="display_email_id"></span></div>
		</div>
		<div class="row">
			<div class="col-1">
				<label for="wearing_mask">Wearing a mask ?</label></div>
			<div class="col-2">
				<select name="wearing_mask" id="wearing_mask" class="select">
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-1"><label for="covid_symptoms">Covid Symtoms</label></div>
			<div class="col-2">
				<select name="covid_symptoms" id="covid_symptoms" class="select">
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-1"><label for="temperature">Temperature</label></div>
			<div class="col-2"><input type="text" name="temperature" id="temperature" value=""  size="2" style="text-align: center" required></div>
		</div>
		<div class="row">
			<div class="col-1">
				<label for="time_in">Time In</label>
			</div>
			<div class="col-2">
				<input type="text" name="hours" id="hours" size="2" style="text-align: center" value="" /> H
				<input type="text" name="minutes" id="minutes" size="2" style="text-align: center" value="" /> M
			</div>
		</div>
		<div class="row">
			<input type="submit" class="buttons" name="action" value="Update" style="float: center;" />
			<input type="button" class="buttons" value="Back" style="float: left" onclick="location.href='index.php'" />
		</div>
		</form>			
	</div>
</section>

<script type="text/javascript">
	var v_url 				= window.location.search;
	var email_id 			= v_url.substring(10);
	if(email_id.length <= 0 && email_id == '')
	{
		email_id = $("#email_id").val();
	}
	
	$("#email_id").val(email_id);
	
	var yes_no_options 		= ["Yes", "No"];

	function getData()
	{
		var transaction = db.transaction("visitor_details", "readonly");
		var objectStore = transaction.objectStore("visitor_details");
		var request		= objectStore.get(email_id);

		request.onsuccess = function()
		{
			//create dynamic drop-down
			var covid_symptoms_options = wearing_mark_options = '';

			for(i=0;i<=1;i++)
			{
				var selected = is_wearing_mask_selected = '';
				if(yes_no_options[i] == request.result.covid_symptoms)
				{
					selected = 'selected';
				}

				if(yes_no_options[i] == request.result.wearing_mask)
				{
					is_wearing_mask_selected = 'selected';
				}

				covid_symptoms_options += `<option ${selected}>${yes_no_options[i]}</option>`;
				wearing_mark_options += `<option ${is_wearing_mask_selected}>${yes_no_options[i]}</option>`;
			}

			//set data
			$("#name").val(request.result.name);
			$("#surname").val(request.result.surname);
			$("#display_email_id").html(request.result.email_id);
			$("#wearing_mask").html(wearing_mark_options);
			$("#covid_symptoms").html(covid_symptoms_options);
			$("#contact_no").val(request.result.contact_no);
			$("#temperature").val(request.result.temperature);
			$("#hours").val(request.result.hours);
			$("#minutes").val(request.result.minutes);
		}

		request.onerror = function()
		{

		}

		//get data
		//search
	}


	function updateData()
	{
		var name 			= $("#name").val();
		var surname 		= $("#surname").val();
		var contact_no 		= document.forms[0]['contact_no'].value;
		var email_id 		= document.forms[0]['email_id'].value;
		var wearing_mask 	= document.forms[0]['wearing_mask'].value;
		var wearing_mask 	= document.forms[0]['wearing_mask'].value;
		var covid_symptoms	= document.forms[0]["covid_symptoms"].value;
		var temperature     = document.forms[0]["temperature"].value;
		var hours			= document.forms[0]["hours"].value;
		var minutes			= document.forms[0]["minutes"].value;
		var errors          = '';
		
		//validate
		if(name.length <=0 && name == '')
		{
			errors += '<li>Please enter your name</li>';
		}

		if(surname.length <=0 && surname == '')
		{
			errors += '<li>Please enter your surname</li>';
		}

		if(contact_no.length <=0 && contact_no == '')
		{
			errors += '<li>Please enter your contact number</li>';
		}


		if(email_id.length <=0 && email_id == '')
		{
			errors += '<li>Please enter your email Id</li>';
		}
		else
		{
			//check if it's a valid email
			var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if(!regex.test(email_id))
			{
				errors += '<li>Please enter a valid email Id</li>';
			}
		}

		if(wearing_mask.length <=0 && wearing_mask == '')
		{
			errors += '<li>Please specify whether you wearing a musk or not</li>';
		}

		if(covid_symptoms.length <=0 && covid_symptoms == '')
		{
			errors += '<li>Please Specify whether you have any covid symtoms or not</li>';
		}

		if(temperature.length <=0 && temperature == '')
		{
			errors += '<li>Please enter your temperature</li>';
		}
		else
		{
			//check if temperature is numeric
			if(isNaN(temperature))
			{
				errors += '<li>Please make sure entered temperature is a numeric value</li>';
			}
		}

		if(hours.length <=0 && hours == '')
		{
			errors += '<li>Please enter your time-in hours</li>';

			if(isNaN(hours))
			{
				errors += '<li>Please make sure entered hours are a numeric value</li>';
			}
		}
		else
		{
			//check if numeric
			if(isNaN(hours))
			{
				errors += '<li>Please make sure entered hours are a numeric value</li>';
			}
			else
			{
				if(hours > 23)
				{
					errors += '<li>Please make sure entered hours are not above 23</li>';
				}
			}
		}

		if(minutes.length <=0 && minutes == '')
		{
			errors += '<li>Please enter your time-in minutes</li>';

			//check if numeric
		}
		else
		{
			//check if numeric
			if(isNaN(minutes))
			{
				errors += '<li>Please make sure entered minutes are a numeric value</li>';
			}
			else
			{
				if(minutes > 59)
				{
					errors += '<li>Please make sure entered minutes are not above 59</li>';
				}
			}
		}


		if(errors.length > 0)
		{
			list_errors = `<ul style="color:red;list-style:none;text-align:left;margin-left:145px;padding:0;padding-top:5px"><li><b>There were problems encounted while trying to submit the form, please see below :</b></li>`  //build error list
			list_errors += `${errors} </ul>`;

			$(".alert-row").css({"display": "", "borderBottom": "1px black solid", "text-align": "center"});
			$(".alerts").css({"text-align":"center"}).html(list_errors);

			return false;
		}
		else
		{
			$(".alert-row").css({"display": "none"});
		}


		const visitor_data = { name:name,
			surname: surname,
			contact_no: contact_no,
			email_id: email_id,
			wearing_mask: wearing_mask,
			covid_symptoms: covid_symptoms,
			hours: hours,
			minutes: minutes,
			temperature: temperature
		};
		
		var transaction = db.transaction("visitor_details", "readwrite");
		var objectStore = transaction.objectStore("visitor_details");
		var request		= objectStore.put(visitor_data);

		request.onsuccess = function()
		{
			location.href='index.php';
		}

		request.onerror = function()
		{
			alert('failed ');
		}

		return false;

	}
</script>
</body>
</html>