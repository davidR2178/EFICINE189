<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mi_base_de_datos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Datos a insertar
$email = 'test@example.com'; // Aquí el valor que deseas insertar
$nombre = 'Juan Pérez';

// Preparar y ejecutar la consulta para verificar si el email ya existe
$sql = "SELECT id FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "El email ya existe en la base de datos.";
} else {
    // El email no existe, proceder a la inserción
    $sql = "INSERT INTO usuarios (email, nombre) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $nombre);

    if ($stmt->execute()) {
        echo "Registro insertado correctamente.";
    } else {
        echo "Error al insertar registro: " . $stmt->error;
    }
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
