<?php
  try {
    $page = isset($_GET["page"]) ? max(1, (int)$_GET["page"]) : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;
    $pdo = new PDO("mysql:dbname=films", "root");
    $sql = "SELECT id, name FROM genre ORDER BY id LIMIT $limit OFFSET $offset";
    $query1 = $pdo->query($sql);
    $genres = $query1->fetchAll();
    $sql = "SELECT COUNT(*) FROM genre;";
    $query2 = $pdo->query($sql);
    $number1 = $query2->fetchColumn();
    $number2 = ceil($number1 / $limit);
  }
  catch (PDOException $exception) {
    if($exception->errorInfo[1] == "2002") {
      $error = "Помилка: Неможливо встановити з’єднання з базою даних.";
    }
    else if($exception->errorInfo[1] == "1049") {
      $error = "Помилка: Невідома база даних.";
    }
    else if($exception->errorInfo[1] == "1146") {
      $error = "Помилка: Таблиця не існує.";
    }
    else if($exception->errorInfo[1] == "1064") {
      $error = "Помилка: Помилка в синтаксисі SQL.";
    }
    else {
      $error = $exception;
    }
  }
?>
<!DOCTYPE html>
<html lang="uk">
  <head>
    <meta charset="UTF-8">
    <title>Жанр</title>
    <link rel="icon" href="../../images/icons/icon.png">
    <link rel="stylesheet" href="../../styles/style.css">
  </head>
  <body>
    <div class="container-1-nav">
      <div class="container-2-nav">
        <nav>
          <a class="link" href="../../index.php">Головна</a> /
          <a class="link" href="../index.php">Налаштування</a> /
          Жанр
        </nav>
      </div>
    </div>
    <main>
      <?php if(isset($error)): ?>
      <p><?php echo($error); ?></p>
      <?php else: ?>
      <a class="button" href="add/index.php">Додати</a>
      <?php if(!empty($genres)): ?>
      <div class="container-1-table">
        <div class="container-2-table">
          <table>
            <tbody>
              <tr>
                <td>Код</td>
                <td style="width: 100%;">Назва</td>
                <td style="background-color: white;"></td>
                <td style="background-color: white;"></td>
              </tr>
              <?php foreach($genres as $genre): ?>
              <tr>
                <td><?php echo($genre["id"]); ?></td>
                <td><?php echo($genre["name"]); ?></td>
                <td><a class="link" href="edit/index.php?id=<?php echo($genre["id"]); ?>">Редагувати</a></td>
                <td><a class="link" href="delete/index.php?id=<?php echo($genre["id"]); ?>">Видалити</a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <?php if($page < $number2): ?>
      <a class="button" href="?page=<?php echo($page + 1); ?>">Далі</a>
      <?php endif; ?>
      <?php if ($page > 1): ?>
      <a class="button" href="?page=<?php echo($page - 1); ?>">Назад</a>
      <?php endif; ?>
      <?php endif; ?>
      <?php endif; ?>
    </main>
  </body>
</html>