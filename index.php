<!DOCTYPE html>
<html>
<head>
	<title>Check In</title>
	<meta name="description" content="fill in your temparature and answer covid related questions">
	<?php include "head.php";?>
	<script type="text/javascript">
		//connect index db
		var db;
		var request = window.indexedDB.open("visitorsDatabase", 1);
		request.onsuccess = function(event) {
        db = request.result;
        getData();
        console.log("success: "+ db);
    };
	</script>
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
			<tr id="row"></tr>
			<!-- <tr>
				<td id="name"></td>
				<td id="surname"></td>
				<td id="contact_no"></td>
				<td id="email"></td>
				<td id="wearing_mask"></td>
				<td id="covid_symptoms"></td>
				<td id="temperature"></td>
				<td id="time_in"></td>
				<td><input type="button" class="buttons" value="Update" name="" onclick="location.href='new_record.php'"></td>
			</tr>-->
			<tr>
				<td colspan="100%" style="text-align: center"><input type="button" id="new_record" class="buttons" name="" value="Add New Record" onclick="location.href='new_record.php'">&nbsp;</td>
			</tr>
			</table>
		</div>
	</section>
	<script type="text/javascript">
		function getData()
		{
			var transaction = db.transaction(['visitorsDatabase'], "readonly"); //initiate transaction
			var objectStore = transaction.objectStore("visitorsDatabase");//where the data is stored
			var requestData = objectStore.openCursor()// get info, all in the loop
			var row 	    = '';
			
			requestData.onsuccess = function(event)
			{
				var cursor = requestData.result;
				var counter = 0;
				if(cursor)
				{
					console.log(cursor);
					if(counter > 0) row += '<tr>';
					row += '<td>' + cursor.value.name + '</td>';
					row += '<td>' + cursor.value.surname + '</td>';
					row += '<td>' + cursor.value.contact_no + '</td>';
					row += '<td>' + cursor.value.email + '</td>';
					row += '<td></td>';
					row += '<td></td>';
					row += '<td>' + cursor.value.temperature +'</td>';
					row += '<td>' + cursor.value.hours + ':' + cursor.value.minutes +'</td><td></td>';
					row += '</tr>';

					counter+= 1;
					cursor.continue();
					return false;
				}
				document.getElementById("row").innerHTML += row;
			}
		}
	</script>
</body>
</html>
