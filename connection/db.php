<?php
//DEFINE THE DATABASE CONNECTION VARIABLES
$servername = "localhost";
$username = "root";
$password = "";
$databaseName = "self_made";

//FUNCTION TO CONNECT TO THE DATABASE
function connect(){
    $conn = new mysqli($servername, $username, $password, $databaseName);
    return $conn;
}

//FUNCTION TO DISCONNECT FROM THE DATABASE
function disconnect($conn){
    $conn->close();
}


?>