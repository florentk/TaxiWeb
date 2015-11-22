<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header("Cache-Control: max-age=0");
?><!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bicycle Manager - Taxiweb</title>

    <link href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/highlight.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/bootstrap3/bootstrap-switch.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/main.css"); ?>" rel="stylesheet">

    <?php
       $panelcls = array('garage' => 'panel-primary', 'free' => 'panel-success', 'busy' => 'panel-danger', 'sos' => 'panel-danger');

      function format_journey($j) {
        echo date_format(date_create($j->start_time), 'H:i')." $j->pilot $j->client";
      }
    ?>

  </head>
  <body>

    <div class="container">
        <div class="row">
          <div class="col-sm-3 col-lg-3">

          <?php foreach ($bicycles as $b): ?>
            <div class="<?php echo "panel ".$panelcls[$b->state] ;?>">
              <div class="panel-heading">
                <h3 class="panel-title"><?php echo $b->num; ?></h3>
              </div>
              <div class="panel-body">
                <p><?php echo $b->pilot." - ".$b->state; ?></p>
                <p><?php echo $b->latitude." ".$b->longitude; ?></p>
              </div>
            </div>
          <?php endforeach; ?>



          </div>
        </div>
    </div>

    <div class="container">
        <div class="row">

          <div class="col-sm-3 col-lg-3">
          <h2 class="h4">Courses non affectées</h2>
          <?php foreach ($unaffected_journeys as $j): ?>
            <div class="form-group">         
              <button class="btn btn-primary btn-lg" href="#" ><?php format_journey($j); ?></a>
            </div>
          <?php endforeach; ?>
          </div>

          <div class="col-sm-3 col-lg-3">
          <h2 class="h4">Courses à confirmer</h2>
          <?php foreach ($request_journeys as $j): ?>
            <div class="form-group">         
              <button class="btn btn-danger btn-lg" href="#" ><?php format_journey($j); ?></a>
            </div>
          <?php endforeach; ?>
          </div>

          <div class="col-sm-3 col-lg-3">
          <h2 class="h4">Courses en attente</h2>
          <?php foreach ($pending_journeys as $j): ?>
            <div class="form-group">         
              <button class="btn btn-info btn-lg" href="#" ><?php format_journey($j); ?></a>
            </div>
          <?php endforeach; ?>
          </div>


          <div class="col-sm-3 col-lg-3">
          <h2 class="h4">Courses en cours</h2>
          <?php foreach ($inprogress_journeys as $j): ?>
            <div class="form-group">         
              <button class="btn btn-success btn-lg" href="#" ><?php format_journey($j); ?></a>
            </div>
          <?php endforeach; ?>
          </div>

        </div>
    </div>

  </body>
  <footer>
     <div class="container">
   <p>Created by <a href="http://lille.bike">LILLE.BIKE <span class='glyphicon glyphicon-registration-mark'></span></a></p>


    </div>
  </footer>
</html>
