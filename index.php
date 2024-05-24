<?php
    require 'config/config.php';
    require 'config/database.php';
    $db = new Database();
    $con = $db->conectar();
    $idCategoria = $_GET['cat'] ?? '';
    $orden = $_GET['orden'] ?? '';
    $buscar = $_GET['q'] ?? '';
    $filtro = '';

    $orders = [
        
        'asc' => 'nombre ASC',
        'desc' => 'nombre DESC',
        'precio_alto' => 'precio DESC',
        'precio_bajo' => 'precio ASC'
    ];

    $order = $orders[$orden] ?? '';

    if(!empty($order)){
        $order = " ORDER BY $order";
    }

    //$params = [];

    //$query = "SELECT id, nombre, precio FROM productos WHERE activo = 1 $order";

    if($buscar != ''){
        /*$query .= " AND nombre LIKE ?"; 
        $params[] = "%$buscar%";*/
        $filtro = "AND (nombre LIKE '%$buscar%' || descripcion LIKE '%$buscar%')";
    }
    /*if($idCategoria != ''){
        $query .= " AND id_Categoria=?";
        $params[] = $idCategoria;
    }
    $query = $con->prepare($query);
    $query -> execute($params);*/
    
    
    if(!empty($idCategoria)){
        $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo = 1 $filtro AND id_Categoria=?
        $order");
        $sql->execute([$idCategoria]);
    } else {
        $sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo = 1 $filtro $order");
        $sql->execute();
    }
    
    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

    $sqlCategorias = $con->prepare("SELECT id, nombre FROM categorias WHERE activo = 1");
    $sqlCategorias->execute();
    $categorias = $sqlCategorias->fetchAll(PDO::FETCH_ASSOC);

    //session_destroy();

    //print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITuti Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <link href="css/all.min.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">
</head>
<body>
<?php include 'menu.php'; ?>

<main class = "flex-shrink-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class = "card shadow-sm">
                    <div class = "card-header">
                        Categorías
                    </div>
                    <div class="list-group">
                        <a href="index.php" class="list-group-item list-group-item-action">
                        Todo
                        </a>
                        <?php foreach($categorias as $categoria){ ?>
                        <a href="index.php?cat=<?php echo $categoria['id']; ?>" 
                        class="list-group-item list-group-item-action <?php if($idCategoria == $categoria['id']) echo 'active'; ?>">
                            <?php echo $categoria['nombre'];?>
                        </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <br><br>
            <div class="col-12 col-md-9">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 justify-content-end g-4">
                <div class="col mb-2">
                    <form action="index.php" id="ordenForm" method="get">
                        <input type="hidden" name="cat" id="cat" value="<?php echo $idCategoria; ?>">
                        <select name = "orden" id="orden" class="form-select form-select-sm"
                        onchange="submitForm()">
                            <option value="">Ordenar por</option>
                            <option value="precio_alto" <?php echo ($orden === 'precio_alto') ? 'selected' : ''; ?>>Precios más altos</option>
                            <option value="precio_bajo" <?php echo ($orden === 'precio_bajo') ? 'selected' : ''; ?>>Precios más bajos</option>
                            <option value="asc" <?php echo ($orden === 'asc') ? 'selected' : ''; ?>>Nombre A-Z</option>
                            <option value="desc" <?php echo ($orden === 'desc') ? 'selected' : ''; ?>>Nombre Z-A</option>
                        </select>
                    </form>
                </div>
            </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        <?php foreach($resultado as $row){ ?>
        <div class="col mb-2">
          <div class="card shadow-sm h-100">
            <?php
                $id = $row['id'];
                $imagen= "images/productos/" . $id . "/principal.jpg";
                if(!file_exists($imagen)){
                    $imagen = "images/no-photo.jpg";
                }
            ?>
            <img src="<?php echo $imagen; ?>" class="d-block w-100">
            <div class="card-body">
              <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
              <p class="card-text">$ <?php echo $row['precio']; ?></p>
              <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <a href="details.php?id=<?php echo $row['id']; ?>&token=<?php echo 
                        hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
                    </div>
                    <button class="btn btn-yellow" type="button" onclick="addProducto(<?php echo $row['id']; ?>, '<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')">
    Agregar
    </button>
              </div>
            </div>
          </div>
        </div>
        <?php }?>
    </div>
    </div>
    </div>
            </div>
</main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
    crossorigin="anonymous"></script>

    <script>
        function addProducto(id, token){
            let url = 'clases/carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data =>{
                if(data.ok){
                    let elemento = document.getElementById("num_cart")
                    elemento.innerHTML = data.numero
                }
            })
        }
        function submitForm(){
            document.getElementById('ordenForm').submit();
        }
    </script>
    
</body>
</html>