<!DOCTYPE html>
<html lang="es">
<?php
    define('TITULO', "Dar de baja");

    include("../head.php");
    include("../side.php");

    if(!isset($_SESSION["usuario"])) header("Refresh:0; url=../login.php");
?>
<body id="body-pd">
<div class="container h-100 d-flex justify-content-center align-items-center">
<div class="col-lg-12 col-xlg-6 col-md-12">
        <?php
        if (isset($_POST["baja"])) 
        {
            foreach ($_POST["seleccion"] as $usuario_seleccionado) 
            {
                $cuenta = new cuenta($usuario_seleccionado, $usuario_seleccionado);
                $cuenta->dar_baja();
            }

            echo "<div class='alert alert-success' style='margin-top: 30px;' role='alert'> Se han dado de baja los usuarios correctamente...</div>";
        }
        if (isset($_POST["actualizar"])) 
        {
            $cuenta = new cuenta($_POST["usuario"], $_POST["numero_cuenta"], $_POST["saldo"]);
            $cuenta->actualizar_cuenta();
            echo "<div class='alert alert-success' style='margin-top: 30px;' role='alert'> Se ha actualizado el usuario correctamente...</div>";
        }
        ?>
        <form method="POST">
        <?php if(!isset($_GET["modificar"])) { ?>
            <div class="card" style="margin-top: 30px; margin-bottom: 10px;">
                <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col">Numero de cuenta</th>
                            <th scope="col">Saldo</th>
                            <th scope="col"></th>
                            <th scope="col">Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $usuarios = new usuario();
                        foreach ($usuarios->obtener_usuarios_dados_alta() as $celda) {
                        ?>
                        <tr>
                            <th scope="row">
                                <div class="checkbox-wrapper-33">
                                    <label class="checkbox">
                                        <input class="checkbox__trigger visuallyhidden" name="seleccion[]" type="checkbox" value="<?php echo $celda["numero_cuenta"]; ?>"/>
                                        <span class="checkbox__symbol">
                                        <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4 14l8 7L24 7"></path>
                                        </svg>
                                        </span>
                                    </label>
                                </div>
                            </th>
                            <td><a href="dar_baja.php?modificar=<?php echo $celda["usuario"]; ?>"><i class="bi bi-box-arrow-up-right"></i> Modificar cuenta</a></td>
                            <td><?php echo $celda["numero_cuenta"]; ?></td>
                            <td><?php echo $celda["saldo"]; ?> €</td>
                            <td><a href="usuarios.php?modificar=<?php echo $celda["usuario"]; ?>"><i class="bi bi-box-arrow-up-right"></i> Modificar usuario</a></td>
                            <td><?php echo $celda["usuario"]; ?></td>
                        </tr>
                        <?php 
                        }
                        ?>
                    </tbody>
                </table>
                </div>
                <div class="card-footer">
                    <button type="submit"  class="button-64" id="boton" name="baja" role="button" disabled>
                        <span class="text"><i class="bi bi-calendar-x"></i> Dar de baja</span>
                    </button>
                </div>
        </div>
        <?php
        }
        else
        {
            $cuenta = new cuenta($_GET["modificar"]);

            foreach ($cuenta->obtener_usuario() as $celda) 
            {
        ?>
        <div class="card" style="margin-top: 30px; margin-bottom: 10px;">
                <div class="card-body">
                    <div class="card-body">
                    <div class="form__group field">
                            <input type="text" class="form__field" placeholder="Número de cuenta" name="numero_cuenta" value="<?php echo $celda["numero_cuenta"]; ?>" id='numero_cuenta' required />
                            <label for="numero_cuenta" class="form__label"><i class="bi bi-bank2"></i> Numero de cuenta</label>
                        </div>
                        <div class="form__group field">
                            <input type="number" class="form__field" placeholder="Saldo" name="saldo" value="<?php echo $celda["saldo"]; ?>" id='saldo' required />
                            <label for="saldo" class="form__label"><i class="bi bi-currency-euro"></i> Saldo</label>
                        </div>
                        <div class="form__group field">
                            <input type="text" class="form__field" placeholder="Usuario" name="usuario" value="<?php echo $celda["usuario"]; ?>" id='usuario' required />
                            <label for="usuario" class="form__label"><i class="bi bi-person-circle"></i> Usuario</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit"  class="button-64" id="boton" name="actualizar" role="button">
                        <span class="text"><i class="bi bi-arrow-clockwise"></i> Actualizar</span>
                    </button>
                </div>
        <?php
            }
        }
        ?>
        </form>
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