<?php
// Каталог на животни
$products = [
    [
        "name" => "Голдън ретривър",
        "price" => 350,
        "image" => "images/dog1.jpg"
    ],
    [
        "name" => "Немска овчарка",
        "price" => 500,
        "image" => "images/dog2.jpg"
    ],
    [
        "name" => "Хъски",
        "price" => 500,
        "image" => "images/husky.jpg"
    ],
    [
        "name" => "Британска котка",
        "price" => 250,
        "image" => "images/cat.jpg"
    ],
    [
        "name" => "Папагал Ара",
        "price" => 600,
        "image" => "images/parrot.jpg"
    ],
    [
        "name" => "Заек",
        "price" => 30,
        "image" => "images/rabbit.jpg"
    ],
    [
        "name" => "Хамстер",
        "price" => 20,
        "image" => "images/hamster.jpg"
    ]
];

// Функция за валидация на продукта
function isValidProduct($product) {
    return isset($product['name'], $product['price'], $product['image']) &&
           is_numeric($product['price']) &&
           $product['price'] > 0;
}

// Функция за безопасно екраниране на HTML
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Функция за проверка на изображението
function getImagePath($imagePath) {
    $fullPath = __DIR__ . '/' . $imagePath;
    
    // Проверка дали файлът съществува и е валидна картинка
    if (file_exists($fullPath) && getimagesize($fullPath) !== false) {
        return escape($imagePath);
    }
    
    // Fallback изображение ако оригиналното не съществува
    return 'images/placeholder.jpg';
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🐾 PetShop - Каталог</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- HEADER -->
    <header>
        <h1>🐾 PetShop</h1>
        <nav>
            <ul>
                <li><a href="index.php">Начало</a></li>
                <li><a href="catalog.php">Животни</a></li>
                <li><a href="cart.php">🛒 Количка</a></li>
                <li><a href="contact.php">Контакти</a></li>
            </ul>
        </nav>
    </header>

    <!-- MAIN CONTENT -->
    <main>
        <section id="catalog">
            <h2>🐶 Каталог животни</h2>
            
            <div class="products">
                <?php foreach ($products as $product): ?>
                    <?php if (isValidProduct($product)): ?>
                        <div class="product">
                            <img 
                                src="<?= getImagePath($product['image']); ?>" 
                                alt="<?= escape($product['name']); ?>"
                            >
                            
                            <!-- ✅ ПОПРАВЕНО: Сега показва името на продукта -->
                            <h3><?= escape($product['name']); ?></h3>
                            
                            <!-- ✅ ПОПРАВЕНО: Сега показва цената -->
                            <p><?= number_format($product['price'], 2, ',', ' '); ?> лв</p>
                            
                            <!-- ✅ Бутон за добавяне в количка -->
                            <button 
                                onclick="addToCart('<?= escape($product['name']); ?>', <?= (int)$product['price']; ?>)"
                                class="btn"
                            >
                                Добави в количка
                            </button>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- Ако няма продукти -->
            <?php if (empty(array_filter($products, 'isValidProduct'))): ?>
                <p style="text-align: center; margin-top: 20px;">❌ Няма налични продукти.</p>
            <?php endif; ?>
        </section>
    </main>

    <!-- FOOTER -->
    <footer>
        <p>© 2026 PetShop - Всички права запазени.</p>
        <p>📧 Email: petshop@example.com | 📞 Телефон: +359 88 123 45 67</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>

