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
		<form action="check_in.php" method="post" onsubmit="updateData()">
			<input type="hidden" name="email_id" id="email_id" value="">
		<div class="row">
			<label>Check-in details</label>
		</div>
		<div class="row">
			<div class="col-1"><label for="name">Name</label></div>
			<div class="col-2"><span id="name"></span></div>
		</div>
		<div class="row">
			<div class="col-1"><label for="surname">Surname</label></div>
			<div class="col-2"><span id="surname"></span></div>
		</div>
		<div class="row">
			<div class="col-1"><label for="email_id">Email Id</label></div>
			<div class="col-2"><span id="display_email_id"></span></div>
		</div>
		<div class="row">
			<div class="col-1">
				<label for="wearing_mask">Wearing a mask ?</label></div>
			<div class="col-2">
				<select name="wearing_mask" id="wearing_mask">
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-1"><label for="covid_symptoms">Covid Symtoms</label></div>
			<div class="col-2">
				<select name="covid_symptoms" id="covid_symptoms">
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
			$("#name").html(request.result.name);
			$("#surname").html(request.result.surname);
			$("#display_email_id").html(request.result.email_id);
			$("#wearing_mask").html(wearing_mark_options);
			$("#covid_symptoms").html(covid_symptoms_options);
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
		var name 			= $("#name").text();
		var surname 		= $("#surname").text();
		var email_id 		= document.forms[0]['email_id'].value;
		var wearing_mask 	= document.forms[0]['wearing_mask'].value;
		var wearing_mask 	= document.forms[0]['wearing_mask'].value;
		var covid_symptoms	= document.forms[0]["covid_symptoms"].value;
		var temperature     = document.forms[0]["temperature"].value;
		var hours			= document.forms[0]["hours"].value;
		var minutes			= document.forms[0]["minutes"].value;

		const visitor_data = { name:name,
			surname: surname,
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