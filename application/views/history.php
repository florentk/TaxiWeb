<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
?>

  <div class="container">
      <table class="table table-striped">
          <thead>
              <tr>
                  <th>Pilote</th>
                  <th>Client</th>
                  <th>Départ</th>
                  <th>Destination</th>
                  <th>Heure de départ</th>
                  <th>Heure d'arrivée</th>
              </tr>
          </thead>
          <tbody>
            <?php foreach ($history as $j): ?>
            <tr>
                  <td><?php echo $j->pilot; ?></td>
                  <td><?php echo $j->client; ?></td>
                  <td><?php echo $j->start; ?></td>
                  <td><?php echo $j->destination; ?></td>
                  <td><?php echo $j->start_time; ?></td>
                  <td><?php echo $j->end_time; ?></td>
            </tr>
            <?php endforeach; ?>              
          </tbody>
      </table>
  </div>


