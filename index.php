<?php
session_start();

// Функция за екраниране на текст (XSS защита)
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Брой продукти в количката
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop - Начало</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="container">
        <h1>🐾 PetShop</h1>
        
        <nav>
            <ul>
                <li><a href="index.php">Начало</a></li>
                <li><a href="catalog.php">Животни</a></li>
                <li>
                    <a href="cart.php">
                        🛒 Количка
                        <?php if ($cartCount > 0): ?>
                            <span class="cart-badge"><?= escape((string)$cartCount) ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li><a href="contact.php">Контакти</a></li>
            </ul>
        </nav>
    </div>
</header>

<main>
    <div class="container">
        <div class="hero">
            <h2>🐕 Добре дошли в PetShop! 🐱</h2>
            <p>Откройте вашия нов любимец - широк избор на здрави и хубави животни, готови за любящо дом.</p>
            
            <div class="hero-buttons">
                <a href="catalog.php" class="btn btn-primary">🛍️ Вижте каталога</a>
                <a href="contact.php" class="btn btn-secondary">📞 Свържете се с нас</a>
            </div>

            <div class="stats">
                <div class="stat-box">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Животни</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Здрави</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Поддръжка</div>
                </div>
            </div>
        </div>

        <div class="features">
            <div class="feature-card">
                <h3>✅ Гарантирана качество</h3>
                <p>Всички животни са преминали здравни прегледи и са напълно здрави и готови за нов дом.</p>
            </div>

            <div class="feature-card">
                <h3>🚚 Бързо доставляне</h3>
                <p>Доставяме вашия питомец бързо и безопасно с професионални превозвачи.</p>
            </div>

            <div class="feature-card">
                <h3>💚 Грижа след покупка</h3>
                <p>Получавате пълна поддръжка и съветване за грижата на вашия нов приятел.</p>
            </div>

            <div class="feature-card">
                <h3>🎁 Специални оферти</h3>
                <p>Редовни намаления и подарки за верни клиенти. Регистрирайте се сега!</p>
            </div>

            <div class="feature-card">
                <h3>📋 Документи</h3>
                <p>Получавате всички необходими документи и сертификати за животното.</p>
            </div>

            <div class="feature-card">
                <h3>🔒 Защита на данни</h3>
                <p>Ваши лични данни са напълно защитени и не се споделят с трети лица.</p>
            </div>
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2026 PetShop - Всички права запазени.</p>
    <p>📧 Email: petshop@example.com | 📞 Телефон: +359 88 123 45 67</p>
    <p>🏪 Адрес: ул. "Животинска" 42, София 1000</p>
</footer>

</body>
</html>