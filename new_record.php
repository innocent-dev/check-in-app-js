<!DOCTYPE html>
<html>
<head>
	<title>Add New Record</title>
	<?php include "head.php";?>
</head>
<body>
<script type="text/javascript">
window.indexedDB = window.indexedDB || window.mozIndexedDB || window.webkitIndexedDB || 
window.msIndexedDB;

window.IDBTransaction = window.IDBTransaction || window.webkitIDBTransaction || 
window.msIDBTransaction;
window.IDBKeyRange = window.IDBKeyRange || 
window.webkitIDBKeyRange || window.msIDBKeyRange

if (!window.indexedDB) {
   window.alert("Your browser doesn't support a stable version of IndexedDB.")
}

var db; 
connectDB();

function connectDB()
{
	//create database
	var request = indexedDB.open("visitors_db", 3);
	request.onupgradeneeded = function()
	{
		//tables created here
		 var db = request.result;
		const visitorDetails = db.createObjectStore("visitor_details", {keyPath: "email_id"}); //more like a table
		
		console.log(`database created by the name ${db.name}`);
	}

	request.onsuccess = function()
	{
		db = request.result; //our database with required data
		//alert("upgrade is completed and success is called");
	}

	request.onerror = function()
	{
	//	alert("upgrade is created");
	}

}
</script>

<nav>
		<div class="container">	
			<h1>Covid Check-in</h1>
			<div id="note"></div>
		</div>
</nav>
<section class="form">
	<div class="container">	
		<form method="post" onsubmit="return saveData()">
			<div class="row">
				<label>Add New Record</label>
			</div>
			<div class="alert-row" style="display: none;">
				<div class="alerts"></div>
			</div>
			<div class="row">
				<div class="col-1"><label for="name">Name</label></div>
				<div class="col-2">
					<input type="text" name="name" id="name" placeholder="Enter Name">
					<span id="name_error" class="error_message"></span>
				</div>
			</div>
			<div class="row">
				<div class="col-1">
					<label for="surname">Surname</label>
				</div>
				<div class="col-2">
					<input type="text" name="surname" id="surname" placeholder="Enter Surname">
					<span id="surname_error" class="error_message"></span>
				</div>
			</div>
			<div class="row">
				<div class="col-1">
					<label for="contact_no">Contact No</label>
				</div>
				<div class="col-2">
					<input type="text" name="contact_no" id="contact_no" placeholder="Enter Contact No">
					<span id="contact_no_error" class="error_message"></span>
				</div>
			</div>
			<div class="row"> 
				<div class="col-1">
					<label>Email Id</label>
				</div>
				<div class="col-2">
					<input type="text" name="email" id="email" placeholder="Enter Email Address" style="width: 250px">
					<span id="email_error" class="error_message"></span>
				</div>

			</div>
			<div class="row">
			<div class="col-1">
				<label for="wearing_mask">Wearing a mask ?</label></div>
			<div class="col-2">
				<select name="wearing_mask" id="wearing_mask" class="select">
					<option value="">Choose</option>
					<option value="Yes">Yes</option>
					<option value="No">No</option>
				</select>
				<span id="wearing_mask_error" class="error_message"></span>
			</div>
		</div>
		<div class="row">
			<div class="col-1"><label for="covid_symptoms">Covid Symtoms</label></div>
			<div class="col-2">
				<select name="covid_symptoms" id="covid_symptoms" class="select">
					<option value="">Choose</option>
					<option value="Yes">Yes</option>
					<option value="No">No</option>
				</select>
				<span id="covid_symptoms_error" class="error_message"></span>
			</div>
		</div>
		<div class="row">
			<div class="col-1"><label for="temperature">Temperature</label></div>
			<div class="col-2">
				<input type="text" name="temperature" id="temperature" size="2" style="text-align: center">
				<span id="temperature_error" class="error_message"></span>
			</div>
		</div>
		<div class="row">
			<div class="col-1">
				<label for="time_in">Time In</label>
			</div>
			<div class="col-2">
				<input type="text" name="hours" id="hours" size="2" style="text-align: center" value=""/> H
				<input type="text" name="minutes" id="minutes" size="2" style="text-align: center" value=""/> M
				<span id="time_error" class="error_message"></span>
			</div>
		</div>
			<div class="row">
				<input class="buttons" type="button" value="Back" onclick="location.href='index.php'" style="float: left"/>
				<input class="buttons" type="submit" id="save" value="Save" style="float: center"/>
			</div>
		</form>
	</div>
</section>

