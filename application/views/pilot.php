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
            <div class="form-group">      
              <label>Client :</label> <input id="client" type="text" class="form-control" <?php if($current_journey!=null) echo "disabled value=\"".$current_journey->client."\""; ?> ></input>
            </div>
            <div class="form-group">
              <label>Heure :</label> <input id="heure" type="text" class="form-control" <?php if($current_journey!=null) echo "disabled value=\"".date_format(date_create($current_journey->start_time), 'H:i')."\"";  ?>"></input> 
          </div>
            <div class="form-group">  
              <label>Depart :</label> <input id="depart" type="text"  class="form-control" <?php if($current_journey!=null) echo "disabled value=\"".$current_journey->start."\"";  ?>"></input>
          </div>
            <div class="form-group">       
              <label>Arrivée :</label> <input id="arrivee" type="text" class="form-control" <?php if($current_journey!=null) echo "disabled value=\"".$current_journey->destination."\"";  ?>"></input>
            </div>

            <div class="form-group">
              <a class="btn btn-primary bt-sm"  href="#" onclick="click_end_journey(<?php echo $current_journey==null ;?>)">Terminer la course</a>  
              <a class="btn btn-success bt-sm"  href="#" onclick="click_pending_journey(<?php echo $current_journey==null ;?>)">Mettre en attente</a>
            </div>

          </div>

          <div class="col-sm-4 col-lg-4">
            <h2 class="h4">Courses suivantes</h2>

            <?php foreach ($pending_journeys as $j): ?>

            <p>         
              <a class="btn btn-info btn-lg" href="#" onclick="click_journey(<?php echo $j->journey_id ;?>)"><?php echo date_format(date_create($j->start_time), 'H:i')." $j->client $j->start"; ?></a>
            </p>

            <?php endforeach; ?>

          </div>
          <div class="col-sm-4 col-lg-4">
            <h2 class="h4">Status</h2>
            <p>
               <?php if ($state == 2) $attr="checked"; else $attr=""; ?>
              <input id="switch-dispo" type="checkbox" <?php echo $attr ; ?> data-size="large" data-on-color="danger" data-off-color="success" data-on-text="Occupé" data-off-text="Libre">
            </p>
        </div>
      </div>
    </div>

    <script src="<?php echo base_url("assets/js/jquery.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/bootstrap-switch.js"); ?>"></script>
    <script>

    function api(jreq,reload) {
      $.post("index.php/api",{req : JSON.stringify(jreq) }, function(data, status){
        if(reload) location.reload();
      });
    }

    function click_journey(journey_id) {
      //TODO ask confirm if fields not empty
      api({"f" : "setCurrentJourney", "id": journey_id},true);
    }

    function click_end_journey(new_journey) {
      //TODO ask confirm
      if(new_journey) 
        location.reload();    
      else  
        api({"f" : "endCurrentJourney"},true);
    }

    function click_pending_journey(new_journey) {
      if(new_journey)
        api({"f" : "addJourney", 
             "customer_name" : $('input#client').val(), 
             "start_addr" : $('input#depart').val(), 
             "destination_addr" : $('input#arrivee').val(), 
             "start_time" : $('input#heure').val()
        },true);
      else
        api({"f" : "pendingCurrentJourney"},true);
    }

    function updatePos(position) {
      api({"f" : "setPos", "lat": position.coords.latitude,"long" : position.coords.longitude},false);
    }

    function requestPos(argument){
      navigator.geolocation.getCurrentPosition(updatePos);
    }

    //TODO on field focus exit => save field in bicyle "note"

    var switchdispo = $('input#switch-dispo');

    $(function(argument) {
      switchdispo.bootstrapSwitch();
    })

    switchdispo.on('switchChange.bootstrapSwitch', function(event, state) {
      //TODO disable text fields if busy enable else
      api({"f" : "setPilotState", "state": state ? "2" : "1"},false);
    });

    setInterval(requestPos,10000);

    </script>
  </body>
</html>
