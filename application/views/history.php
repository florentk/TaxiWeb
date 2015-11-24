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
    <link href="<?php echo base_url("assets/css/main.css"); ?>" rel="stylesheet">
  </head>
  <body>

  <div class="container">
      <table class="table table-striped">
          <thead>
              <tr>
                  <th>Pilote</th>
                  <th>Client</th>
                  <th>Départ</th>
                  <th>Destination</th>
                  <th>Heure de départ</th>
                  <th>Heure d'arrivée</th>
              </tr>
          </thead>
          <tbody>
            <?php foreach ($history as $j): ?>
            <tr>
                  <td><?php echo $j->pilot; ?></td>
                  <td><?php echo $j->client; ?></td>
                  <td><?php echo $j->start; ?></td>
                  <td><?php echo $j->destination; ?></td>
                  <td><?php echo $j->start_time; ?></td>
                  <td><?php echo $j->end_time; ?></td>
            </tr>
            <?php endforeach; ?>              
          </tbody>
      </table>
  </div>

  </body>
  <footer>
     <div class="container">
   <p>Created by <a href="http://lille.bike">LILLE.BIKE <span class='glyphicon glyphicon-registration-mark'></span></a></p>


    </div>
  </footer>
</html>