<script type="text/javascript">

$(document).ready(function(){
	//set the time to the current time
	var date_time = new Date();
  	var minutes = date_time.getMinutes();
  	var hours	= date_time.getHours();

  	$("#hours").val(hours);
  	$("#minutes").val(minutes);
});

//on blur event (when element looses focus) to clear error highlights
$("#name").blur(function(){
	if($(this).val().length > 0)
	{
		$(this).css("outline", "");
		$("#name_error").text('');
	}
});

$("#surname").blur(function(){
	if($(this).val().length > 0)
	{
		$(this).css("outline", "");
		$("#surname_error").text('');
	}
});

$("#contact_no").blur(function(){
	if($(this).val().length > 0)
	{
		$(this).css("outline", "");
		$("#contact_no_error").text('');
	}
});

$("#email").blur(function(){
	if($(this).val().length > 0)
	{
		$(this).css("outline", "");
		$("#email_error").text('');
	}
});

$("#wearing_mask").blur(function(){
	if($(this).val().length > 0)
	{
		$(this).css("outline", "");
		$("#wearing_mask_error").text('');
	}
});

$("#covid_symptoms").blur(function(){
	if($(this).val().length > 0)
	{
		$(this).css("outline", "");
		$("#covid_symptoms_error").text('');
	}
});

$("#temperature").blur(function(){
	if($(this).val().length > 0)
	{
		$(this).css("outline", "");
		$("#temperature_error").text('');
	}
});

