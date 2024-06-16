<?php
require '../config/database.php';
require '../config/config.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
  header('Location: ../index.php');
  exit;
}

$db = new Database();
$con = $db->conectar();
