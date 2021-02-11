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
	
	//create database
	var db;
	var request = window.indexedDB.open("visitorsDatabase");

    request.onerror = function(event) 
    {
    	console.log("error: ");
	};

	request.onsuccess = function(event) {
        db = request.result;
       // getData();
        console.log("success: "+ db);
    };

    request.onupgradeneeded = function(event) {
        var db = event.target.result;
        var objectStore = db.createObjectStore("visitorsDatabase", {keyPath: "id"});
        
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
		<form method="post" action="new_record.php" onsubmit="return saveData()">
			<div class="row">
				<label>Add New Record</label>
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
					<input type="text" name="email" id="email" placeholder="Enter Email Address">
				</div>

			</div>
			<div class="row">
			<div class="col-1">
				<label for="wearing_mask">Wearing a mask ?</label></div>
			<div class="col-2">
				<select name="wearing_mask" id="wearing_mask">
					<option value="">Choose</option>
					<option value="Yes">Yes</option>
					<option value="No">No</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-1"><label for="covid_symptoms">Covid Symtoms</label></div>
			<div class="col-2">
				<select name="covid_symptoms" id="covid_symptoms">
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
	function saveData()
	{
		var v_name 				= document.forms[0]["name"].value;
		var v_surname 			= document.forms[0]["surname"].value;
		var v_email 			= document.forms[0]["email"].value;
		var contact_no 			= document.forms[0]["contact_no"].value;
		var temperature 		= document.forms[0]["temperature"].value;
		var wearing_mask 		= document.forms[0]["wearing_mask"].value;
		var covid_symptoms 		= document.forms[0]["covid_symptoms"].value;
		var hours 				= document.forms[0]["hours"].value;
		var minutes 			= document.forms[0]["minutes"].value;
		var error				= '';
		var next_id				= 0;
		var savedEmails			= '';
		var exists = 0;
		//validate

		//name
		if(v_name.length >= 0 && v_name == '')
		{
			error += '\n Name is required';
		}

		//surname
		if(v_surname.length <= 0 && v_surname == '')
		{
			error += '\n Surname is required';
		}

		//temperature
		if(temperature.length <=0 && temperature == '')
		{
			error += '\n Temperature is required';
		}
		else
		{
			//check if it's numeric
			if(isNaN(temperature))
			{
				error += '\n Temperature should be a numeric value';
			}
		}

		if(error.length > 4)
		{
			var error_message = 'Please fix the following :';
			error_message += '' + error;
			alert(error_message);
			return false;
		}	


	//count inserted records
		var transaction = db.transaction(['visitorsDatabase'], 'readwrite');
		var objectStore = transaction.objectStore('visitorsDatabase');

		var countRequest = objectStore.count();
		countRequest.onsuccess = function() //check and set next id
		{
			next_id = countRequest.result + 1; //next id to create

			var request	= objectStore.add({id: next_id ,name: v_name, surname: v_surname, email: v_email, contact_no: contact_no,covid_symptoms: covid_symptoms,
				wearing_mask: wearing_mask,
				temperature: temperature,
				hours: hours,
				minutes: minutes 
			});

			request.onsuccess = function(event) {
	            alert(v_name + " has been added to your database.");
            };
	            
	            request.onerror = function(event) {
	               alert("Unable to add data\r\n "+ v_name + " already exist in your database! ");
	            }
		}
	}

	function getData()
	{
		 // open a read/write db transaction, ready for retrieving the data
		var note		  	= document.getElementById("note");
		var transaction 	= db.transaction(["visitorsDatabase"], "readwrite");
		var objectStore 	= transaction.objectStore("visitorsDatabase"); // create an object store on the transaction
		var requestObject	= objectStore.get("1"); // Make a request to get a record by key from the object store (id)
		 
		 requestObject.onsuccess = function(event) {
			var v_name 				= requestObject.result.name;
			var v_surname 			= requestObject.result.surname;
			var v_contact_no 		= requestObject.result.contact_no;
			var email 				= requestObject.result.email;
			var temperature 		= requestObject.result.temperature;
			var hours 				= requestObject.result.hours;
			var minutes 			= requestObject.result.minutes;
			
			if( typeof v_contact_no == "undefined") v_contact_no = '';
			document.getElementById("name").value = v_name;
			document.getElementById("surname").value = v_surname;
			document.getElementById("contact_no").value = v_contact_no;		
			document.getElementById("temperature").value = temperature;
			document.getElementById("email").value = email;
			document.getElementById("minutes").value = minutes;
			document.getElementById("hours").value = hours;
			

		 }
	}
</script>
</body>
</html>