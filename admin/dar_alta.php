<!DOCTYPE html>
<html lang="es">
<?php
    define('TITULO', "Dar de alta");

    include("../head.php");
    include("../side.php");

    if(!isset($_SESSION["usuario"])) header("Refresh:0; url=../login.php");
?>
<body id="body-pd">
<div class="container h-100 d-flex justify-content-center align-items-center">
<div class="col-lg-12 col-xlg-6 col-md-12">
        <?php
        if (isset($_POST["alta"])) 
        {
            foreach ($_POST["seleccion"] as $usuario_seleccionado) 
            {
                $cuenta = new cuenta($usuario_seleccionado, uniqid());
                $cuenta->dar_alta();
            }

            echo "<div class='alert alert-success' style='margin-top: 30px;' role='alert'> Se han dado de alta los usuarios correctamente...</div>";
        }
        ?>
        <form method="POST">
            <div class="card" style="margin-top: 30px; margin-bottom: 10px;">
                <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Clave</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Edad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $usuarios = new usuario();
                        foreach ($usuarios->obtener_usuarios_dados_baja() as $celda) {
                        ?>
                        <tr>
                            <th scope="row">
                                
                            <div class="checkbox-wrapper-33">
                                <label class="checkbox">
                                    <input class="checkbox__trigger visuallyhidden" name="seleccion[]" type="checkbox" value="<?php echo $celda["usuario"]; ?>"/>
                                    <span class="checkbox__symbol">
                                    <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 14l8 7L24 7"></path>
                                    </svg>
                                    </span>
                                </label>
                            </div>
                            </th>
                            <td><?php echo $celda["usuario"]; ?></td>
                            <td><?php echo $celda["clave"]; ?></td>
                            <td><?php echo $celda["nombre"]; ?></td>
                            <td><?php echo $celda["email"]; ?></td>
                            <td><?php echo $celda["telefono"]; ?></td>
                            <td><?php echo $celda["edad"]; ?></td>
                        </tr>
                        <?php 
                        }
                        ?>
                    </tbody>
                </table>
                </div>
                <div class="card-footer">
                    <button type="submit"  class="button-64" id="boton" name="alta" role="button" disabled>
                        <span class="text"><i class="bi bi-sign-intersection"></i> Dar de alta</span>
                    </button>
                </div>
            </form>
        </div>
        </div>
    </div>
    <script>
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const boton = document.getElementById('boton');

        checkboxes.forEach(checkbox => 
        {
            checkbox.addEventListener('change', function() 
            {
                let seleccionado = false;
                checkboxes.forEach(checkbox => 
                {
                    if (checkbox.checked) 
                    {
                        seleccionado = true;
                    }
                });
                boton.disabled = !seleccionado;
            });
        });
    </script>
</body>
</html>