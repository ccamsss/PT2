
      const map = L.map("map", {
        center: [0, 0],
        zoom: 4,
        zoomControl: false,
      });

      L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
        attribution:
          '&copy; <a href="http://osm.org/copyright" target="_blank">OpenStreetMap</a> contributors',
      }).addTo(map);
      function info_popup(feature, layer){
        layer.bindPopup("<h1>" + feature.properties.nombre + "</h1><hr>"+"<strong> Identificación: </strong>"+feature.properties.id+"<br/>"+"<strong> Categoria: </strong>"+feature.properties.categoria+"<br/>");
    }
    //carga la capa como geojson desde la gdb
    var cen_culturales = L.geoJSON();
        $.post("php/conect.php",
            {
                peticion: 'cargar',
            },function (data, status, feature)
            {
            if(status=='success')
            {
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
      /* contents */
      const left = '<div class="header">Slide Menu (Left)</div>';
      const right = '<div class="header">Slide Menu (Right)</div>';
      let contents = `
            <div class="content">
                <div class="title">Read Me</div>
                <p>A simple slide menu for Leaflet.<br>
                When you click the menu button and the menu is displayed to slide.<br>
                Please set the innerHTML to slide menu.</p>
                <div class="title">Usage</div>
                <p>L.control.slideMenu("&lt;p&gt;test&lt;/p&gt;").addTo(map);</p>
                <div class="title">Arguments</div>
                <p>L.control.slideMenu(&lt;String&gt;innerHTML, &lt;SlideMenu options&gt;options?)</p>
                <div class="title">Options</div>
                <p>position<br>
                menuposition<br>
                width<br>
                height<br>
                direction<br>
                changeperc<br>
                delay<br>
                icon<br>
                hidden</p>
                <div class="title">Methods</div>
                <p>setContents(&lt;String&gt;innerHTML)</p>
                <div class="bottom">
                    <span>License <span style="font-weight: bold">MIT</span></span>
                </div>
            </div>`;

      /* left */
      L.control.slideMenu(left + contents).addTo(map);

      /* right */
      const slideMenu = L.control
        .slideMenu("", {
          position: "topright",
          menuposition: "topright",
          width: "30%",
          height: "400px",
          delay: "50",
          icon: "chevron-left",
        })
        .addTo(map);
      slideMenu.setContents(right + contents);
