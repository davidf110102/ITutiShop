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

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$descuento = $_POST['descuento'];
$stock = $_POST['stock'];
$categoria = $_POST['categoria'];

$sql = "INSERT INTO productos (nombre, descripcion, precio, descuento, stock, id_categoria, activo) 
VALUES(?, ?, ?, ?, ?, ?, 1)";
$stm = $con->prepare($sql);
if($stm->execute([$nombre, $descripcion, $precio, $descuento, $stock, $categoria])){
    $id = $con->lastInsertId();

    if($_FILES['imagen_principal']['error'] == UPLOAD_ERR_OK){
        $dir = '../../images/productos/'. $id . '/';
        $permitidos = ['jpeg','jpg'];
        $arregloImagen = explode('.', $_FILES['imagen_principal']['name']);
        $extension = strtolower(end($arregloImagen));

        if(in_array($extension, $permitidos)){
            if(!file_exists($dir)){
                mkdir($dir, 0777, true);
            }
            $ruta_img = $dir . 'principal.' . $extension;
            if(move_uploaded_file($_FILES['imagen_principal']['tmp_name'], $ruta_img)){
                echo "El archivo se cargó correctamente.";
            }else{
                echo "Error al cargar el archivo.";
            }
        } else {
            echo "Archivo no permitido";
        }
    } else {
        echo "No enviaste archivo";
    }
}

//header('Location: index.php');

?>
