<?php
$server = "localhost:3307";
$bd = "juegos1";
$user = "root";
$pass = "";

$conn = mysqli_connect($server, $user, $pass, $bd);

if (!$conn) {
	return $conn;
}
?>