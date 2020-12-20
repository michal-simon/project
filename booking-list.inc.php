<div id="container-agen">
		<div id="rgba">

    <?php
    if(isLoggedin()):
      if($user['access_login'] == 2):
    ?>
      <div id="container-a">
        <ul class="list">
          <?php
          $db->executeSql("SELECT * FROM tb_booking INNER JOIN tb_clientdata ON (tb_booking.cod_dataC=tb_clientdata.cod_dataC) ORDER BY tb_booking.id_booking DESC");
          $result = $db->fetchAll();
          $db->closeConnection();
          if(count($result) > 0) {
            foreach($result as $row) {
          ?>
          <li>
              <div class="card">
                  <p style="font-size: 16px;" class="phrase highlight">Office: <?php echo $row['place_booking'].' - <span id="cor">'. $row['status_booking'] .'</span>'; ?></p>
                  <p class="space highlight font15"><?php echo date('d/m/Y', strtotime($row['date_booking'])).' - '.$row['time_booking']; ?> </p> 
                  <p class="phrase font15"><span class="highlight">ID:</span> <?php echo $row['id_dataC']; ?> </p>
                  <p class="phrase font15"><span class="highlight">Name:</span> <?php echo $row['name_dataC']; ?> </p>
                  <p class="phrase font15"><span class="highlight">Phone:</span> <?php echo $row['phone_dataC']; ?> </p>
                  <p class="phrase font15"><span class="highlight">Date of Birth:</span> <?php echo date('d/m/Y', strtotime($row['dt_birth_dataC'])); ?> </p>
                  <?php   
                    if($row['status_booking'] == "Booked") {
                  ?>
                    <form method="post" action="<?php echo $url->getBase();?>ajax/?action=cancel_booking" id="form_cancel" onsubmit='return confirm("Are you sure you want to cancel your appointment?")'>
                      <input type="hidden" name="id_booking" value=<?php echo $row['id_booking']; ?> />
                      <input type="submit" name="del_message" class="cancel_cons" value="Cancel Appointment">
                    </form> 
                  <?php
                    } 
                  ?>
              </div>
          </li>  
                  
          <?php
              }
            } else {              
              echo "<h2 class='nobooking'> There`s no appointment!</h2>";
            }?>
        </ul>
      </div>
    <?php 
      else:
    ?>
      <div id='restrict' class='bk-azul color-white'>
        <i class="fas fa-ban" style="font-size:50px;"></i><br><br>
        <h1 style='margin:0;'>You have no privileges to view this page!</h1><br>
        <h3 style='margin:0;'> <a href="<?php echo $url->getBase(); ?>" class="color-white">Go to homepage</a></h3>
      </div>
    <?php
      endif;
    else: 
    ?>

      <div id='restrict' class='bk-azul color-white'>
        <i class="fas fa-ban" style="font-size:50px;"></i><br><br>
        <h1 style='margin:0;'>You have to be logged in to access this page!</h1><br>
        <h3 style='margin:0;'> <a href="<?php echo $url->getBase(); ?>" class="color-white">Go to homepage</a></h3>
      </div>

    <?php endif; ?>
      
    </div><!-- rgba -->
	</div><!-- container-agen -->