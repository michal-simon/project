<div id="container-agen">
		<div id="rgba">


    <?php
    if(isLoggedin()):
    
      $db->executeSql("SELECT * FROM  tb_clientdata WHERE cod_dataC = '{$user['id_login']}'");
      $result = $db->fetch();
      $db->closeConnection();
    ?>

      <div id="container-a">
        <div id="div-ag" class="bk-azul-escuro box-s">
          <h2 class="color-white"><i class="far fa-calendar-alt" style="margin-right: 6px; font-size: 24px;"></i> Booking</h2>

  		    <div id="booking" class="box-s">

            <form id="form_data" method="post" action="<?php echo $url->getBase();?>ajax/?action=update_data">
              <div> <!-- inline/two inputs same line -->
                <div style="width: 60%; float: left;">
                  <label>Full Name</label><br>
                    <?php echo '<input type="text" name="name_data" maxlength="120" value="'.(isset($result['name_dataC']) ? $result['name_dataC'] : '').'"  required style="width: 170px;" ><br>'; ?>
                </div>
                <div style="width: 40%; float: left;">
                  <label>Phone</label><br>
                    <?php echo '<input type="text" name="phone_data" maxlength="11" value="'.(isset($result['phone_dataC']) ? $result['phone_dataC'] : '').'"  required style="width: 110px;"><br>'; ?>
                </div>
              </div> 

              <div> <!-- inline/two inputs same line -->
                <div style="width: 50%; float: left;">
                  <label>ID number</label><br>
                    <?php echo '<input type="text" name="id_data" maxlength="9" value="'.(isset($result['id_dataC']) ? $result['id_dataC'] : '').'" required style="width: 110px;"> '; ?>
                </div>
                <div style="width: 50%; float: left;">
                  <label>Date of birth</label><br>
                    <?php echo '<input type="date" name="date_birth_data" value="'.(isset($result['dt_birth_dataC']) ? $result['dt_birth_dataC'] : '').'" required style="width: 125px; padding: 4px;">' ; ?>
                </div>
              </div>
              <button type="submit" id="ad_place" class="bk-azul-escuro color-white"> Update Data </button>
            </form>

              <br style="clear: both;">
              <hr style="margin: 9px 0;">

              <form id="form_consultation" method="post" action="<?php echo $url->getBase();?>ajax/?action=find_time"> 
                <label>Date and Place</label><br>
                  <p style="margin: 0;"> 
                    <select id="place_consultation" name="place_consultation">
                      <option>Dublin</option>
                      <option>Cork</option>
                    </select>
                    <input type="date" id="date_consultation" name="date_consultation" required> 
                  </p>

                  <p style="margin: 0;">                   
                    <input type="submit" value="Search Slot" id="searchslot"> <!-- gera o horario através do php e volta a resposta pelo ajax -->
                    <select id="resp_consultation" style="width: 90px; padding: 6px;"> <!-- recebe options pelo php --> </select>
                  </p> 
                <button type="button" onclick="dateAtime()" id="ad_place" class="bk-azul-escuro color-white"> Insert date and time </button>
              </form>

              <form id="form_booking" method="post" action="<?php echo $url->getBase();?>ajax/?action=insert_booking" style="clear: both;">
                <!-- exibs date and time chosen -->
                <p style="margin: 0;"> 
                  <input type="text" style="width: 67px; margin: 5px 0;" id="dt_a" name="date_booking" readonly>  
                  <input type="text" style="width: 33px; margin: 5px 0;" id="hr_a" name="time_booking" readonly>  
                  <input type="text" style="width: 113px; margin: 5px 0;" id="loc_a" name="place_booking" readonly>
                </p>
                <hr style="margin: 0;">
                <button type="submit" id="book" class="bk-azul-escuro color-white"> Make Appointment </button>
                <br style="clear: both;"> 
                <p id="resp_booking">  </p> <!-- receive answer php, via ajax -->
              </form>

            </div><!-- booking -->
        </div><!-- div-ag -->

        <!-- _________________________________________________________________________________________________________ -->

        <div id="div-all" class="box-s bk-azul-escuro ">
          <h3 style="margin: 7px;" class="color-white">My Bookings</h3>
            <?php 
            $db->executeSql("SELECT * FROM tb_booking INNER JOIN tb_clientdata ON (tb_booking.cod_dataC=tb_clientdata.cod_dataC) WHERE tb_clientdata.login_dataC='{$user['email_login']}' ORDER BY tb_booking.id_booking DESC");
            $result = $db->fetchAll();
            $db->closeConnection();
            if(count($result) > 0) {
              foreach($result as $row){
            ?>
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
            <?php
              }
            } else {              
              echo "<h2 class='nobooking'> There`s no appointment!</h2>";
            }?>
        </div><!--  div-all -->
      </div><!-- container-a -->

    <?php else: ?>

      <div id='restrict' class='bk-azul color-white'>
      <i class="fas fa-ban" style="font-size:50px;"></i><br><br>
      <h1 style='margin:0;'>You have to be logged in to access this page!</h1><br>
      <h3 style='margin:0;'> <a href="<?php echo $url->getBase(); ?>" class="color-white">Go to homepage</a></h3>
      </div>

    <?php endif; ?>
      
    </div><!-- rgba -->
	</div><!-- container-agen -->