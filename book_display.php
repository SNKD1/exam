<?php
$servername = "localhost"; 
$username = "root";
$password = ""; 
$dbname = "exam";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Ошибка подключения: " . $conn->connect_error);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $published_year = $_POST['published_year'];

    $sql = "INSERT INTO book (title, author, published_year) 
            VALUES ('$title', '$author', '$published_year')";
    
    if ($conn->query($sql) !== TRUE) {
        echo "Ошибка: " . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM book");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Книги</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function validateForm() {
            const form = document.forms['bookForm'];
            const errors = [];
            const title = form['title'].value.trim();
            const author = form['author'].value.trim();
            const publishedYear = form['published_year'].value.trim();
            const currentYear = new Date().getFullYear();
              //const price = form['price'].value.trim();

            if (!title) errors.push('Название книги не может быть пустым.');

            if (!author || !/^[a-zA-Zа-яА-ЯёЁ\s]+$/.test(author)) {
                errors.push('Автор должен содержать только буквы и пробелы.');
            }
            if (!publishedYear || isNaN(publishedYear) || publishedYear < 1000 || publishedYear > currentYear) {
                errors.push(`Год публикации должен быть числом от 1000 до ${currentYear}.`);
            }
              //if (!price || !/^\d+$/.test(price)) {
               // errors.push('Цена должна содержать только целые числа.');
            //}
        
            if (errors.length > 0) {
                document.getElementById('errorMessages').innerHTML = errors.join('<br>');
                return false;
            }

            return true; 
        }
    </script>
</head>
<body>
    <h2>Список книг</h2>
    <table border="1">
        <tr>
            <th>Название книги</th>
            <th>Автор</th>
            <th>Год публикации</th>
         
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['title']}</td>
                        <td>{$row['author']}</td>
                        <td>{$row['published_year']}</td>";
            }
        } else {
            echo "<tr><td colspan='3'>Нет книг</td></tr>";
        }
        ?>
    </table>

    <h2>Добавить новую книгу</h2>
    <form name="bookForm" method="POST" onsubmit="return validateForm()">
        <div id="errorMessages" style="color: red; margin-bottom: 10px;"></div>
        <label>Название книги:</label>
        <input type="text" name="title" required><br><br>
        <label>Автор:</label>
        <input type="text" name="author" required><br><br>
        <label>Год публикации:</label>
        <input type="number" name="published_year" required min="1000" max="<?php echo date('Y'); ?>"><br><br>
        <button type="submit">Добавить книгу</button>
    </form>

</body>
</html>

<?php $conn->close(); ?>
