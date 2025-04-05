<?php
  session_start();
  if(isset($_POST["id"]) && isset($_POST["name"])) {
    $id = $_POST["id"];
    $name = trim($_POST["name"]);
    if(!ctype_digit($id) || $id < 1 || $id >= 2147483647) {
      $_SESSION["text"] = "Помилка: Код має бути від 1 до 2147483647.";
      $_SESSION["id"] = $id;
      $_SESSION["name"] = $name;
      header("Location: index.php");
      exit();
    }
    if(strlen($name) == 0 || strlen($name) >= 21) {
      $_SESSION["text"] = "Помилка: Назва має бути до 20 символів.";
      $_SESSION["id"] = $id;
      $_SESSION["name"] = $name;
      header("Location: index.php");
      exit();
    }
    try {
      $pdo = new PDO("mysql:dbname=films", "root");
      $sql = "INSERT INTO genre (id, name) VALUES (:id, :name);";
      $query = $pdo->prepare($sql);
      $query->execute(array(
        "id" => $id,
        "name" => $name
      ));
      $_SESSION["text"] = "Жанр додано.";
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
    $_SESSION["id"] = $id;
    $_SESSION["name"] = $name;
    header("Location: index.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="uk">
  <head>
    <meta charset="UTF-8">
    <title>Додати</title>
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
          Додати
        </nav>
      </div>
    </div>
    <main>
      <form method="post">
        <input type="number" min="1" max="2147483647" name="id" placeholder="Код" value="<?php if(isset($_SESSION["id"])) { echo($_SESSION["id"]); } ?>">
        <input type="text" maxlength="20" name="name" placeholder="Назва" value="<?php if(isset($_SESSION["name"])) { echo($_SESSION["name"]); } ?>">
        <input type="submit" value="Додати">
      </form>
      <?php if(isset($_SESSION["text"])) { ?>
      <?php echo("<p>" . $_SESSION["text"] . "</p>"); ?>
      <?php unset($_SESSION["text"]); ?>
      <?php } ?>
    </main>
  </body>
</html>