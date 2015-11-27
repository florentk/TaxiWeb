<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  function format_journey($j) {
    echo date_format(date_create($j->start_time), 'H:i')." $j->client $j->start";
  }

?>

     <div class="container">
        <div class="row">
          <div class="col-sm-4 col-lg-4">


            <h2 class="h4">Course courante</h2>
            
            <?php if($current_journey!=null): ?>
              <div class="form-group">         
                <button class="btn btn-success btn-lg" href="#" onclick="click_end_journey(false)"><?php format_journey($current_journey); ?></a>
              </div>
            <?php endif ?>

            <div class="form-group">      
              <label>Client :</label> <input id="client" type="text" class="form-control" <?php if($current_journey!=null) echo "disabled value=\"".$current_journey->client."\""; ?> ></input>
            </div>
            <div class="form-group">  
              <label>Depart :</label> <input id="depart" type="text"  class="form-control" <?php if($current_journey!=null) echo "disabled value=\"".$current_journey->start."\"";  ?>"></input>
          </div>
            <div class="form-group">       
              <label>Arrivée :</label> <input id="arrivee" type="text" class="form-control" <?php if($current_journey!=null) echo "disabled value=\"".$current_journey->destination."\"";  ?>"></input>
            </div>
            <div class="form-group">
              <label>Heure :</label> <input id="heure" type="text" class="form-control" <?php if($current_journey!=null) echo "disabled value=\"".date_format(date_create($current_journey->start_time), 'H:i')."\"";  ?>"></input> 
          </div>

            <div class="form-group">
              <button class="btn btn-danger bt-sm"  href="#" onclick="event.target.disabled=true;click_end_journey(<?php echo $current_journey==null ;?>)">Terminer la course</button>  
              <button class="btn btn-info bt-sm"  href="#" onclick="event.target.disabled=true;click_pending_journey(<?php echo $current_journey==null ;?>)">Mettre en attente</button>
            </div>

          </div>

          <div class="col-sm-4 col-lg-4">
            <h2 class="h4">Courses à venir</h2>

            <?php foreach ($pending_journeys as $j): ?>

            <div class="form-group">         
              <button class="btn btn-info btn-lg" href="#" onclick="event.target.disabled=true;click_journey(<?php echo $j->journey_id ;?>)"><?php format_journey($j); ?></a>
            </div>

            <?php endforeach; ?>

          </div>


          <div class="col-sm-4 col-lg-4">
            <h2 class="h4">Courses à confirmer</h2>

            <?php foreach ($request_journeys as $j): ?>

            <div class="form-group">         
              <button class="btn btn-danger btn-lg" href="#" onclick="event.target.disabled=true;click_confirm_journey(<?php echo $j->journey_id ;?>)"><?php format_journey($j); ?></a>
            </div>

            <?php endforeach; ?>

          </div>

          <div class="col-sm-4 col-lg-4">
            <h2 class="h4">Status</h2>
            <div class="form-group"> 
               <?php if ($state == 2) $attr="checked"; else $attr=""; ?>
              <input id="switch-dispo" type="checkbox" <?php echo $attr ; ?> data-size="large" data-on-color="danger" data-off-color="success" data-on-text="Occupé" data-off-text="Libre">
            </div>
            <div class="form-group">         
              <button class="btn btn-info btn-lg" href="#" onclick="click_exit();">Quitter</a>
            </div>
          </div>

      </div>
    </div>

    <script src="<?php echo base_url("assets/js/jquery.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/js/bootstrap-switch.js"); ?>"></script>
    <script>

    function api(jreq,reload) {
      $.post("index.php/api",{req : JSON.stringify(jreq) }, function(data, status){
        if(reload) location.reload(true);
      });
    }

    function add_journey(state, reload) {
      api({"f" : "addJourney", 
     "customer_name" : $('input#client').val(), 
     "start_addr" : $('input#depart').val(), 
     "destination_addr" : $('input#arrivee').val(), 
     "start_time" : $('input#heure').val(),
     "state" : state
        },reload);
    }

    function click_journey(journey_id) {
      //TODO test field not null
      if(confirm("Commencer la course ?"))
        api({"f" : "setCurrentJourney", "id": journey_id},true);
    }

    function click_confirm_journey(journey_id) {
      //TODO test field not null
      if(confirm("Confirmer la course ?"))
        api({"f" : "confirmJourney", "id": journey_id},true);
    }

    function click_end_journey(new_journey) {
      if(confirm("Terminer la course ?")){
        if(new_journey) 
          add_journey(3,true);   
        else  
          api({"f" : "endCurrentJourney"},true);
      }
    }

    function click_pending_journey(new_journey) {
      if(new_journey)
        add_journey(0,true);
      else
        api({"f" : "pendingCurrentJourney"},true);
    }

    function click_exit() {
        api({"f" : "unsetBicycleId"},true);
    }    

    function updatePos(){
      navigator.geolocation.getCurrentPosition(function(position) {
        api({"f" : "setPos", "lat": position.coords.latitude,"long" : position.coords.longitude},false);
    });}

    //TODO on field focus exit => save field in bicyle "note"

    var switchdispo = $('input#switch-dispo');

    $(function(argument) {
      switchdispo.bootstrapSwitch();
    })

    switchdispo.on('switchChange.bootstrapSwitch', function(event, state) {
      //TODO disable text fields if busy enable else
      api({"f" : "setPilotState", "state": state ? "2" : "1"},false);
    });

    updatePos();
    setInterval(updatePos,30000);

    </script>

