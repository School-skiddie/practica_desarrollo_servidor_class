<!DOCTYPE html>
<html lang="es">
<?php
    define('TITULO', "Modificar usuarios");

    include("../head.php");
    include("../side.php");

    if(!isset($_SESSION["usuario"])) header("Refresh:0; url=../login.php");
?>
<body id="body-pd">
<div class="container h-100 d-flex justify-content-center align-items-center">
    <div class="col-lg-12 col-xlg-6 col-md-12">
        <?php
        if (isset($_POST["eliminar"])) 
        {
            foreach ($_POST["seleccion"] as $usuario_seleccionado) 
            {
                $usuario = new usuario($usuario_seleccionado);
                $usuario->baja_usuario();
            }

            echo "<div class='alert alert-success' style='margin-top: 30px;' role='alert'> Se han borrado los usuarios seleccionados correctamente...</div>";
        }
        if (isset($_POST["actualizar"])) 
        {
            $usuario = new usuario($_POST["usuario"], $_POST["clave"], $_POST["nombre"], $_POST["email"], $_POST["telefono"], $_POST["edad"]);
            $usuario->actualizar_usuario();
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
                        foreach ($usuarios->obtener_usuarios() as $celda) {
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
                            <td><a href="usuarios.php?modificar=<?php echo $celda["usuario"]; ?>"><i class="bi bi-box-arrow-up-right"></i> Modificar</a></td>
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
                    <button type="submit"  class="button-64" id="boton" name="eliminar" role="button" disabled>
                        <span class="text"><i class="bi bi-trash3-fill"></i> Eliminar usuario</span>
                    </button>
                </div>
                <?php 
                } 
                else 
                { 
                
                    $usuario = new usuario($_GET["modificar"]);

                    foreach ($usuario->obtener_usuario() as $celda) 
                    {
                ?>
            <div class="card" style="margin-top: 30px; margin-bottom: 10px;">
                <div class="card-body">
                    <div class="card-body">
                        <div class="form__group field">
                            <input type="text" class="form__field" placeholder="Usuario" name="usuario" value="<?php echo $celda["usuario"]; ?>" id='usuario' required />
                            <label for="usuario" class="form__label"><i class="bi bi-person-circle"></i> Usuario</label>
                        </div>
                        <div class="form__group field">
                            <input type="password" class="form__field" placeholder="Clave" name="clave" value="<?php echo $celda["clave"]; ?>" id='clave' required />
                            <label for="clave" class="form__label"><i class="bi bi-key-fill"></i> Contraseña</label>
                        </div>
                        <div class="form__group field">
                            <input type="nombre" class="form__field" placeholder="Nombre" name="nombre" value="<?php echo $celda["nombre"]; ?>" id='nombre' required />
                            <label for="nombre" class="form__label"><i class="bi bi-person-badge-fill"></i> Nombre Completo</label>
                        </div>
                        <div class="form__group field">
                            <input type="email" class="form__field" placeholder="Email" name="email" value="<?php echo$celda["email"]; ?>" id='email' required />
                            <label for="email" class="form__label"><i class="bi bi-envelope-at-fill"></i> Email</label>
                        </div>
                        <div class="form__group field">
                            <input type="telefono" class="form__field" placeholder="Teléfono" name="telefono" value="<?php echo $celda["telefono"]; ?>" id='telefono' required />
                            <label for="telefono" class="form__label"><i class="bi bi-telephone-fill"></i> Telefono</label>
                        </div>
                        <div class="form__group field">
                            <input type="number" class="form__field" placeholder="Edad" name="edad" value="<?php echo $celda["edad"]; ?>" id='edad' required />
                            <label for="Edad" class="form__label"><i class="bi bi-backpack-fill"></i> Edad</label>
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
                </div>
            </form>
            </div> 
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