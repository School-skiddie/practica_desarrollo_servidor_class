<!DOCTYPE html>
<html lang="es">
<?php
define('TITULO', "Iniciar sesión");

include("head.php");
include("side.php");

if(isset($_SESSION["usuario"])) header("Refresh:0; url=index.php");
?>
<body id="body-pd">
    <div class="container h-100 d-flex justify-content-center align-items-center">
        <div class="col-lg-6 col-xlg-6 col-md-6">
            <?php
            if (isset($_POST["login"])) 
            {
                $usuario = new usuario($_POST["usuario"], $_POST["clave"]);
                $usuario->iniciar_sesion();
            }
            ?>
            <form method="POST">
                <div class="card" style="margin-top: 30px; margin-bottom: 10px;">
                    <div class="card-header">Formulario de <b>inicio de sesión</b></div>
                    <div class="card-body">
                        <div class="form__group field">
                            <input type="text" class="form__field" placeholder="Usuario" name="usuario" id='usuario' required />
                            <label for="usuario" class="form__label"><i class="bi bi-person-circle"></i> Usuario</label>
                        </div>
                        <div class="form__group field">
                            <input type="password" class="form__field" placeholder="Clave" name="clave" id='clave' required />
                            <label for="clave" class="form__label"><i class="bi bi-key-fill"></i> Contraseña</label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="boton" class="button-64" name="login" role="button"><span class="text"><i class="bi bi-box-arrow-in-right"></i> Iniciar sesión</span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        const boton = document.getElementById('boton');
        const formulario = document.getElementsByTagName('input');
        var campos = document.querySelectorAll('input[required]');

        boton.addEventListener("click", function (e) 
        {
            for (var i = 0; i < campos.length; i++) 
            {
                if (campos[i].value === "") 
                {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Rellene todos los campos"
                    });

                    event.preventDefault();
                }
            }
        });
    </script>
</body>
</html>