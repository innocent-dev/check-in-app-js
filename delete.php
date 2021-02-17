<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php include "head.php"?>
</head>
<body>
<script type="text/javascript">
	//connect index db
	var db;
	var v_url = window.location.search;
	var email_id = v_url.substring(10);

	var request = window.indexedDB.open("visitors_db", 3);

	request.onupgradeneeded = function()
	{
		//tables created here
		 var db = request.result;
		const visitorDetails = db.createObjectStore("visitor_details", {keyPath: "email_id"}); //more like a table
		
	}

	request.onsuccess = function(event)
	{
		db = request.result;
		var transaction = db.transaction("visitor_details", "readwrite");
		var objectStore = transaction.objectStore("visitor_details");
		var v_request	 	= objectStore.delete(email_id);

		v_request.onsuccess = function()
		{
			alert("Record deleted");
			window.location.href='index.php';
		}
	};
</script>
</body>
</html>