<?php
  defined('BASEPATH') OR exit('No direct script access allowed');


?>



<div id="updateJourney" class="<?php echo $main_class ?>" role="dialog">
  <div class="<?php echo $prefix_class ?>-dialog">

    <!-- Modal content-->
    <div class="<?php echo $prefix_class ?>-content">
      <div class="<?php echo $prefix_class ?>-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="<?php echo $prefix_class ?>-title">Modifier une course</h4>
      </div>
      <div class="<?php echo $prefix_class ?>-body">

        <input type="hidden" id="id"> </input>

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
          <button type="button" class="btn btn-default" data-dismiss="modal"  href="#" onclick="click_update_journey();">Ok</button>
        </div>    


      </div>

    </div>

  </div>
</div>

<script>

  function click_update_journey() {
      api({"f" : "affecteJourney", 
           "id" :  $('#updateJourney input#id').text(),
           "bicycle_id" : $('#updateJourney select#affectation').val()
      },true);
  }

  function showModalUpdateJourney(id) {
    $("div#updateJourney #id").text(id);
    $('#updateJourney').modal('show');
  }



</script>
