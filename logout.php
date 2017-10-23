<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/socialnetwork/core/init2.php';
  unset($_SESSION['ABuser']);
  header('Location: login.php');
  ?>