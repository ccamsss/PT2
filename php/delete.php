<?php
// Obtener id
$id = $_POST['id'];
// Crear la conexión a la base de datos
define("PG_DB"  , "culturales");
define("PG_HOST", "centcutural.c1todkalmt5r.us-east-1.rds.amazonaws.com");
define("PG_USER", "postgres");
define("PG_PSWD", "0123456789");
define("PG_PORT", "5432
");
$conn = pg_connect("dbname=".PG_DB." host=".PG_HOST." user=".PG_USER ." password=".PG_PSWD." port=".PG_PORT."");
//Verificar conexion
if (!$conn) {
    echo "Error de conexión a la base de datos.";
    exit;
}
// Consulta de liminar dato
$query = "DELETE FROM cen_culturales WHERE id = $1";
$result = pg_query_params($conn, $query, array($id));

// Verificar el resultado de la consulta
if ($result) {
    if (pg_affected_rows($result) > 0) {
        echo "El punto $id ha sido eliminado.";
    } else {
        echo "El punto con $id no existe.";
    }
} else {
    echo "Error al ejecutar la consulta.";
}
?>
