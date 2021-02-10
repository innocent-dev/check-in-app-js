<!DOCTYPE html>
<html>
<head>
	<title>Add New Record</title>
	<?php include "head.php";?>
</head>
<body>
<nav>
		<div class="container">	
			<h1>Covid Check-in</h1>
		</div>
</nav>
<section class="form">
	<div class="container">	
		<form method="post" action="new_record.php">
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
				<input type="text" name="hours" id="hours" size="2" style="text-align: center" value=""> H
				<input type="text" name="minutes" id="minutes" size="2" style="text-align: center" value=""> M
			</div>
		</div>
			<div class="row">
				<input class="buttons" type="button" value="Back" onclick="location.href='index.php'" style="float: left">
				<input class="buttons" type="button" name="action" id="save" value="Save" style="float: center" onclick="return saveData()">
			</div>
		</form>
	</div>
</section>

<script type="text/javascript">

	function getSaveData()
	{
		document.getElementById("name").value = localStorage.getItem("name");
		document.getElementById("surname").value = localStorage.getItem("surname");
		document.getElementById("contact_no").value = localStorage.getItem("contact_no");
		document.getElementById("temperature").value = localStorage.getItem("temperature");
		document.getElementById("hours").value = localStorage.getItem("hours");
		document.getElementById("minutes").value = localStorage.getItem("minutes");
		document.getElementById("email").value = localStorage.getItem("email");

	}

	getSaveData();
	
	function saveData()
	{
		var name 			= document.getElementById("name").value;
		var surname 		= document.getElementById("surname").value;
		var contact_no 		= document.getElementById("contact_no").value;
		var temperature 	= document.getElementById("temperature").value;
		var hours 			= document.getElementById("hours").value;
		var minutes 		= document.getElementById("minutes").value;
		var email 			= document.getElementById("email").value;
		var wearing_mask 	= document.getElementById("wearing_mask").value;
		var covid_symptoms 	= document.getElementById("covid_symptoms").value;

		if(covid_symptoms.length <= 0)
		{
			alert("Please Select Covid Symtoms");
			return false;
		}

		if(name.length <= 0)
		{
			alert("please input name");
			return false;
		}

		if(surname.length <= 0)
		{
			alert("please input surname");
			return false;
		}

		// Store
		localStorage.setItem("name", name);
		localStorage.setItem("surname", surname);
		localStorage.setItem("contact_no", contact_no);
		localStorage.setItem("temperature", temperature);
		localStorage.setItem("hours", hours);
		localStorage.setItem("minutes", minutes);
		localStorage.setItem("email", email);
		localStorage.setItem("wearing_mask", wearing_mask);
		localStorage.setItem("covid_symptoms", covid_symptoms);
		location.href='index.php';
	}
</script>
</body>
</html>