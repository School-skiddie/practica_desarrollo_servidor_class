<!DOCTYPE html>
<html lang="es">
<?php
    define('TITULO', "Transferir dinero");

    include("../head.php");
    include("../side.php");

    if(!isset($_SESSION["usuario"])) header("Refresh:0; url=../login.php");
?>
<body id="body-pd">
<div class="container h-100 d-flex justify-content-center align-items-center">
    <div class="col-lg-12 col-xlg-6 col-md-12">
        <?php
        if (isset($_POST["transferir"])) 
        {
            $cuenta = new cuenta($_SESSION["usuario"]);

            $obtener_saldo_cuenta_a_enviar = new cuenta($_POST["cuenta"]);

            $cuenta->transferencia($_POST["cuenta"], [ $cuenta->obtener_saldo()-$_POST["cantidad"], $obtener_saldo_cuenta_a_enviar->obtener_saldo() + $_POST["cantidad"] ]);
            echo "<div class='alert alert-success' style='margin-top: 30px;' role='alert'> Se ha enviado el dinero correctamente...</div>";
        }
        ?>
        <form method="POST">
            <div class="card" style="margin-top: 30px; margin-bottom: 10px;">
                <div class="card-header">
                        <?php
                        $cuenta = new cuenta($_SESSION["usuario"]);
                        echo "Actualmente tienes un saldo de: <b>" . $cuenta->obtener_saldo() . " €</b>";
                        ?>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="form__group field">
                            <label for="cuenta"><i class="bi bi-people-fill"></i> Usuario</label>
                            <select name="cuenta" id="cuenta" required>
                                <option value="selecciona" disabled selected>Selecciona un usuario</option>
                                <?php 
                                $usuarios = new usuario();
                                foreach ($usuarios->obtener_usuarios_dados_alta() as $celda) {
                                    if($_SESSION["usuario"] != $celda["usuario"]) {
                                ?>
                                <option value="<?php echo $celda["usuario"]; ?>">Usuario: <?php echo $celda["usuario"]; ?> | Cuenta: <?php echo $celda["numero_cuenta"]; ?> | Saldo: <?php echo $celda["saldo"]; ?> €</option>
                                <?php 
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form__group field">
                            <input type="number" class="form__field" placeholder="Cantidad" name="cantidad" min="1" max="<?php echo $cuenta->obtener_saldo(); ?>" value="1" id='cantidad' required />
                            <label for="cantidad" class="form__label"><i class="bi bi-currency-euro"></i> Cantidad</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit"  class="button-64" id="boton" name="transferir" role="button">
                        <span class="text"><i class="bi bi-send"></i> Enviar dinero</span>
                    </button>
                </div>
                </div>
            </form>
            </div> 
        </div>
        </div>
    </div>
    <script>
        const boton = document.getElementById('boton');
        const cantidad = document.getElementById('cantidad');
        const select = document.getElementById('cuenta');
        const formulario = document.getElementsByTagName('form');

        boton.addEventListener("click", function (e) 
        {
            if(select.value == "selecciona") 
            {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Selecciona un usuario"
                });

                event.preventDefault();
            }
            else if(cantidad.value > <?php echo  $cuenta->obtener_saldo(); ?>) 
            {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "No tienes ese saldo en la cuenta..."
                });

                event.preventDefault();
            }
        });
    </script>
</body>
</html>