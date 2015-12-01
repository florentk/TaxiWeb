<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  $panelcls = array('garage' => 'panel-primary', 'free' => 'panel-success', 'busy' => 'panel-danger', 'sos' => 'panel-danger');

  function format_remove_icon ($j) {
    return "<span onclick='click_terminate_journey($j->journey_id);' class='glyphicon glyphicon-remove'/>";
  }
  
  function format_journey($j) {
    echo  date_format(date_create($j->start_time), 'H:i')." $j->pilot $j->client ".format_remove_icon($j);
  }

  function format_journey_request($j) {
    echo  "<span onclick='showModalUpdateJourney($j->journey_id)'>".date_format(date_create($j->start_time), 'H:i')." $j->pilot $j->client </span>".format_remove_icon($j);
  }

  function format_journey_unaffected($j) {
    echo  "<span onclick='showModalUpdateJourney($j->journey_id)'>".date_format(date_create($j->start_time), 'H:i')." $j->client </span>".format_remove_icon($j);
  }

?>




    <div class="container">
        <div class="row">

          <div class="col-sm-3 col-lg-3">
          <h2 class="h4">Courses non affectées</h2>
          <?php foreach ($unaffected_journeys as $j): ?>
            <div class="form-group">         
              <span class="btn btn-primary btn-default"  ><?php format_journey_unaffected($j); ?></span>
            </div>
          <?php endforeach; ?>
          </div>

          <div class="col-sm-3 col-lg-3">
          <h2 class="h4">Courses à confirmer</h2>
          <?php foreach ($request_journeys as $j): ?>
            <div class="form-group">         
              <span class="btn btn-danger btn-default"  ><?php format_journey_request($j); ?></span>
            </div>
          <?php endforeach; ?>
          </div>

          <div class="col-sm-3 col-lg-3">
          <h2 class="h4">Courses en attente</h2>
          <?php foreach ($pending_journeys as $j): ?>
            <div class="form-group">         
              <span class="btn btn-info btn-default" ><?php format_journey($j); ?></span>
            </div>
          <?php endforeach; ?>
          </div>


          <div class="col-sm-3 col-lg-3">
          <h2 class="h4">Courses en cours</h2>
          <?php foreach ($inprogress_journeys as $j): ?>
            <div class="form-group">         
              <span class="btn btn-success btn-default"  ><?php format_journey($j); ?></span>
            </div>
          <?php endforeach; ?>
          </div>

        </div>

    </div>

<script src="<?php echo base_url("assets/js/jquery.min.js"); ?>"></script>

<script>

  function api(jreq,reload) {
    $.post("index.php/api",{req : JSON.stringify(jreq) }, function(data, status){
      if(reload) location.reload(true);
    });
  }

  function click_terminate_journey(journey_id) {
    if(confirm("Terminer la course ?"))
      api({ "f" : "managerEndJourney", 
            "id" : journey_id
      },true);
  }
  

</script>





