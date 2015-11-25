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
                <h3 class="panel-title"><?php echo "Vélo ".$b->num; ?></h3>
              </div>
              <div class="panel-body">
                <h4><b><?php echo $b->pilot." - ".$b->state; ?></b></h4>
                <h4><?php echo $b->latitude." ".$b->longitude; ?></h4>
                <h4># courses en attente</h4>
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
        <a class="btn btn-info bt-sm"  href="history">Historique</a>
    </div>

    <div class="container">
        <div class="row">

          <div class="col-sm-3 col-lg-3">
        <div class="form-group">      
          <label>Client :</label> <input id="client" type="text" class="form-control"></input>
        </div>

        <div class="form-group">      
          <label>Départ :</label> <input id="depart" type="text" class="form-control"></input>
        </div>

        <div class="form-group">      
          <label>Arrivée :</label> <input id="arrivee" type="text" class="form-control"></input>
        </div>

        <div class="form-group">      
          <label>Heure d'enlévement :</label> <input id="heure_depart" type="text" class="form-control"></input>
        </div>

        <div class="form-group">      
          <label>Heure de dépôt :</label> <input id="heure_arrivee" type="text" class="form-control"></input>
        </div>


        <div class="form-group">
          <label >Affecté à:</label>
          <select class="form-control" id="affectation">
            <option value="null">Affecter plus tard</option>
            <?php foreach ($bicycles as $b): ?>
              <option value="<?php echo $b->bicycle_id; ?>"><?php echo $b->pilot; ?></option>
            <?php endforeach; ?>
          </select>
        </div>


        <div class="btn-group">
          <button class="btn btn-info bt-sm"  href="#" onclick="event.target.disabled=true;click_add_journey();">Ajouter</button>
        </div>  
          </div>

        </div>      
    </div>
    <script src="<?php echo base_url("assets/js/jquery.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>"></script>
    <script>
      $(document).ready(function(){
        $('.dropdown-toggle').dropdown();
        $(".dropdown-menu li a").click(function(){
          var selText = $(this).text();
          $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
        });
      });


      function api(jreq,reload) {
        console.log(jreq);
        $.post("api",{req : JSON.stringify(jreq) }, function(data, status){
          if(reload) location.reload(true);
        });
      }

      function click_add_journey() {
          api({"f" : "managerAddJourney", 
               "bicycle_id" : $('select#affectation').val(), 
               "customer_name" : $('input#client').val(), 
               "start_addr" : $('input#depart').val(), 
               "destination_addr" : $('input#arrivee').val(), 
               "start_time" : $('input#heure_depart').val(),
               "end_time" : $('input#heure_arrivee').val()
          },true);
      }

    </script>
  </body>
  <footer>
     <div class="container">
   <p>Created by <a href="http://lille.bike">LILLE.BIKE <span class='glyphicon glyphicon-registration-mark'></span></a></p>

    </div>
  </footer>
</html>
