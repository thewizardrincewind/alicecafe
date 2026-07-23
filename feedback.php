
<?php
$mysqli = new mysqli("localhost", "root", "AA2507gubkin", "commentsdb");

if ($mysqli->connect_errno) {
    echo "Не удалось подключиться" . $mysqli->connect_error;
    exit();
}
$mysqli->set_charset("utf8mb4");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $comment = $_POST['comment'] ?? '';

    if ($name !== '' && $comment !== '') {
        $stmt = $mysqli->prepare("INSERT INTO comments (name, comment) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $comment);
        $stmt->execute();
        $stmt->close();
        
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="manifest" href="/manifest.json">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отзывы</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Henny+Penny&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Neucha&display=swap" rel="stylesheet">

</head>
<body>


<div class="container">
<header>
  <nav style="margin-bottom: 2%;">
    <div>
    <a href="main.html", style="color: aliceblue;">Главная</a>
    <a href="contacts.html", style="color: aliceblue;">Контакты</a>
    <a href="bron.html", style="color: aliceblue;">Цены</a>
    <a href="feedback.html", style="color: aliceblue;">Отзывы</a>
    </div>
  </nav>
  <a style="font-size: 50px; color: aliceblue;">&#10039</a>
  <a class="namemain", style="font-family: 'Henny Penny'; color: aliceblue; font-size: 60px;margin-top: 2%;">AliceCafe</a1>
  <a style="font-size: 50px; color: aliceblue;">&#10039</a>
</header>


    <h2>Оставьте отзыв!</h2>
    <form method="POST">
        <p>
            Ваше имя:<br>
            <input type="text" name="name" required>
        </p>
        <p>
            Отзыв:<br>
            <textarea rows="10" cols="60" name="comment" required></textarea>
        </p>
        <p>
            <button type="submit" class="floating-button">Отправить</button>
        </p>
    </form>

   <hr style="color: rgb(111, 170, 176); width: 70%;">

    <h2>Список отзывов</h2>
    <?php
    $result = $mysqli->query("SELECT name, comment FROM comments ORDER BY id DESC");
    
    if ($result && $result->num_rows > 0) { // проверка что строк в таблице больше нуля
        while ($row = $result->fetch_assoc()) { // извлечение строки таблицы row как массива, если строки еще есть
            echo "<div style='margin-bottom: 15px; border: 1px solid rgb(111, 170, 176); background-color:white; padding-bottom: 10px;'>";
            echo "<h5>" . $row['name'] . "</5> ";
            echo "<p>" . $row['comment'] . "</p>";
            echo "</div>";
        }
        $result->free(); // очистка памяти
    } else {
        echo "<p>Пока нет комментариев.</p>";
    }

    $mysqli->close();
    ?>

</body>
</html>


</div>

<script>
navigator.serviceWorker?.register('/sw.js');
</script>

</body>
</html>