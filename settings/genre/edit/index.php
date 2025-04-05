<?php
  session_start();
  if(isset($_GET["id"])) {
    $id = $_GET["id"];
    if(!ctype_digit($id) || $id < 1 || $id >= 2147483647) {
      $_SESSION["text"] = "Помилка: Код має бути від 1 до 2147483647.";
      header("Location: index.php?id=" . $id2);
      exit();
    }
    try {
      $pdo = new PDO("mysql:dbname=films", "root");
      $sql = "SELECT * FROM genre WHERE id = :id";
      $query = $pdo->prepare($sql);
      $query->execute(array(
        "id" => $id
      ));
      $genre = $query->fetch();
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
  }
  if(isset($_POST["id"]) && isset($_POST["name"]) && isset($_GET["id"])) {
    $id1 = $_POST["id"];
    $name = trim($_POST["name"]);
    $id2 = $_GET["id"];
    if(!ctype_digit($id1) || $id1 < 1 || $id1 >= 2147483647) {
      $_SESSION["text"] = "Помилка: Код має бути від 1 до 2147483647.";
      $_SESSION["id"] = $id1;
      $_SESSION["name"] = $name;
      header("Location: index.php?id=" . $id2);
      exit();
    }
    if(!ctype_digit($id2) || $id2 < 1 || $id2 >= 2147483647) {
      $_SESSION["text"] = "Помилка: Код має бути від 1 до 2147483647.";
      $_SESSION["id"] = $id1;
      $_SESSION["name"] = $name;
      header("Location: index.php?id=" . $id2);
      exit();
    }
    if(strlen($name) == 0 || strlen($name) >= 21) {
      $_SESSION["text"] = "Помилка: Назва має бути до 20 символів.";
      $_SESSION["id"] = $id1;
      $_SESSION["name"] = $name;
      header("Location: index.php?id=" . $id2);
      exit();
    }
    try {
      $pdo = new PDO("mysql:dbname=films", "root");
      $sql = "UPDATE genre SET id = :id1, name = :name WHERE id = :id2;";
      $query = $pdo->prepare($sql);
      $query->execute(array(
        "id1" => $id1,
        "name" => $name,
        "id2" => $id2
      ));
      $_SESSION["text"] = "Жанр відредаговано.";
    }
    catch(PDOException $exception) {
      if($exception->errorInfo[1] == "2002") {
        $_SESSION["text"] = "Помилка: Неможливо встановити з’єднання з базою даних.";
      }
      else if($exception->errorInfo[1] == "1046") {
        $_SESSION["text"] = "Помилка: Не вибрано базу даних.";
      }    
      else if($exception->errorInfo[1] == "1049") {
        $_SESSION["text"] = "Помилка: Невідома база даних.";
      }
      else if($exception->errorInfo[1] == "1146") {
        $_SESSION["text"] = "Помилка: Таблиця не існує.";
      }
      else if(strpos($exception->errorInfo[2], "PRIMARY") != false) {
        $_SESSION["text"] = "Помилка: Такий код вже існує.";
      }
      else if(strpos($exception->errorInfo[2], "name") != false) {
        $_SESSION["text"] = "Помилка: Така назва вже існує.";
      }
      else if($exception->errorInfo[1] == "1064") {
        $_SESSION["text"] = "Помилка: Помилка в синтаксисі SQL.";
      }
      else {
        $_SESSION["text"] = $exception;
      }
    }
    $_SESSION["id"] = $id1;
    $_SESSION["name"] = $name;
    header("Location: index.php?id=" . $id2);
    exit();
  }
?>
<!DOCTYPE html>
<html lang="uk">
  <head>
    <meta charset="UTF-8">
    <title>Редагувати</title>
    <link rel="icon" href="../../../images/icons/icon.png">
    <link rel="stylesheet" href="../../../styles/style.css">
  </head>
  <body>
    <div class="container-1-nav">
      <div class="container-2-nav">
        <nav>
          <a class="link" href="../../../index.php">Головна</a> /
          <a class="link" href="../../index.php">Налаштування</a> /
          <a class="link" href="../index.php">Жанр</a> /
          Редагувати
        </nav>
      </div>
    </div>
    <main>
      <form method="post">
        <input type="number" min="1" max="2147483647" name="id" placeholder="Код" value="<?php if(isset($_SESSION["id"])) { echo($_SESSION["id"]); unset($_SESSION["id"]); } else { echo($genre["id"]); } ?>">
        <input type="text" maxlength="20" name="name" placeholder="Назва" value="<?php if(isset($_SESSION["name"])) { echo($_SESSION["name"]); unset($_SESSION["name"]); } else { echo($genre["name"]); } ?>">
        <input type="submit" value="Редагувати">
      </form>
      <?php if(isset($_SESSION["text"])) { ?>
      <?php echo("<p>" . $_SESSION["text"] . "</p>"); ?>
      <?php unset($_SESSION["text"]); ?>
      <?php } ?>
    </main>
  </body>
</html>