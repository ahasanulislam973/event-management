<?php
$dbhost="localhost";
$dbuser="root";
$dbpass="";
$dbname="event-management";
$conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if(!$conn){

    die("Failed to connect");
}