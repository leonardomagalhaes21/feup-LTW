<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/users.class.php');

  $db = getDatabaseConnection();

  $user = User::getCustomerWithPassword($db, $_POST['email'], $_POST['password']);

  if ($customer) {
    $session->setId($user->idUser);
    $session->setName($user->name());
    $session->addMessage('success', 'Login successful!');
  } 
  else {
    $session->addMessage('error', 'Wrong password!');
  }

  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>