// ✅ Валидация на продукта със подобрена логика
function isValidProduct(name, price) {
    if (typeof name !== 'string' || name.trim() === '') {
        console.error('❌ Невалидно име на продукт');
        return false;
    }
    if (typeof price !== 'number' || price <= 0) {
        console.error('❌ Невалидна цена');
        return false;
    }
    return true;
}

// ✅ Добавяне в количка със подобрена защита
function addToCart(name, price) {
    // Валидация
    if (!isValidProduct(name, price)) {
        showNotification('❌ Грешка при добавяне на продукт', 'error');
        return;
    }

    try {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];

        // ✅ ПОПРАВКА 1: Брои ОБЩИЯ брой животни, не позиции
        let totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
        if (totalItems >= 100) {
            showNotification('❌ Максимално 100 животни в количката', 'error');
            return;
        }

        // ✅ ПОПРАВКА 2: Проверка за вече съществуващ продукт
        let existing = cart.find(item => 
            item.name === name.trim() && item.price === price
        );

        if (existing) {
            // ✅ ПОПРАВКА 3: Максимален лимит за един продукт (50)
            if (existing.qty >= 50) {
                showNotification(`❌ Максимално 50 на един продукт!`, 'error');
                return;
            }
            existing.qty += 1;
        } else {
            cart.push({
                name: name.trim(),
                price: price,
                qty: 1
            });
        }

        localStorage.setItem("cart", JSON.stringify(cart));
        showNotification(`✅ "${name}" е добавен в количката! 🛒`, 'success');
        updateCartCount();

    } catch (error) {
        console.error('❌ Грешка при добавяне в количка:', error);
        
        // ✅ ПОПРАВКА 4: Проверка дали е localStorage full
        if (error.name === 'QuotaExceededError') {
            showNotification('❌ Количката е пълна - изчистете я или я изпратете', 'error');
        } else {
            showNotification('❌ Грешка при добавяне - опитайте отново', 'error');
        }
    }
}

// ✅ Красива нотификация със правилен timing
function showNotification(message, type = 'success') {
    // ✅ ПОПРАВКА 5: Предотвратяване на множество нотификации
    let existingNotifications = document.querySelectorAll('.notification');
    if (existingNotifications.length > 5) {
        existingNotifications[0].remove();
    }

    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    notification.setAttribute('role', 'alert'); // ✅ Accessibility
    
    document.body.appendChild(notification);

    // Слайдва от дясно
    setTimeout(() => notification.classList.add('show'), 10);

    // Изчезва след 3 секунди
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// ✅ Обновяване на брой в хедъра (ако съществува)
function updateCartCount() {
    try {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        let cartBadge = document.querySelector('.cart-badge');
        
        // ✅ ПОПРАВКА 6: Брой ВСИЧКИ животни, не позиции
        let totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
        
        if (cartBadge) {
            cartBadge.textContent = totalItems;
            if (totalItems === 0) {
                cartBadge.style.display = 'none';
            } else {
                cartBadge.style.display = 'inline-block';
            }
        }
    } catch (error) {
        console.error('❌ Грешка при обновяване на брой:', error);
    }
}

// ✅ CSS за нотификациите (добавя в style.css)
document.addEventListener('DOMContentLoaded', function() {
    const style = document.createElement('style');
    style.textContent = `
        .notification {
            position: fixed;
            top: 20px;
            right: -400px;
            background: #4caf50;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            font-weight: bold;
            z-index: 1000;
            transition: right 0.3s ease;
            max-width: 300px;
            word-wrap: break-word;
        }

        .notification.show {
            right: 20px;
        }

        .notification.error {
            background: #f44336;
        }

        .notification.success {
            background: #4caf50;
        }

        .notification.warning {
            background: #ff9800;
        }
    `;
    document.head.appendChild(style);
    updateCartCount();
});

// ✅ Очистване на количка със потвърждение
function clearCart() {
    if (confirm('Сигурен ли си че искаш да изчистиш количката?')) {
        try {
            localStorage.removeItem('cart');
            showNotification('✅ Количката е изчистена', 'success');
            updateCartCount();
            // ✅ ПОПРАВКА 7: Задържане на страницата за 1 сек преди refresh
            setTimeout(() => location.reload(), 1000);
        } catch (error) {
            console.error('❌ Грешка при изчистване:', error);
            showNotification('❌ Грешка при изчистване', 'error');
        }
    }
}

// ✅ Премахване на продукт от количка
function removeFromCart(productName) {
    try {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        
        // ✅ ПОПРАВКА 8: Намиране на точния продукт преди изтриване
        let initialLength = cart.length;
        cart = cart.filter(item => item.name !== productName);
        
        if (cart.length === initialLength) {
            showNotification('❌ Продуктът не е намерен', 'error');
            return;
        }
        
        localStorage.setItem("cart", JSON.stringify(cart));
        showNotification(`✅ Продуктът е премахнат`, 'success');
        updateCartCount();
        setTimeout(() => location.reload(), 1000);
    } catch (error) {
        console.error('❌ Грешка при премахване:', error);
        showNotification('❌ Грешка при премахване', 'error');
    }
}

// ✅ Обновяване на количество със защита
function updateQty(productName, newQty) {
    newQty = parseInt(newQty);
    
    // ✅ ПОПРАВКА 9: Проверка за валидно число
    if (isNaN(newQty)) {
        showNotification('❌ Невалидно количество', 'error');
        return;
    }
    
    if (newQty < 1) {
        removeFromCart(productName);
        return;
    }

    // ✅ ПОПРАВКА 10: Максимален лимит за един продукт (50)
    if (newQty > 50) {
        showNotification('❌ Максимално 50 на един продукт', 'error');
        return;
    }

    try {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        let product = cart.find(item => item.name === productName);
        
        if (product) {
            product.qty = newQty;
            localStorage.setItem("cart", JSON.stringify(cart));
            showNotification('✅ Количество обновено', 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification('❌ Продуктът не е намерен', 'error');
        }
    } catch (error) {
        console.error('❌ Грешка при обновяване:', error);
        showNotification('❌ Грешка при обновяване', 'error');
    }
}

// ✅ НОВО: Функция за получаване на сумата на количката
function getCartTotal() {
    try {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        return cart.reduce((total, item) => total + (item.price * item.qty), 0);
    } catch (error) {
        console.error('❌ Грешка при изчисляване на сумата:', error);
        return 0;
    }
}

// ✅ НОВО: Функция за получаване на брой артикули
function getCartItemCount() {
    try {
        let cart = JSON.parse(localStorage.getItem("cart")) || [];
        return cart.reduce((sum, item) => sum + item.qty, 0);
    } catch (error) {
        console.error('❌ Грешка при броене:', error);
        return 0;
    }
}
