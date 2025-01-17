<?php
$servername = "localhost"; 
$username = "root";
$password = ""; 
$dbname = "exam";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) die("Ошибка подключения: " . $conn->connect_error);

    $login = $_POST['login'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE login = '$login' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        header("Location: book_display.php");
        exit;
    } else {
        echo "<p>Неверный логин или пароль!</p>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Авторизация</h2>
    <form method="POST">
        <label>Логин:</label>
        <input type="text" name="login" required><br><br>
        <label>Пароль:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">Войти</button>
    </form>
</body>
</html>
