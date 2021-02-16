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
		alert("upgrade is completed and success is called");
	}

	request.onerror = function()
	{
		alert("upgrade is created");
	}
}