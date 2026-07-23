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

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #2c1810;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 5%;
        }

        header {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
        }

        nav {
            width: 100%;
            margin-bottom: 2%;
        }

        nav div {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        nav a {
            color: aliceblue;
            text-decoration: none;
            font-size: clamp(16px, 3vw, 24px);
            padding: 5px 10px;
        }

        header a {
            color: aliceblue;
            text-decoration: none;
        }

        .namemain {
            font-family: 'Henny Penny';
            color: aliceblue;
            font-size: clamp(40px, 8vw, 80px);
            margin-top: 2%;
            text-align: center;
        }

        .feedback-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            font-family: 'Neucha';
        }

        .feedback-section h2 {
            font-size: clamp(22px, 3vw, 30px);
            color: #2c1810;
            text-align: center;
            margin-bottom: 20px;
        }

        .feedback-section form {
            max-width: 600px;
            margin: 0 auto;
        }

        .feedback-section form p {
            margin: 15px 0;
            font-size: clamp(16px, 2vw, 20px);
        }

        .feedback-section form input,
        .feedback-section form textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid rgb(111, 170, 176);
            border-radius: 8px;
            font-size: clamp(14px, 1.5vw, 18px);
            font-family: 'Neucha';
            box-sizing: border-box;
        }

        .feedback-section form textarea {
            resize: vertical;
            min-height: 120px;
        }

        .feedback-section form button {
            background: rgb(111, 170, 176);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: clamp(16px, 2vw, 20px);
            font-family: 'Neucha';
            cursor: pointer;
            transition: background 0.3s;
            width: 100%;
        }

        .feedback-section form button:hover {
            background: #2c1810;
        }

        hr {
            color: rgb(111, 170, 176);
            width: 70%;
            margin: 30px auto;
            border: 1px solid rgb(111, 170, 176);
        }

        .comments-list {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            font-family: 'Neucha';
        }

        .comments-list h2 {
            font-size: clamp(22px, 3vw, 30px);
            color: #2c1810;
            text-align: center;
            margin-bottom: 20px;
        }

        .comment-item {
            margin-bottom: 15px;
            border: 1px solid rgb(111, 170, 176);
            background-color: white;
            padding: 15px;
            border-radius: 8px;
        }

        .comment-item h5 {
            font-size: clamp(18px, 2vw, 22px);
            color: #2c1810;
            margin-bottom: 5px;
        }

        .comment-item p {
            font-size: clamp(16px, 1.8vw, 20px);
            color: #333;
            margin: 0;
        }

        .no-comments {
            text-align: center;
            font-size: clamp(16px, 2vw, 20px);
            color: #666;
            padding: 20px 0;
        }

        @media (max-width: 768px) {
            nav div {
                gap: 10px;
            }

            .feedback-section {
                padding: 15px;
            }

            .feedback-section form {
                padding: 0 10px;
            }

            .comments-list {
                padding: 15px;
            }

            .comment-item {
                padding: 12px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 3%;
            }

            .feedback-section {
                padding: 10px;
            }

            .feedback-section form p {
                margin: 10px 0;
            }

            .feedback-section form input,
            .feedback-section form textarea {
                padding: 10px;
            }

            .comments-list {
                padding: 10px;
            }

            .comment-item {
                padding: 10px;
            }
        }
    </style>

</head>
<body>


<div class="container">
<header>
  <nav>
    <div>
    <a href="main.html">Главная</a>
    <a href="contacts.html">Контакты</a>
    <a href="bron.html">Цены</a>
    <a href="feedback.php">Отзывы</a>
    </div>
  </nav>
  <a style="font-size: clamp(30px, 6vw, 60px); color: aliceblue;">&#10039</a>
  <a class="namemain">AliceCafe</a>
  <a style="font-size: clamp(30px, 6vw, 60px); color: aliceblue;">&#10039</a>
</header>

<div class="feedback-section">
    <h2>Оставьте отзыв!</h2>
    <form method="POST">
        <p>
            Ваше имя:<br>
            <input type="text" name="name" required>
        </p>
        <p>
            Отзыв:<br>
            <textarea rows="10" name="comment" required></textarea>
        </p>
        <p>
            <button type="submit">Отправить</button>
        </p>
    </form>
</div>

<hr>

<div class="comments-list">
    <h2>Список отзывов</h2>
    <?php
    $result = $mysqli->query("SELECT name, comment FROM comments ORDER BY id DESC");
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='comment-item'>";
            echo "<h5>" . htmlspecialchars($row['name']) . "</h5>";
            echo "<p>" . htmlspecialchars($row['comment']) . "</p>";
            echo "</div>";
        }
        $result->free();
    } else {
        echo "<p class='no-comments'>Пока нет комментариев.</p>";
    }

    $mysqli->close();
    ?>
</div>

</div>

<script>
navigator.serviceWorker?.register('/sw.js');
</script>

</body>
</html>