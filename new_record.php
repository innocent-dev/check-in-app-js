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
				</div>
			</div>
			<div class="row">
				<div class="col-1">
					<label for="surname">Surname</label>
				</div>
				<div class="col-2">
					<input type="text" name="surname" id="surname" placeholder="Enter Surname">
				</div>
			</div>
			<div class="row">
				<div class="col-1">
					<label for="contact_no">Contact No</label>
				</div>
				<div class="col-2">
					<input type="text" name="contact_no" id="contact_no" placeholder="Enter Contact No">
				</div>
			</div>
			<div class="row"> 
				<div class="col-1">
					<label>Email Id</label>
				</div>
				<div class="col-2">
					<input type="text" name="email" id="email" placeholder="Enter Email Address" style="width: 300px">
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
			</div>
		</div>
		<div class="row">
			<div class="col-1"><label for="temperature">Temperature</label></div>
			<div class="col-2"><input type="text" name="temperature" id="temperature" size="2" style="text-align: center"></div>
		</div>
		<div class="row">
			<div class="col-1">
				<label for="time_in">Time In</label>
			</div>
			<div class="col-2">
				<input type="text" name="hours" id="hours" size="2" style="text-align: center" value=""/> H
				<input type="text" name="minutes" id="minutes" size="2" style="text-align: center" value=""/> M
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

function saveData()
{
	//javascript used to get data from form
	var name 			= document.forms[0]["name"].value;
	var surname 		= document.forms[0]["surname"].value;
	var contact_no 		= document.forms[0]["contact_no"].value;
	var email_id 		= document.forms[0]["email"].value;
	var wearing_mask 	= document.forms[0]['wearing_mask'].value;
	var covid_symptoms	= document.forms[0]["covid_symptoms"].value;
	var temperature     = document.forms[0]["temperature"].value;
	var hours			= document.forms[0]["hours"].value;
	var minutes			= document.forms[0]["minutes"].value;
	var errors			= '';
	var list_errors		= '';

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