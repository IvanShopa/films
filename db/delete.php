<?php
  $name = "films";
  try {
    $pdo = new PDO("mysql:", "root");
    $sql = "DROP DATABASE " . $name . ";";
    $pdo->exec($sql);
    $text = "Видалена база даних «" . $name . "».";
  }
  catch(PDOException $exception) {
    if($exception->errorInfo[1] == "2002") {
      $text = "Неможливо встановити з’єднання з базою даних.";
    }
    else if ($exception->errorInfo[1] == "1008") {
      $text = "База даних «" . $name . "» не існує.";
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