<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();
  $session->logout();

  //ver melhor esta linha em baixo com o $_SERVER['HTTP_REFERER']
  header('Location: ../pages/index.php');
?>