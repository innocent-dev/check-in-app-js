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
	//connectDB();
	const visitor_data = {
		email_id: "innocent0@test.com",
		temperature: 10
	};

	var v_transaction 	= db.transaction("visitor_details", "readwrite");
	var v_oject_store 	= v_transaction.objectStore("visitor_details");
	var v_request 		= v_oject_store.add(visitor_data);

	v_request.onsuccess = function(event)
	{
		alert(`data added successfully`);
	}

	v_request.onerror = function()
	{
		console.log(`error`);
	}

	return true;
}	

</script>
</body>
</html>