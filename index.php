<!DOCTYPE html>
<html>
<head>
	<title>Check In</title>
	<meta name="description" content="fill in your temparature and answer covid related questions">
	<?php include "head.php";?>
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
</head>
<body>
	<nav>
		<div class="container">	
			<h1>Covid Check-in</h1>
		</div>
	</nav>
	<section class="visitor_list">
		<div class="container">
			<h3>
				<span id="date"></span>
				<span id="hours"></span>
				<span id="seconds">:</span>
				<span id="minutes"></span>
			</h3>
			<div id="visitor_list_table">
				<table class="table" id="table">	
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
					<td colspan="100%" style="text-align: center"><input type="button" id="new_record" class="buttons" name="" value="Add New Record" onclick="location.href='new_record.php'">&nbsp;</td>
				</tr>
				</table>				
			</div>
		</div>
	</section>
	<script type="text/javascript">
		$(document).ready(function(){
			
			var months		= ["January","February","March","April","May","June","July","August","September","October","November","December"];
			var date_time 	= new Date();
			var month_no	= date_time.getMonth();
			var day			= date_time.getDate();
			var year		= date_time.getFullYear();
			var month 		= months[month_no];

			//set date
			
			$("#date").html(`${day} ${month} ${year}`);

			setInterval(function (){
				var date_time 	= new Date();
				var hours		= date_time.getHours();
				var minutes		= date_time.getMinutes();

				$("#hours").html(`${hours}`);
				$("#minutes").html(`${minutes}`);
				$("#seconds").html(`:`);
			},1000);

		});

		function getData()
		{
			var transaction = db.transaction(['visitor_details'], "readonly"); //initiate transaction
			var objectStore = transaction.objectStore("visitor_details");//where the data is stored
			var requestData = objectStore.openCursor()// get info, all in the loop
			var rowData 	= '';
			
			//build table 
			var table = '<table class="table" id="table"><tr><th>Firstname</th><th>Surname</th><th>Contact no</th><th>Email</th><th>Wearing Mask</th><th>Covid Symptons</th><th>Temperature</th><th>Time-in</th><th></th></tr>';

			requestData.onsuccess = function(event)
			{
				
				var cursor = requestData.result;
				var counter = 1;
				if(cursor)
				{
					console.log(cursor);
				//	if(counter > 0) row += '<tr>';
					table += '<tr><td>' + cursor.value.name + '</td>';
					table += '<td>' + cursor.value.surname + '</td>';
					table += '<td>' + cursor.value.contact_no + '</td>';
					table += '<td>' + cursor.value.email_id + '</td>';
					table += `<td>${cursor.value.covid_symptoms}</td>`;
					table += `<td>${cursor.value.covid_symptoms}</td>`;
					table += '<td>' + cursor.value.temperature +'</td>';
					table += '<td>' + cursor.value.hours + ':' + cursor.value.minutes +'</td>';
					table += `<td><input type="button" class="buttons" value="Update" onclick="location.href='update.php?email_id=${cursor.value.email_id}'"/>`;
					table += `<input type="button" value="Delete" onclick="if(confirm('Are you are')){location.href='delete.php?email_id=${cursor.value.email_id}'}" class="buttons" style="float:left"/>`;
					table += `</td>`;
					counter+= 1;
					cursor.continue();
					return false;
				}

				table += '<tr><td colspan="100%" style="text-align: center"><input type="button" id="new_record" class="buttons" name="" value="Add New Record" onclick="location.href=\'new_record.php\'">&nbsp;</td></tr></table>';

				document.getElementById("visitor_list_table").innerHTML = table;
			}
		}

	</script>
</body>
</html>
