<?php
  $pdo = new PDO("mysql:dbname=films", "root");
  $sql = "DELETE FROM genre WHERE id = :id;";
  $query = $pdo->prepare($sql);
  $query->execute(array(
    "id" => $_GET["id"]
  ));
  header("Location: ../index.php");
  exit();
?>