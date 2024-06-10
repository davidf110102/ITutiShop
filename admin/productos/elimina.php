<?php
require  '../config/database.php';
require  '../config/config.php';

if (!isset($_SESSION['user_type'])) {
    header('Location: ../index.php');
    exit;
}

if ($_SESSION['user_type'] != 'admin') {
    header('Location: ../../index.php');
    exit;
}

$db = new Database();
$con = $db->conectar();

$id = $_POST['id'];

$sql = $con->prepare("UPDATE productos SET activo = 0 WHERE id = ?");
$sql->execute([$id]);

header('Location: index.php');

?>
