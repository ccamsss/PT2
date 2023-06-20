<?php 
	define("PG_DB"  , "culturales");
	define("PG_HOST", "centcutural.c1todkalmt5r.us-east-1.rds.amazonaws.com");
	define("PG_USER", "postgres");
	define("PG_PSWD", "0123456789");
	define("PG_PORT", "5432");
	
	$conexion = pg_connect("dbname=".PG_DB." host=".PG_HOST." user=".PG_USER ." password=".PG_PSWD." port=".PG_PORT."");
  if (!$conexion) {
    echo "Error de conexión con la base de datos.";
    exit;
  }
?>


<!DOCTYPE html>
<html>
	<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>   <!-- plugin jquery -->
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.6.0/leaflet.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.6.0/leaflet.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.EasyButton/2.4.0/easy-button.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.EasyButton/2.4.0/easy-button.css" />
    <!-- CDN_Estilos -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <script src="Locate/L.Control.Locate.js"></script>
    <link rel="stylesheet" href="Locate/L.Control.Locate.css" />
    
    <script src="minimapa/Control.MiniMap.js"></script>
	  <link rel="stylesheet" href="minimapa/Control.MiniMap.css" />

    <link rel="stylesheet" href="SlideMenu/src/L.Control.SlideMenu.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>  
    <script src="SlideMenu/src/L.Control.SlideMenu.js"></script>
    <title>Centros Culturales COM03</title>
    
        
    <style>
      /*          ESTILOS        */
      *{	
      padding: 0% ;
      margin: 0% 0%;		
      }
      html, body{
      height:100% ;
      width:100% vw;
      font-family:'Ubuntu',sans-serif
      }
      #map{
      width:100%;
      height:100%;
      }
      #norte{
        position:relative;
        width:2%;
        left: 3%;
        padding: 1.2%;
      }
      .content {
        margin: 0.25rem;
        border-top: 1px solid #000;
        padding-top: 0.5rem;
      }
      .header {
        font-size: 1.8rem;
        color: #7f7f7f;
      }
      .title {
        font-size: 1.1rem;
        color: #7f7f7f;
        font-weight: bold;
      }
      #form {   /* Estilo formulario eliminar */
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border: 1px solid black;
        border-radius: 5px;
        z-index: 9999;
      }
      #form2 {    /* Estilo formulario editar */
        display: none;
        position: absolute;
        top: 78%;
        left: 15%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border: 1px solid black;
        border-radius: 5px;
        z-index: 9999;
      }
      #form3 {    /* Estilo formulario agregar */
        display: none;
        position: absolute;
        top: 78%;
        left: 15%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border: 1px solid black;
        border-radius: 5px;
        z-index: 9999;
      }
      #form input {
        margin-top: 10px;
      }
      #form button {
        margin-top: 10px;
      }
      table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
      }
      td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
      }
      .table thead tr {
        background-color: #343a40;
        color: white;
      }
      .table tbody tr:nth-child(even) {
        background-color: #343a40;
        color: white;
      }
      .table tbody tr:nth-child(odd) {
        background-color: #6c757d;
        color: white;
      }
    </style>
    <link rel="stylesheet" href="pag.css" />
	</head>	
	<body>
    <p style="font-size: 150%;"> CENTROS CULTURALES DE LA COMUNA 03 EN CALI</p>
    <div class="details-on-map show-map">
      <div class="paper-map">
        <div class="map-side"></div>
        <div class="map-side"></div>
        <div class="map-side"></div>
        <div class="map-side"></div>
      </div>
      <div id="map" style="z-index:9999">
        <img id="norte" src="norte.png" style="z-index:9999" ></img></div>
      <!-------------------------------Formulario ELIMINAR------------------------------------>
      <div id="form" class="w3-container">
        <h2>Eliminar Punto</h2>
        <form id="deleteForm">
          <label for="id">ID del Punto:</label>
          <input class="w3-input w3-border" type="text" id="id" placeholder="Identificador" required>
          <br>
          <button type="submit" class="w3-button w3-red">Eliminar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <button class="w3-button w3-black" type="button" onclick="cancelForm1()">Cancelar</button>
        </form>
      </div>
        <!-------------------------------Formulario EDITAR------------------------------------>
      <div id="form2" class="w3-container">
        <h2>Editar Punto</h2>
        <form id="editForm" action="php/edit.php" method="POST">
          
          <!--<label for="id">ID:</label>-->
          <input id="id" class="w3-input w3-border" name="id" placeholder="Identificador" required><br>
          <!--<label for="nombre">Nombre:</label>-->
          <input id="nombre" class="w3-input w3-border" name="nombre" placeholder="Nombre"required><br>
          <!--<label for="categoria">Categoria:</label>-->
          <input id="categoria" class="w3-input w3-border" name="categoria" placeholder="Categoria" required>
          <label for="id">Latitud:</label>
          <input id="lat" class="w3-input w3-border" name="lat" placeholder="Latitud" required>
          <label for="id">Longitud:</label>
          <input id="long" class="w3-input w3-border" name="long" placeholder="Longitud" required><br>
          <input type="submit" class="w3-button w3-teal" value="Guardar">&nbsp;&nbsp;
          <button type="button" class="w3-button w3-black" id="cancelEditingBtn">Cancelar</button>
        </form>
      </div>
        <!-------------------------------Formulario AÑADIR------------------------------------>
      <div id="form3" class="w3-container">
        <h2>Agregar Punto</h2>
        <form id="addForm" method="POST" action="php/add.php">
          <input type="text" class="w3-input w3-border" id="id" name="id" placeholder="Identificación" required>
          <br>
          <input type="text" class="w3-input w3-border" id="nombre" name="nombre" placeholder="Nombre" required>
          <br>
          <input type="text" class="w3-input w3-border" id="categoria"  name="categoria" placeholder="Categoria" required>
          <label for="id">Latitud:</label>
          <input type="text" id="latitude" class="w3-input w3-border" name="latitude" placeholder="Latitud" readonly>
          <label for="id">Longitud:</label>
          <input type="text" id="longitude" class="w3-input w3-border" name="longitude" placeholder="Longitud" readonly>
          <br>
          <button type="submit" class="w3-button w3-teal">Guardar</button>&nbsp;&nbsp;
          <button type="button" class="w3-button w3-black" onclick="cancelForm3()">Cancelar</button>
        </form>
      </div> 

      <script src="geosearch/leaflet-search.js"></script>
    </div> 
  </body>
	<script>
    //Mapa
    var map = L.map('map',
    {
      zoom: 10,
      minZoom:13,
        maxZoom: 16,
    }).setView([3.450430, -76.534438], 15);           
    
    //Mapas base
    var mapabase = L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', 
    {
      maxZoom: 18,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    })
    var mapabase2 = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
    {
      minZoom:13,
      maxZoom: 16,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });
    mapabase.addTo(map);
    function info_popup(feature, layer){
      layer.bindPopup("<h1>" + feature.properties.nombre + "</h1><hr>"+"<strong> Identificación: </strong>"+feature.properties.id+"<br/>"+"<strong> Categoria: </strong>"+feature.properties.categoria+"<br/>");
    }
    var leyenda = L.control.layers({mapabase,mapabase2}).addTo(map);
    //-----------------------------------------------------CARGAR LA CAPA COMO GEOJSON DESDE LA BDG-----------------------------------------------//
    var cen_culturales = L.geoJSON();
    $.post("php/conect.php",{
      peticion: 'cargar',
    },function (data, status, feature){
      if(status=='success'){
        cen_culturales = eval('('+data+')');
        var cen_culturales = L.geoJSON(cen_culturales, {
          onEachFeature: info_popup
        });
        cen_culturales.eachLayer(function (layer) {
          layer.setZIndexOffset(1000);
        });
        leyenda.addOverlay(cen_culturales, 'Centros culturales');
      }
    });
    //--------------------------------------------------------CREAR EL BOTON DE VISTA PRINCIPAL-------------------------------------------------//
    var homeButton = L.easyButton({
      states: [{
        stateName: 'home',
        icon: '<img src="icon/regresar.png"  align="absmiddle" height="16px" >',
        title: 'Vista principal',
        onClick: function (control) {
          map.setView([3.450430, -76.534438], 15);   // Establecer la vista principal del mapa
        }
      }]
    });
    homeButton.addTo(map);    // Agregar el botón al mapa
    //-----------------------------------------------------------GEOLOCALIZACIÓN - UBICACIÓN---------------------------------------------------//							
    var lc = L.control.locate({
      position: 'topleft',
      strings: {
        title: "Mostrar tu ubicación",
        popup: "Estás a {distance} {unit} de este punto",
        outsideMapBoundsMsg: "Estás fuera del limite del mapa"
      },
    }).addTo(map);
    //-----------------------------------------------------DESPLIEGE DEL FORMULARIO PARA AGRGAR DATOS----------------------------------------------//
    var clickedLatLng;
    var marker;
    var isFormOpened = false;
    //Función para abrir el formulario
    function toggleForm3() {
      $('#form3').toggle();
      isFormOpened = !isFormOpened;// Invertir el estado del formulario
      if (isFormOpened) {
        map.on('click', onMapClick);
      } else {
        map.off('click', onMapClick);
        if (marker) {
          map.removeLayer(marker);
        }
      }
    }
    // Manejador de eventos para el clic en el mapa
    function onMapClick(e) {
      if (isFormOpened) { // Verificar si el formulario está abierto
        if (marker) {
          map.removeLayer(marker);
        }
        clickedLatLng = e.latlng;
        document.getElementById('latitude').value = clickedLatLng.lat;
        document.getElementById('longitude').value = clickedLatLng.lng;
        marker = L.marker(clickedLatLng).addTo(map);
      }
    }
    //Función para resetear el formulario
    function resetForm3() {
      document.getElementById('addForm').reset();
    }
    //Función para cancelar el formulario
    function cancelForm3() {
      $('#form3').hide();
      isFormOpened = false; // Marcar el formulario como cerrado
      map.off('click', onMapClick);
      if (marker) {
        map.removeLayer(marker);
      }
      resetForm3(); // Restablecer los valores del formulario
    }
    // Manejador de eventos para enviar el formulario
    $('#addForm').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
          alert(response);
          resetForm3(); // Restablecer los valores del formulario después de enviarlo
        },
        error: function() {
          alert('Error al guardar el punto.');
        }
      });
    });
    // Crear el EasyButton para abrir el formulario de añadir dato - punto
    var easyButton = L.easyButton('fa fa-user-plus', function() {
        toggleForm3();
    },'Añadir punto').addTo(map);
    //-----------------------------------------------------DESPLIEGE DEL FORMULARIO PARA ELIMINAR DATOS----------------------------------------------//
    // Código para mostrar/ocultar el formulario de eliminación
    function toggleForm() {
      $('#form').toggle();
    }
    // Código para eliminar el marcador
    function eliminarPunto(id) {
      $.ajax({
        url: 'php/delete.php',
        type: 'POST',
        data: { id: id },
        success: function(response) {
          alert(response);
        },
        error: function() {
          alert('Error al eliminar el marcador.');
        }
      });
    }
    // Manejador de eventos para enviar el formulario
    $('#deleteForm').on('submit', function(event) {
      event.preventDefault();
      var id = $('#id').val();
      eliminarPunto(id);
    });
    // Función para cancelar el formulario
    function cancelForm1() {
      $('#form').hide();
      isFormOpened = false; // Marcar el formulario como cerrado
      resetForm3(); // Restablecer los valores del formulario
    }
    // Crear el EasyButton para abrir el formulario de eliminaciar dato - punto
    var eliminarButton = L.easyButton('fa-trash', function() {
      toggleForm();
    }, 'Eliminar Punto').addTo(map);
    //-----------------------------------------------------DESPLIEGE DEL FORMULARIO PARA EDITAR DATOS----------------------------------------------//
    var marker2; // Variable para almacenar el marcador
    // Función para abrir o cerrar el formulario
    function toggleForm2() {
      $('#form2').toggle();
      if ($('#form2').is(':visible')) {
        // Si el formulario se muestra, agregar el evento de clic al mapa
        map.on('click', onMapClick);
      } else {
        // Si el formulario se oculta, eliminar el marcador y el evento de clic del mapa
        map.off('click', onMapClick);
        if (marker2) {
          map.removeLayer(marker2);
          marker2 = null; // Eliminar la referencia al marcador
        }
      }
    }
    // Manejador de eventos para el clic en el mapa
    function onMapClick(e) {
      if ($('#form2').is(':visible')) {
        // Verificar si el formulario está visible
        if (marker2) {
          map.removeLayer(marker2);
        }
        var lat = e.latlng.lat;
        var long = e.latlng.lng;
        marker2 = L.marker([lat, long]).addTo(map);
        document.getElementById('lat').value = lat;
        document.getElementById('long').value = long;
      }
    }
    // Función para cancelar el formulario
    function cancelForm() {
      document.getElementById('form2').style.display = 'none';
    }
    // Obtener referencia al contenedor del formulario
    var formContainer = document.getElementById('formContainer');
    // Obtener referencia al botón de cancelar
    var cancelEditingBtn = document.getElementById('cancelEditingBtn');
    // Establecer el manejador de eventos para el botón de cancelar
    cancelEditingBtn.addEventListener('click', function() {
      toggleForm2();
    });
    // Crear el botón de mostrar/ocultar formulario
    var editButton = L.easyButton('fa-pencil', function() {
      toggleForm2();
    }, 'Editar Punto').addTo(map);
    //---------------------------------------------------------------------ESCALA-------------------------------------------------------------//
    L.control.scale({position:'bottomleft'}).addTo(map);
    //-------------------------------------------------------------CREAR Y UBICAR MINIMAPA----------------------------------------------------//
    var urlminimap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {attribution: 'Univalle',subdomains: '2023',maxZoom: 24});
    var minimap = new L.Control.MiniMap(urlminimap,{
      toggleDisplay: true,
      minimized: true,
      width: 150,
      height: 150,
      position: "bottomleft",
      strings: {hideText: 'Ocultar MiniMapa', showText: 'Mostrar MiniMapa'}
    }).addTo(map);
    //----------------------------------------------------------CREAR CONTROL DE BUSQUEDA-----------------------------------------------------//
    map.addControl(L.control.search({ position: 'topright' }));
    //---------------------------------------------------------------TABLA DE DATOS-----------------------------------------------------------//
    const right = '<div class="header">TABLA DE DATOS</div>';
    let contentsright = `<div class="content">
      <h6>Este menu corresponde a la tabla con los datos de los Centros Culturales de la Comuna 03, además le permite visualizar la ubicacion especifica 
      de algun registro mediante el boton "Ir a..."  que acerca a dicho registro y lo representa con un marcador.</h6>
      <!-- Agrega la tabla dentro del panel -->
      <table class="table" id="locationsTable">
        <!-- Encabezado de tabla -->
        <thead>
          <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Acercar</th>
          </tr>
        </thead>
        <tbody>
          <?php
            // Consulta SQL para obtener los puntos
            $query = "SELECT id, nombre, categoria,ST_X(geom) as lng, ST_Y(geom) as lat FROM cen_culturales";
            $result = pg_query($conexion, $query);
            if (!$result) {
              echo "Error al obtener los puntos.";
              exit;
            }
            // Array para almacenar marcadores
            $markers = [];
            // Iterar resultados, generar las filas de la tabla y marcadores
            while ($row = pg_fetch_assoc($result)) {
              $id = $row['id'];
              $nombre = $row['nombre'];
              $categoria = $row['categoria'];
              $lat = $row['lat'];
              $lng = $row['lng'];
              echo "<tr>";
              echo "<td>$id</td>";
              echo "<td>$nombre</td>";
              echo "<td>$categoria</td>";
              echo "<td><button onclick=\"zoomToLocation($lat, $lng)\"> Ir a...</button></td>";
              echo "</tr>";
            }
          ?>
        </tbody>
      </table>
    </div>`;
    var currentMarker;
    // Funcion para acercamiento a puntos individuales
    function zoomToLocation(lat, lng, nombre) {
      if (currentMarker) {
        map.removeLayer(currentMarker);
      }
      // Creación de marcador en el punto 
      currentMarker = L.marker([lat, lng]).addTo(map);
      map.flyTo([lat, lng], 18);
    }
    /* SLIDEMENU RIGTHT */
    const slideMenu = L.control.slideMenu("", {
      position: "topright",
      menuposition: "topright",
      width: "40%",
      height: "500px",
      delay: "10",
      icon: "fa fa-table",
    }).addTo(map);
    slideMenu.setContents(right + contentsright);
    //---------------------------------------------------------------CAPA WMS---------------------------------------------------------------//	
    var comuna3 = L.tileLayer.wms('http://ws-idesc.cali.gov.co:8081/geoserver/wms?service=WMS&version=1.1.0',{
      layers: 'idesc:mc_comunas',
      format: 'image/png',
      transparent: true,
      CQL_FILTER: "nombre='Comuna 3'",
    });
    map.addLayer(comuna3);
    leyenda.addOverlay(comuna3, 'Comuna 03');
	</script>
</html> 