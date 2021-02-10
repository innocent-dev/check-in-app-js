<!DOCTYPE html>
<html>
<head>
	<title>Check In</title>
	<meta name="description" content="fill in your temparature and answer covid related questions">
	<?php include "head.php";?>
</head>
<body>
	<nav>
		<div class="container">	
			<h1>Covid Check-in</h1>
		</div>
	</nav>
	<section class="visitor_list">
		<div class="container">
			<h3>Date 09 February 2021</h3>
			<table class="table">	
			<tr>
				<th>Firstname</th>
				<th>Surname</th>
				<th>Contact no</th>
				<th>Email</th>
				<th>Wearing Mask</th>
				<th>Covid Symptons</th>
				<th>Temperature</th>
				<th>Time-in</th>
				<th></th>
			</tr>
			<tr>
				<td id="name"></td>
				<td id="surname"></td>
				<td id="contact_no"></td>
				<td id="email"></td>
				<td id="wearing_mask"></td>
				<td id="covid_symptoms"></td>
				<td id="temperature"></td>
				<td id="time_in"></td>
				<td><input type="button" class="buttons" value="Update" name="" onclick="location.href='new_record.php'"></td>
			</tr>
			<tr>
				<td colspan="100%" style="text-align: center"><input type="button" id="new_record" class="buttons" name="" value="Add New Record" onclick="location.href='new_record.php'">&nbsp;</td>
			</tr>
			</table>
		</div>
	</section>
	<script type="text/javascript">
		function getData()
		{
			document.getElementById("name").innerHTML = localStorage.getItem("name");
			document.getElementById("surname").innerHTML = localStorage.getItem("surname");
			document.getElementById("contact_no").innerHTML = localStorage.getItem("contact_no");
			document.getElementById("email").innerHTML = localStorage.getItem("email");
			document.getElementById("temperature").innerHTML = localStorage.getItem("temperature");
			document.getElementById("wearing_mask").innerHTML = localStorage.getItem("wearing_mask");
			document.getElementById("covid_symptoms").innerHTML = localStorage.getItem("covid_symptoms");
			document.getElementById("time_in").innerHTML = localStorage.getItem("hours") + ':' + localStorage.getItem("minutes");

			if(localStorage.getItem("name") !== '')
			{
				document.getElementById("new_record").style.display = 'none';
			}

		}
		getData();
	</script>
</body>
</html>
