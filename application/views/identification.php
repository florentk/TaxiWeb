<?php
  defined('BASEPATH') OR exit('No direct script access allowed');



?>

     <div class="container">
        <div class="row">
          <div class="col-sm-4 col-lg-4">

            <div class="form-group">      
              <label>Nom du pilote :</label> <input id="pilot_name" type="text" class="form-control" value="<?php echo $name; ?>"></input>
            </div>

            <div class="form-group">
              <label >Nom du vélo :</label>
              <select class="form-control" id="bicycle_id">
                <?php foreach ($bicycles as $b): ?>
                  <?php if ($b->state === "garage"): ?>
                    <option value="<?php echo $b->num; ?>"><?php echo $b->num;  ?></option>
                  <?php endif ?>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <button class="btn btn-danger bt-sm"  href="#" onclick='click_identification();'>M'identifier</button>  
            </div>
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

  function click_identification() {
    api({ "f" : "setBicycleId", 
          "bicycle_id": $('select#bicycle_id').val(),
          "pilot_name": $('input#pilot_name').val()
    },true);
  }

   function submitenter(myfield,e) { 
      var keycode; 

      if (window.event) 
        keycode = window.event.keyCode; 
      else if (e) 
        keycode = e.which; 
      else 
        return true; 

      if (keycode == 13) {  
        click_identification(); 
        return false; 
      } else 
        return true; 
   }

</script>
