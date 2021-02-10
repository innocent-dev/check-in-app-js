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
	var request = window.indexedDB.open("visitorsDatabase", 1);

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
			<div class="col-2"><input type="text" name="temperature" id="temperature" size="2" style="text-align: center" required></div>
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
				<input class="buttons" type="submit" name="action" id="save" value="Save" style="float: center"/>
			</div>
		</form>
	</div>
</section>

<script type="text/javascript">
	function saveData()
	{
		alert('here');
		console.log(forms["form"]["name"].value);
		return false;
		var v_name 				= forms[0]["name"].value;
		var v_surname 			= document.getElementById("surname").value;
		var v_email 			= document.getElementById("email").value;
		var contact_no 			= document.getElementById("contact_no").value;
		var temperature 		= document.getElementById("temperature").value;
		var hours 				= document.getElementById("hours").value;
		var minutes 			= 10;//s(0)ocument.getElementById("minutes").value;
		var covid_symptoms 		= document.getElementById("covid_symptoms").value;
		var wearing_mask 		= document.getElementById("wearing_mask").value;
		var error				= '';
		//validate

		if(v_name.length >= 0 && v_name == '')
		{
			error += '\\nName is required';
		}

		if(v_surname.length >= 0 && v_surname == '')
		{
			error += '\\n Surname is required';
		}

		if(error.length > 4)
		{
			var error_message = 'Please fix the following :';
			error_message =+ '' + error;
			alert(error_message);
			return false;
		}	

		var request 	= db.transaction(["visitorsDatabase"], "readwrite")
		.objectStore("visitorsDatabase")
		.add({ id: "1", 
			name: v_name, 
			surname: v_surname, 
			email: v_email, 
			contact_no: contact_no,
			covid_symptoms: covid_symptoms,
			wearing_mask: wearing_mask,
			temperature: temperature,
			hours: hours,
			minutes: minutes 
		});

		request.onsuccess = function(event) {
               alert(v_name + " has been added to your database.");
            };
            
            request.onerror = function(event) {
               alert("Unable to add data\r\n "+ v_name + " is already exist in your database! ");
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