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
    );";
    $pdo->exec($sql);
    $text = "Створена база даних «" . $namedatabase . "».";
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
    else if($exception->errorInfo[1] == "1113") {
      $text = "Таблиця повинна мати принаймні 1 стовпець.";
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