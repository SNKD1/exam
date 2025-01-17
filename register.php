<?php
$servername = "localhost"; 
$username = "root";
$password = ""; 
$dbname = "exam";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) die("Ошибка подключения: " . $conn->connect_error);

    $familiya = $_POST['familiya'];
    $imya = $_POST['imya'];
    $otchestvo = $_POST['otchestvo'];
    $data_rojd = $_POST['data_rojd'];
    $telephone = $_POST['telephone'];
    $login = $_POST['login'];
    $password = $_POST['password'];

    $sql_check = "SELECT * FROM user WHERE login = '$login'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        echo "Ошибка: Логин уже существует!";
    } else {
        $sql = "INSERT INTO user (familiya, imya, otchestvo, data_rojd, telephone, login, password) 
                VALUES ('$familiya', '$imya', '$otchestvo', '$data_rojd', '$telephone', '$login', '$password')";
        if ($conn->query($sql) === TRUE) {
            header("Location: login.php");
            exit();
        } else {
            echo "Ошибка: " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function validateForm() {
            let form = document.forms['registrationForm'];
            let errors = [];
            let familiya = form['familiya'].value.trim();
            let imya = form['imya'].value.trim();
            let otchestvo = form['otchestvo'].value.trim();
            let telephone = form['telephone'].value.trim();
            let login = form['login'].value.trim();
            let password = form['password'].value.trim();

            if (!familiya || !/^[a-zA-Zа-яА-ЯёЁ]+$/.test(familiya)) errors.push('Фамилия: только буквы.');
            if (!imya || !/^[a-zA-Zа-яА-ЯёЁ]+$/.test(imya)) errors.push('Имя: только буквы.');
            if (otchestvo && !/^[a-zA-Zа-яА-ЯёЁ]+$/.test(otchestvo)) errors.push('Отчество: только буквы.');
            if (!telephone || !/^\d{11}$/.test(telephone)) errors.push('Телефон: 11 цифр.');
            if (!login || !/^(?=.*[a-zA-Z])(?=.*\d).{6,}$/.test(login)) errors.push('Логин: минимум 6 символов, буква и цифра.');
            if (!password || !/^(?=.*[a-zA-Z])(?=.*\d).{6,}$/.test(password)) errors.push('Пароль: минимум 6 символов, буква и цифра.');

            if (errors.length > 0) {
                document.getElementById('errorMessages').innerHTML = errors.join('<br>');
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <h2>Регистрация</h2>
    <form name="registrationForm" method="POST" onsubmit="return validateForm()">
        <div id="errorMessages" style="color: red;"></div>
        <label>Фамилия:</label>
        <input type="text" name="familiya" required><br><br>
        <label>Имя:</label>
        <input type="text" name="imya" required><br><br>
        <label>Отчество:</label>
        <input type="text" name="otchestvo"><br><br>
        <label>Дата рождения:</label>
        <input type="date" name="data_rojd" required><br><br>
        <label>Телефон:</label>
        <input type="text" name="telephone"><br><br>
        <label>Логин:</label>
        <input type="text" name="login" required><br><br>
        <label>Пароль:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">Зарегистрироваться</button>
    </form>
</body>
</html>
