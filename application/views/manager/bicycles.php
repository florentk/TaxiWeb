<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  $panelcls = array('garage' => 'panel-primary', 'free' => 'panel-success', 'busy' => 'panel-danger', 'sos' => 'panel-danger');

?>


    <div class="container">
        <div class="row">


          <?php foreach ($bicycles as $b): ?>
          <div class="col-sm-3 col-lg-3">
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
          </div>
          <?php endforeach; ?>
        </div>
    </div>

