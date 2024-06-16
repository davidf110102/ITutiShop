<?php
    require '../config/database.php';
    require '../config/config.php';

    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin'){
        header('Location: ../index.php');
        exit;
    }
    

    $db = new Database();
    $con = $db->conectar();

    $sql = "SELECT usuarios.id, CONCAT(clientes.nombres,' ',clientes.apellidos) AS cliente, usuarios.usuario, usuarios.activacion,
    CASE
    WHEN usuarios.activacion = 1 THEN 'activo'
    WHEN usuarios.activacion = 0 THEN 'No activado' 
    ELSE 'Deshabilitado'
    END AS estatus
    FROM usuarios
    INNER JOIN clientes ON usuarios.id_cliente = clientes.id";
    $resultado = $con->query($sql);
    require  '../header.php';
?>


<main class = "flex-shrink-0">
    <div class="container">
        <h4>Usuarios</h4>
        <hr>

        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Estatus</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row= $resultado->fetch(PDO::FETCH_ASSOC)){?>
                    <tr>
                        <td><?php echo $row['cliente']; ?></td>
                        <td><?php echo $row['usuario']; ?></td>
                        <td><?php echo $row['estatus']; ?></td>
                        
                        <td>

                        <a href="cambiar_password.php?user_id=<?php echo $row['id'];?>" class="btn btn-warning
                        btn-sm">
                        cambiar password
                        </a>

                            <?php if($row['activacion'] == 1) : ?>


                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" 
                            data-bs-target="#eliminaModal" data-bs-user="<?php echo $row['id']; ?>">
                            Baja
                        </button>
                            <?php else: ?>

                            <?php endif; ?>

                        </td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="detalleModalLabel">Alerta</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Desea deshabilitar este usuario?
      </div>
      <div class="modal-footer">
        <form action="deshabilita.php" method="post">
            <input type="hidden" name="id">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-danger">Deshabilitar</button>
      </div>
    </div>
  </div>
</div>

<script>
const eliminaModal = document.getElementById('eliminaModal')
    eliminaModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget
    const user = button.getAttribute('data-bs-user')
    const inputId = eliminaModal.querySelector('.modal-footer input')

    inputId.value = user
  })

</script>

<?php include '../footer.php'; ?>
