<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Registro de Usuario</title>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Registro de Usuario</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];
        $selectedRole = $_POST["role"];

        // Verificar si las contraseñas coinciden
        if ($password != $confirmPassword) {
            echo '<div class="alert alert-danger" role="alert">Las contraseñas no coinciden.</div>';
            exit();
        }

        // Verificar si el email ya está registrado (deberías implementar esta lógica)

        // Hash de la contraseña
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Inicio de la transacción
        try {
            $con = getConnection();
            $con->beginTransaction();

            // Inserción de usuario en la tabla 'usuario'
            $stmtUsuario = $con->prepare("INSERT INTO usuario (email, password) VALUES (:email, :password)");
            $stmtUsuario->bindParam(":email", $email);
            $stmtUsuario->bindParam(":password", $hashedPassword);
            $stmtUsuario->execute();

            // Obtener el ID del usuario recién insertado
            $userId = $con->lastInsertId();

            // Inserción de la relación usuario-rol en la tabla 'usuario_rol'
            $stmtUsuarioRol = $con->prepare("INSERT INTO usuario_rol (usuario_id, rol_id) VALUES (:usuario_id, :rol_id)");
            $stmtUsuarioRol->bindParam(":usuario_id", $userId);
            $stmtUsuarioRol->bindParam(":rol_id", $selectedRole);
            $stmtUsuarioRol->execute();

            // Confirmar la transacción
            $con->commit();

            echo '<div class="alert alert-success" role="alert">Usuario registrado con éxito.</div>';
        } catch (PDOException $e) {
            // Deshacer la transacción en caso de error
            $con->rollBack();
            echo '<div class="alert alert-danger" role="alert">Error al registrar el usuario: ' . $e->getMessage() . '</div>';
        }
    }
    ?>

    <form action="registro.php" method="post">
        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese su correo electrónico" required>
        </div>

        <!-- Contraseña -->
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña" required>
        </div>

        <!-- Repetir Contraseña -->
        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Repetir Contraseña</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Repita su contraseña" required>
        </div>

        <!-- Rol (lista desplegable obtenida de la BD) -->
        <div class="mb-3">
            <label for="role" class="form-label">Rol</label>
            <select class="form-select" id="role" name="role" required>
                <!-- Aquí obtendrás dinámicamente los roles desde la base de datos -->
            </select>
        </div>

        <!-- Botón de Registrar -->
        <button type="submit" class="btn btn-primary">Registrar Usuario</button>
    </form>
</div>

</body>
</html>
