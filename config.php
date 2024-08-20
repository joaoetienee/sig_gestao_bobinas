<?php
$servername = "localhost";
$username = "root";
$password = "adminjoao";
$dbname = "gestao_pedidos_bobinas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>