<?php
	function query($query)
	{
		/*
			param: string query
			returns an array of results
		*/
		global $connection;
		$resuts = $connection->query($query);
		return $resuts;
		$connection->close();

	}

?>