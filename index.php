<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="regsitro.js"></script>
    <title>Document</title>
</head>
<body>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro e Inicio de Sesión</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


<div class="registro-cuadro">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTqVg_URh9Mvrm3NYaTlCUyiM7r382ohELc1g&s" 
         alt="Registro de Usuario" class="imagen-registro">

    <h2>Bienvenido Usuario!!</h2>

    <p class="titulo1" onclick="mostrarFormulario('inicio')">Iniciar sesión</p>
    <p class="titulo2" onclick="mostrarFormulario('registro')">Registrar Usuario</p>

    <div id="formularioInicio" class="formulario-inicio">
        <form id="formInicio" action="" method="POST">
            <input type="hidden" name="accion" value="login">
            <input type="email" name="correo" placeholder="Correo" class="input-field1" required>
            <input type="password" name="password" placeholder="Contraseña" class="input-field1" required>
            <input type="submit" value="Iniciar Sesión" class="submit-btn">
        </form>

        <?php
        if (isset($_SESSION["error_login"])) {
            echo "<p style='color: red; text-align:center; font-weight: bold;'>" . $_SESSION["error_login"] . "</p>";
            unset($_SESSION["error_login"]);
        }
        ?>

        <a href="index.php">
            <img src="https://www.shutterstock.com/image-vector/black-round-go-back-return-600nw-1696827145.jpg" 
                 alt="Regresar" class="imagen-registro">
        </a>
    </div>

    <div id="formularioRegistro" class="formulario-registro">
        <form id="formRegistro" action="" method="POST">
            <input type="hidden" name="accion" value="registrar">
            <input type="text" name="nombre" placeholder="Nombre" class="input-field2" required>
            <input type="email" name="correo" placeholder="Correo" class="input-field2" required>
            <input type="password" name="password" placeholder="Contraseña" class="input-field2" required>
            <input type="submit" value="Registrar Usuario" class="submit-btn">
        </form>
        <div id="mensajeRegistro" class="mensaje"></div>

        <a href="index.php">
            <img src="https://www.shutterstock.com/image-vector/black-round-go-back-return-600nw-1696827145.jpg" 
                 alt="Regresar" class="imagen-registro">
        </a>
    </div>
</div>


<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$base_datos = "registro";

try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$base_datos", $usuario, $contraseña);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["accion"]) && $_POST["accion"] == "registrar") {
            // REGISTRO DE USUARIO
            $nombre = $_POST["nombre"];
            $correo = $_POST["correo"];
            $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

            $stmt = $conexion->prepare("SELECT * FROM persona WHERE correo = ?");
            $stmt->execute([$correo]);

            if ($stmt->rowCount() > 0) {
                $_SESSION["error_login"] = "El usuario ya está registrado.";
            } else {
                $sql = "INSERT INTO persona (id, nombre, contraseña, correo) VALUES (NULL, ?, ?, ?)";
                $stmt = $conexion->prepare($sql);
                $stmt->execute([$nombre, $password, $correo]);

                $_SESSION["usuario"] = $nombre;
                header("Location: tienda.php");
                exit();
            }
        }

        if (isset($_POST["accion"]) && $_POST["accion"] == "login") {
            // INICIO DE SESIÓN
            $correo = $_POST["correo"];
            $password = $_POST["password"];

            $stmt = $conexion->prepare("SELECT * FROM persona WHERE correo = ?");
            $stmt->execute([$correo]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                if (password_verify($password, $usuario["contraseña"])) {
                    $_SESSION["usuario"] = $usuario["nombre"];
                    header("Location: tienda.php");
                    exit();
                } else {
                    $_SESSION["error_login"] = "Contraseña incorrecta.";
                }
            } else {
                $_SESSION["error_login"] = "Usuario no registrado.";
            }
        }
    }

    if (isset($_GET["logout"])) {
        session_destroy();
        header("Location: index.php");
        exit();
    }
} catch (PDOException $error) {
    echo "Error de conexión: " . $error->getMessage();
}
?>



















</body>
</html>





