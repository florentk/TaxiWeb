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

  </body>
  <footer>
     <div class="container">
   <p>Created by <a href="http://lille.bike">LILLE.BIKE <span class='glyphicon glyphicon-registration-mark'></span></a></p>


    </div>
  </footer>
</html>
