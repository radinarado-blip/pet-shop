// Показване на повече информация
function showInfo(name, age, price) {
    alert(
        "Животно: " + name +
        "\nВъзраст: " + age +
        "\nЦена: " + price
    );
}

// Търсене на животни
function searchAnimals() {
    let input = document.getElementById("search").value.toLowerCase();
    let animals = document.getElementsByClassName("animal");

    for (let i = 0; i < animals.length; i++) {
        let text = animals[i].innerText.toLowerCase();

        if (text.includes(input)) {
            animals[i].style.display = "inline-block";
        } else {
            animals[i].style.display = "none";
        }
    }
}

// Филтриране по категория
function filterAnimals(type) {
    let animals = document.getElementsByClassName("animal");

    for (let i = 0; i < animals.length; i++) {
        if (type === "all") {
            animals[i].style.display = "inline-block";
        } else if (animals[i].classList.contains(type)) {
            animals[i].style.display = "inline-block";
        } else {
            animals[i].style.display = "none";
        }
    }
}

// Съобщение при форма
function submitForm() {
    alert("Обявата е добавена успешно!");
}