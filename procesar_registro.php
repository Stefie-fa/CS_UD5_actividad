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
