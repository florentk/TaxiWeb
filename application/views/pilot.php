<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name; ?> - Taxiweb</title>

    <link href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/highlight.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/bootstrap3/bootstrap-switch.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/main.css"); ?>" rel="stylesheet">
  </head>
  <body>

     <div class="container">
        <div class="row">
          <div class="col-sm-4 col-lg-4">

          <h2 class="h4">Course courantes</h2>
          <div class="input-group">
          <p>         
            <label>Client :</label> <input id="client" type="text" class="form-control" value="<?php echo $current_journey->client; ?>"></input>
          </p>
          </div>
          <div class="input-group">
          <p>
            <label>Heure :</label> <input id="heure" type="text" class="form-control" value="<?php echo date_format(date_create($current_journey->start_time), 'H:i'); ?>"></input>
          </p>    
        </div>
          <div class="input-group">
          <p>       
            <label>Depart :</label> <input id="depart" type="text"  class="form-control" value="<?php echo $current_journey->start; ?>"></input>
          </p>  
        </div>
          <div class="input-group">
          <p>          
            <label>Arrivée :</label> <input id="arrivee" type="text" class="form-control" value="<?php echo $current_journey->destination; ?>"></input>
          </p>   
          </div>

          <div>
          <p>         
            <a class="btn btn-primary bt-sm" href="#">Terminer</a>  
            <a class="btn btn-success bt-sm" href="#">En attente</a>
          </p>
          </div>

          </div>
          <div class="col-sm-4 col-lg-4">
          <h2 class="h4">Courses suivantes</h2>

          <?php foreach ($pending_journeys as $j): ?>

          <p>         
            <a class="btn btn-info btn-lg" href="#"><?php echo date_format(date_create($j->start_time), 'H:i')." $j->client $j->start"; ?></a>
          </p>

          <?php endforeach; ?>

          </div>
          <div class="col-sm-4 col-lg-4">
          <h2 class="h4">Status</h2>
          <p>
             <?php if ($state == 2) $attr="checked"; else $attr=""; ?>
            <input id="switch-state" type="checkbox" <?php echo $attr ; ?> data-size="large" data-on-color="danger" data-off-color="success" data-on-text="Occupé" data-off-text="Libre">
          </p>
        </div>
      </div>
    </div>

    <script src="<?php echo base_url("assets/js/jquery.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/bootstrap-switch.js"); ?>"></script>
    <script>

    function updatePos(position) {
       alert(position.coords.latitude + " " + position.coords.longitude);
    }

    function requestPos(argument){
      navigator.geolocation.getCurrentPosition(updatePos);
    }

    // One-shot position request.
    //setInterval(requestPos,10000);
    requestPos("");

    $(function(argument) {
      $('[type="checkbox"]').bootstrapSwitch();
    })
    </script>
  </body>
</html>