function saveData()
{
	//javascript used to get data from form
	var name 					= document.forms[0]["name"].value;
	var surname 				= document.forms[0]["surname"].value;
	var contact_no 				= document.forms[0]["contact_no"].value;
	var email_id 				= document.forms[0]["email"].value;
	var wearing_mask 			= document.forms[0]['wearing_mask'].value;
	var covid_symptoms			= document.forms[0]["covid_symptoms"].value;
	var temperature     		= document.forms[0]["temperature"].value;
	var hours					= document.forms[0]["hours"].value;
	var minutes					= document.forms[0]["minutes"].value;
	var errors					= '';
	var list_errors				= '';
	var array_errors			= [];
	var array_target_element 	= [];
	var time_error 				= '';

	//validate
	if(name.length <=0 && name == '')
	{
		var name_error = 'Please enter your name';
		errors += `<li>${name_error}</li>`;
		array_errors.push(name_error);
		array_target_element.push("name");
	}

	if(surname.length <=0 && surname == '')
	{
		var surname_error_message = "Please enter your surname"
		errors += `<li>${surname_error_message}</li>`;
		
		if(array_errors.length > 1)
		{
			array_errors += ",";
			array_target_element += ",";
		}
		
		array_errors.push(surname_error_message)
		array_target_element.push("surname");
	}

	if(contact_no.length <=0 && contact_no == '')
	{
		var contact_no_error = "Please enter your contact number"
		errors += `<li>${contact_no_error}</li>`;

		array_errors.push(contact_no_error)
		array_target_element.push("contact_no");
	}


	if(email_id.length <=0 && email_id == '')
	{
		var email_error = 'Please enter your email Id';
		errors += `<li>${email_error}</li>`;
		array_errors.push(email_error)
		array_target_element.push("email");

	}
	else
	{
		//check if it's a valid email
		var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(!regex.test(email_id))
		{
			var email_error = "Please enter a valid email Id";
			errors += `<li>${email_error}</li>`;

			//push error into array of errors 
			array_errors.push(email_error)
			array_target_element.push("email");
		}
	}

	if(wearing_mask.length <=0 && wearing_mask == '')
	{
		var mask_error = "Please specify whether you wearing a musk or not";
		errors += `<li>${mask_error}</li>`;

		//push error into array of errors 
		array_errors.push(mask_error)
		array_target_element.push("wearing_mask");

	}

	if(covid_symptoms.length <=0 && covid_symptoms == '')
	{
		var covid_symptoms_error = "Please Specify whether you have any covid symtoms or not";
		errors += `<li>${covid_symptoms_error}</li>`;

		//push error into array of errors 
		array_errors.push(covid_symptoms_error)
		array_target_element.push("covid_symptoms");
	}

	if(temperature.length <=0 && temperature == '')
	{
		var temperature_error = "Please enter your temperature";
		errors += `<li>${temperature_error}</li>`;

		//push error into array of errors 
		array_errors.push(temperature_error)
		array_target_element.push("temperature");
	}
	else
	{
		//check if temperature is numeric
		if(isNaN(temperature))
		{
			temperature_error = "Please make sure entered temperature is a numeric value";
			errors += `<li>${temperature_error}</li>`;

			//push error into array of errors 
			array_errors.push(temperature_error)
			array_target_element.push("temperature");
		}
	}

	if(hours.length <=0 && hours == '')
	{
		var hours_error = "Please enter your time-in hours";
		
		time_error = hours_error;//errors displayed next to element

		errors += `<li>${hours_error}</li>`;

		//push error into array of errors 
		array_errors.push(hours_error)
		array_target_element.push("hours");
	}
	else
	{
		//check if numeric
		if(isNaN(hours))
		{
			var hours_error = "Please make sure entered hours are a numeric value";
			
			time_error = hours_error;//errors displayed next to element
			
			errors += `<li>${hours_error}</li>`;
			
			//push error into array of errors 
			array_errors.push(hours_error)
			array_target_element.push("hours");
		}
		else
		{
			if(hours > 23)
			{
				var hours_error = "Please make sure entered hours are not above 23";
				time_error = hours_error;
				errors += `<li>${hours_error}</li>`;

				//push error into array of errors 
				array_errors.push(hours_error)
				array_target_element.push("hours");
			}
		}
	}

	if(minutes.length <=0 && minutes == '')
	{
		var minutes_error = "Please enter your time-in minutes";
		
		//errors displayed next to element
		if(time_error.length > 1)
		{
			time_error += " and minutes";
		}
		else
		{
			time_error = minutes_error;
		}
		
		errors += `<li>${minutes_error}</li>`;

		//push error into array of errors 
		array_errors.push(minutes_error)
		array_target_element.push("minutes");

	}
	else
	{
		//check if numeric
		if(isNaN(minutes))
		{
			var minutes_error = "Please make sure entered minutes are a numeric value";
		
			//errors displayed next to element
			if(time_error.length > 1)
			{
				time_error += " and entered minutes are a numeric value";
			}
			else
			{
				time_error = minutes_error;
			}

			errors += `<li>${minutes_error}</li>`;

			//push error into array of errors 
			array_errors.push(minutes_error)
			array_target_element.push("minutes");
		}
		else
		{
			if(minutes > 59)
			{
				var minutes_error = "Please make sure entered minutes are not above 59";

				//errors displayed next to element
				if(time_error.length > 1)
				{
					time_error += " and minutes are not above 59";
				}
				else
				{
					time_error = minutes_error;
				}

				errors += `<li>${minutes_error}</li>`;
				
				//push error into array of errors 
				array_errors.push(minutes_error)
				array_target_element.push("minutes");
			}
		}
	}

	//highlit and display messages next to elements with errors

	if(array_errors.length > 0)
	{
		for(i=0;i<array_errors.length;i++)
		{
			if(i == 0)
			{
				$(`#${array_target_element[i]}`).focus();
			}

			if(`${array_target_element[i]}` == "hours" || `${array_target_element[i]}` == "minutes")
			{
				alert('here');
				$(`#${array_target_element[i]}`).css("outline", "2px solid red");
				$(`#time_error`).text(time_error);				

			}
			else
			{
				$(`#${array_target_element[i]}`).css("outline", "2px solid red");
				$(`#${array_target_element[i]}_error`).text(array_errors[i]);				
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

	const visitor_data = {
		email_id: email_id,
		name: name,
		surname: surname,
		contact_no: contact_no,
		wearing_mask: wearing_mask,
		covid_symptoms: covid_symptoms,
		hours: hours,
		minutes: minutes,
		temperature: temperature
	};

	var v_transaction 	= db.transaction("visitor_details", "readwrite");
	var v_oject_store 	= v_transaction.objectStore("visitor_details");
	var v_request 		= v_oject_store.add(visitor_data);

	v_request.onsuccess = function(event)
	{
		window.location.href='index.php';
	}

	v_request.onerror = function()
	{
		list_errors = `<ul style="color:red;list-style:none;text-align:left;margin-left:145px;padding:0;padding-top:5px"><li><b>There were problems encounted while trying to submit the form, please see below :</b></li>`  //build error list
		list_errors += `<li>Used email id already exists in the database</li></ul>`;
		$(".alert-row").css({"display": "", "borderBottom": "1px black solid", "text-align": "center"});
		$(".alerts").css({"text-align":"center"}).html(list_errors);

	}

	if(v_request.onerror)
	{
		return false;
	}
	else
	{
		return true;
	}
}	

</script>
</body>
</html>