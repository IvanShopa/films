<?php
  $namedatabase = "films";
  $nametable = "genre";
  try {
    $pdo = new PDO("mysql:", "root");
    $sql = "CREATE DATABASE IF NOT EXISTS " . $namedatabase  . ";
    USE " . $namedatabase . ";
    CREATE TABLE IF NOT EXISTS " . $nametable . " (
      id INT PRIMARY KEY,
      name VARCHAR(20) UNIQUE
    );
    INSERT INTO " . $nametable . " VALUES
    (1, 'Комедія'),
    (2, 'Фантастика'),
    (3, 'Бойовик'),
    (4, 'Мелодрама'),
    (5, 'Містика'),
    (6, 'Детектив'),
    (7, 'Драма'),
    (8, 'Жах'),
    (9, 'Трилер'),
    (10, 'Фентезі'),
    (11, 'Аніме'),
    (12, 'Кримінал'),
    (13, 'Мультфільм'),
    (14, 'Історичний'),
    (15, 'Воєнний'),
    (16, 'Документальний'),
    (17, 'Мюзикл'),
    (18, 'Пригодницький'),
    (19, 'Біографічний'),
    (20, 'Художній'),
    (21, 'Кіберпанк'),
    (22, 'Екшн'),
    (23, 'Вестерн'),
    (24, 'Антиутопія'),
    (25, 'Катастрофи'),
    (26, 'Сиквел'),
    (27, 'Утопія');";
    $pdo->exec($sql);
    $text = "Додано дані до таблиці «" . $nametable . "».";
  }
  catch(PDOException $exception) {
    if($exception->errorInfo[1] == "2002") {
      $text = "Неможливо встановити з’єднання з базою даних.";
    }
    else if ($exception->errorInfo[1] == "1046") {
      $text = "Не вибрано базу даних.";
    }    
    else if ($exception->errorInfo[1] == "1049") {
      $text = "Невідома база даних «" . $namedatabase . "».";
    }
    else if ($exception->errorInfo[1] == "1146") {
      $text = "Таблиця «" . $nametable . "» не існує.";
    }
    else if (strpos($exception->errorInfo[2], "PRIMARY") != false) {
      $text = "Такий код вже існує.";
    }
    else if (strpos($exception->errorInfo[2], "name") != false) {
      $text = "Така назва вже існує.";
    }
    else if ($exception->errorInfo[1] == "1064") {
      $text = "Помилка в синтаксисі SQL.";
    }
    else {
      $text = $exception;
    }
  }
?>
<!DOCTYPE html>
<html lang="uk">
  <head>
    <meta charset="UTF-8">
    <title>DB</title>
    <link rel="icon" href="../images/icons/icon.png">
    <link rel="stylesheet" href="../styles/style.css">
  </head>
  <body>
    <main>
      <p style="text-align: center;"><?php echo($text); ?></p>
    </main>
  </body>
</html>