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

    <form action="procesar_registro.php" method="post">
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

        <!-- Rol -->
        <div class="mb-3">
            <label for="role" class="form-label">Rol</label>
            <select class="form-select" id="role" name="role" required>
                <option value="" disabled selected>Seleccione un rol</option>
                <option value="admin">Administrador</option>
                <option value="user">Usuario</option>
            </select>
        </div>

        <!-- Botón de Registrar -->
        <button type="submit" class="btn btn-primary">Registrar Usuario</button>
    </form>
</div>

</body>
</html>
