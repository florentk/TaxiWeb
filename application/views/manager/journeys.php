<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  $panelcls = array('garage' => 'panel-primary', 'free' => 'panel-success', 'busy' => 'panel-danger', 'sos' => 'panel-danger');

  function format_journey($j) {
    echo date_format(date_create($j->start_time), 'H:i')." $j->pilot $j->client";
  }

?>



    <div class="container">
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addJourney">Ajouter course ...</button>
        <a class="btn btn-info btn-lg"  href="history">Historique</a>
    </div>
    <div class="container">
        <div class="row">

          <div class="col-sm-3 col-lg-3">
          <h2 class="h4">Courses non affectées</h2>
          <?php foreach ($unaffected_journeys as $j): ?>
            <div class="form-group">         
              <button class="btn btn-primary btn-default" href="#" ><?php format_journey($j); ?></a>
            </div>
          <?php endforeach; ?>
          </div>

          <div class="col-sm-3 col-lg-3">
          <h2 class="h4">Courses à confirmer</h2>
          <?php foreach ($request_journeys as $j): ?>
            <div class="form-group">         
              <button class="btn btn-danger btn-default" href="#" ><?php format_journey($j); ?></a>
            </div>
          <?php endforeach; ?>
          </div>

          <div class="col-sm-3 col-lg-3">
          <h2 class="h4">Courses en attente</h2>
          <?php foreach ($pending_journeys as $j): ?>
            <div class="form-group">         
              <button class="btn btn-info btn-default" href="#" ><?php format_journey($j); ?></a>
            </div>
          <?php endforeach; ?>
          </div>


          <div class="col-sm-3 col-lg-3">
          <h2 class="h4">Courses en cours</h2>
          <?php foreach ($inprogress_journeys as $j): ?>
            <div class="form-group">         
              <button class="btn btn-success btn-default" href="#" ><?php format_journey($j); ?></a>
            </div>
          <?php endforeach; ?>
          </div>

        </div>

    </div>







