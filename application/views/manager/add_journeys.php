<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
?>



<div id="addJourney" class="<?php echo $main_class ?>" role="dialog">
  <div class="<?php echo $prefix_class ?>-dialog">

    <!-- Modal content-->
    <div class="<?php echo $prefix_class ?>-content">
      <div class="<?php echo $prefix_class ?>-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="<?php echo $prefix_class ?>-title">Ajouter une course</h4>
      </div>
      <div class="<?php echo $prefix_class ?>-body">


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
              <option value="<?php echo $b->bicycle_id; ?>"><?php echo "Vélo ".$b->bicycle_id." - ".$b->pilot; ?></option>
            <?php endforeach; ?>
          </select>
        </div>





        <div class="<?php echo $prefix_class ?>-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"  href="#" onclick="event.target.disabled=true;click_add_journey();">Ajouter</button>
        </div>    


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
           "bicycle_id" : $('#addJourney select#affectation').val(), 
           "customer_name" : $('#addJourney input#client').val(), 
           "start_addr" : $('#addJourney input#depart').val(), 
           "destination_addr" : $('#addJourney input#arrivee').val(), 
           "start_time" : $('#addJourney input#heure_depart').val(),
           "end_time" : $('#addJourney input#heure_arrivee').val()
      },true);
  }

</script>
