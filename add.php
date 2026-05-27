<?php
include "db.php";

$name = $_POST['name'];
$price = $_POST['price'];

$sql = "INSERT INTO cart (name, price, qty)
VALUES ('$name', '$price', 1)";

$conn->query($sql);

header("Location: cart.php");
exit;
?>