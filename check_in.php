<!DOCTYPE html>
<html>
<head>
	<title>Check In</title>
	<?php include "head.php"?>
</head>
<body>
<section class="form">
	<div class="container">
		<form action="check_in.php" method="post">
		<div class="row">
			<label>Check-in details</label>
		</div>
		<input type="hidden" name="visitor_id" value="">
		<input type="hidden" name="record_id" value="">
		<div class="row">
			<div class="col-1"><label for="Name">Name</label></div>
			<div class="col-2"></div>
		</div>
		<div class="row">
			<div class="col-1"><label for="Name">Surname</label></div>
			<div class="col-2"></div>
		</div>
		<div class="row">
			<div class="col-1">
				<label for="wearing_mask">Wearing a mask ?</label></div>
			<div class="col-2">
				
			</div>
		</div>
		<div class="row">
			<div class="col-1"><label for="covid_symptoms">Covid Symtoms</label></div>
			<div class="col-2">
				
			</div>
		</div>
		<div class="row">
			<div class="col-1"><label for="temperature">Temperature</label></div>
			<div class="col-2"><input type="text" name="temperature" value=""  size="2" style="text-align: center" required></div>
		</div>
		<div class="row">
			<div class="col-1">
				<label for="time_in">Time In</label>
			</div>
			<div class="col-2">
				<input type="text" name="hours" size="2" style="text-align: center" value=""> H
				<input type="text" name="minutes" size="2" style="text-align: center" value=""> M
			</div>
		</div>
		<div class="row">
			<input type="submit" class="buttons" name="action" value="Check in" style="float: center;">
			<input type="button" class="buttons" value="Back" style="float: left" onclick="location.href='index.php'">
		</div>
		</form>			
	</div>
</section>
</body>
</html>