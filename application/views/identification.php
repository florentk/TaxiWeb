<?php
  defined('BASEPATH') OR exit('No direct script access allowed');



?>

     <div class="container">
        <div class="row">
          <div class="col-sm-4 col-lg-4">




            <div class="form-group">      
              <label>Bicycle id :</label> <input id="bicycle_id" type="text" class="form-control"></input>

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
    api({"f" : "setBicycleId", "bicycle_id": $('input#bicycle_id').val()},true);
  }

  

</script>
