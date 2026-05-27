<?php
include "db.php";

$result = $conn->query("SELECT * FROM cart");
$total = 0;
?>

<!DOCTYPE html>
<html lang="bg">
<head>
<meta charset="UTF-8">
<title>Количка</title>
</head>
<body>

<h2>🛒 Твоята количка</h2>

<ul>
<?php while($row = $result->fetch_assoc()): ?>
    <li>
        <?= $row['name'] ?> x<?= $row['qty'] ?> - <?= $row['price'] ?> лв
    </li>
    <?php $total += $row['price'] * $row['qty']; ?>
<?php endwhile; ?>
</ul>

<h3>Общо: <?= $total ?> лв</h3>

<form action="clear.php" method="post">
    <button type="submit">🗑 Изчисти количката</button>
</form>

<a href="catalog.php">⬅ Назад към каталога</a>

</body>
</html>