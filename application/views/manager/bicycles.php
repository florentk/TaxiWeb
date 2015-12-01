<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  $panelcls = array('garage' => 'panel-primary', 'free' => 'panel-success', 'busy' => 'panel-danger', 'sos' => 'panel-danger');

?>



    <div class="container">
        <div class="row">


          <?php foreach ($bicycles as $b): ?>
          <div class="col-sm-3 col-lg-3">
            <div class="<?php echo "panel ".$panelcls[$b->state] ;?>">
              <div class="panel-heading">
                <h3 class="panel-title"><?php echo "Vélo ".$b->num; ?> <span onclick="click_garage(<?php echo $b->bicycle_id; ?>)" class='glyphicon glyphicon-home'/></h3>
              </div>
              <div class="panel-body">
                <h4><b><?php if ($b->pilot == "") echo $b->state; else echo $b->pilot." - ".$b->state; ?></b></h4>
                <h4><?php echo "<a href='http://www.openstreetmap.org/?mlat=$b->latitude&mlon=$b->longitude&zoom=16'> $b->latitude $b->longitude </a></h4>"; ?>
                <h4><?php echo $b->nb_progress_journey; ?> courses en attente</h4>





              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
    </div>

  <script>
  function click_garage(id) {
      api({"f" : "garage", 
           "id" : id
      },true);
  }

</script>
<!--
  <div id="mapdiv"></div>
  <script src="http://www.openlayers.org/api/OpenLayers.js"></script>
  <script>
    map = new OpenLayers.Map("mapdiv");
    map.addLayer(new OpenLayers.Layer.OSM());
 
    var lonLat = new OpenLayers.LonLat( -0.1279688 ,51.5077286 )
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
            map.getProjectionObject() // to Spherical Mercator Projection
          );
 
    var zoom=16;
 
    var markers = new OpenLayers.Layer.Markers( "Markers" );
    map.addLayer(markers);
 
    markers.addMarker(new OpenLayers.Marker(lonLat));
 
    map.setCenter (lonLat, zoom);
  </script>
-->
