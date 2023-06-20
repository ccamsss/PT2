<?php
 #Archivo de configuracion de la base de datos
    define("PG_DB"  , "culturales");
	define("PG_HOST", "centcutural.c1todkalmt5r.us-east-1.rds.amazonaws.com");
	define("PG_USER", "postgres");
	define("PG_PSWD", "0123456789");
	define("PG_PORT", "5432");
	
	$dbcon = pg_connect("dbname=".PG_DB." host=".PG_HOST." user=".PG_USER ." password=".PG_PSWD." port=".PG_PORT."");
	// Verificar la conexión
	if (!$dbcon) {
		echo "Error al conectar a la base de datos.";
		exit;}
	$sql="SELECT * FROM cen_culturales";
	$result=pg_query($dbcon,$sql);
?>