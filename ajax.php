<?php
include_once('config/config.php');
extract($_REQUEST);
$currentdate = date("Y-m-d");
$user = $ses->getNode('logged');

if(isset($user))
    $email_user = @$user['email_login'];
    $cod_data = @$user['id_login'];

if($_POST)
{
    if($action == 'login')
    {
        $email_log = strtolower($email_log);
        $password_log = md5($password_log);

		
		
		
		
        $db->executeSql("SELECT  * FROM tb_login WHERE email_login='{$email_log}' AND password_login='{$password_log}'");
        $result = $db->fetch(); 
        $db->closeConnection();

        if($result) 
        {
            $ses->destroy();
            $ses->start();
            $ses->addNode('logged', $result);              
		    echo '<script>window.location.href = "'.$url->getBase().'"</script>';
        } else {
            echo "E-mail and/or password don`t match!";
        }
        
    } elseif($action == 'register') 
    {
        $email_cad = strtolower($email_cad);
        $password_cad = md5($password_cad);
        
		$db->executeSql("SELECT email_login FROM tb_login WHERE email_login='{$email_cad}'");
		$result = $db->fetch();  
        $db->closeConnection();

		if($result) {
			echo "E-mail already exists!";
		} else {
            if ($password_cad != md5($clone_password_cad)) {
                echo "Passwords don`t match!";
            } else {
                try {
                    $db->executeSql("INSERT INTO `tb_login` (`date_login`,`name_login`,`email_login`,`password_login`) VALUES ('{$currentdate}','{$name_cad}','{$email_cad}','{$password_cad}')");
                    $db->closeConnection();
                    echo "Registered with success!";
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }		
        }
        // inserts new notification
        $i=0;
        $db->executeSql("SELECT * FROM tb_booking WHERE dt_booking='$currentdate'");
        $result = $db->fetchAll();   
        $db->closeConnection();
        foreach($result as $row) {
            $i++;
        }

        if (count($result) > 0) {
            $db->executeSql('UPDATE `tb_notification` SET `text_notifica`="There were '.$i .' registrations today.",`status_notifica`="Not seen" WHERE title_notifica="Registrations" AND date_notifica="'.$currentdate.'"');                     
            $db->closeConnection();
        } else{
            $db->executeSql('INSERT INTO `tb_notification`( `title_notifica`, `text_notifica`, `date_notifica`, `status_notifica`) VALUES ("Registrations","There was a register today.","'.$currentdate.'","Not seen")');            
            $db->closeConnection();
        } 

    } elseif($action == 'find_time')
    {
        if ($place_consultation=="Dublin") {
            $place_consultation="Dublin"; 
        } elseif ($place_consultation=="Cork") {
            $place_consultation="Cork";
        }
        $array_h = array("8:00", "8:40", "9:20","10:00","10:40","11:20","12:40","13:20","14:00","14:40","15:20","16:00","16:40");

        $db->executeSql("SELECT time_booking FROM tb_booking WHERE date_booking='$date_consultation' AND status_booking='Booked' AND place_booking='$place_consultation'");
        $result = $db->fetchAll();
        $db->closeConnection();

        foreach($result as $row) {
            $hour = $row["time_booking"]; //select time booked
            $find_position = array_search("$hour", $array_h);  //search which position is the time
            array_splice($array_h, $find_position , 1); //when it finds the position excludes from array to void double booking at the same day
        }
        for ($h = 0; $h < count($array_h); $h++) { 
            $position=$array_h[$h];
            echo "<option value='".$position."'>".$position."</option>"; //generates options of free time available
          }


    } elseif($action == 'update_data') 
    {
        $db->executeSql("SELECT * FROM tb_clientdata WHERE cod_dataC='{$cod_data}'");
        $result = $db->fetch();
        $db->closeConnection();

        if($result){            
            $update = $db->executeSql("UPDATE `tb_clientdata` SET `name_dataC`='{$name_data}',`phone_dataC`='{$phone_data}',`id_dataC`='{$id_data}',`dt_birth_dataC`='{$date_birth_data}' WHERE cod_dataC='{$cod_data}'");            
            $db->closeConnection();
            if($update) {
                echo "Data updated with success!";
            } else {
                echo "Error updating data! Check information inserted and try again.";
            }            
        } else {
            try{
                $db->executeSql("INSERT INTO `tb_clientdata` (`cod_dataC`,`login_dataC`,`name_dataC`,`phone_dataC`,`id_dataC`,`dt_birth_dataC`) VALUES ('{$cod_data}','{$email_user}','{$name_data}','{$phone_data}','{$id_data}','{$date_birth_data}')");                
                $db->closeConnection();
                echo "Your registration was saved with success!";
            } catch (Exception $e) {
                echo "Error saving registration! Check information inserted and try again.";
            }
        }
    } elseif($action == 'insert_booking')
    {
        
        $db->executeSql("SELECT * FROM tb_clientdata WHERE cod_dataC = '{$cod_data}'");
        $result = $db->fetch();
        $db->closeConnection();
        if($result) {
            try {
                $db->executeSql("INSERT INTO `tb_booking` (`cod_dataC`,`dt_booking`,`place_booking`,`date_booking`,`time_booking`,`status_booking`) VALUES ('{$cod_data}','{$currentdate}','{$place_booking}','{$date_booking}','{$time_booking}','Booked')");
                $db->closeConnection();
                echo "<span style='font-size: 13px; font-weight: bold;'>Your appointment is booked! <br>The office`s address is at the bottom of the page.</span>";
            } catch (Exception $e) {
                echo "<span style='font-size: 13px; font-weight: bold;'>It was NOT possible to book your appointment! <br> Please check information inserted above.</span>";
            }            
        } else {
            echo "Insert information on required fields before booking!";
        }
        // inserts new notification
        $i=0;
        $db->executeSql("SELECT * FROM tb_booking WHERE dt_booking='$currentdate'");
        $result = $db->fetchAll();   
        $db->closeConnection();
        foreach($result as $row) {
            $i++;
        }
        if (count($result) > 0) {
            $db->executeSql('UPDATE `tb_notification` SET `text_notifica`="'.$i .' appointments were booked today.",`status_notifica`="Not seen"  WHERE title_notifica="Appointments" AND date_notifica="'.$currentdate.'"');                     
            $db->closeConnection();
        } else{
            $db->executeSql('INSERT INTO `tb_notification`( `title_notifica`, `text_notifica`, `date_notifica`, `status_notifica`) VALUES ("Appointments","There is a new appointment.","'.$currentdate.'","Not seen")');            
            $db->closeConnection();
        }       
    } elseif($action == 'cancel_booking')
    {
        try {
            $db->executeSql("UPDATE `tb_booking` SET `status_booking`='Cancelled' WHERE `id_booking`='{$id_booking}'");
            $db->closeConnection();
            echo "Your appointment is cancelled!";
        } catch (Exception $e) {
            echo "We could not cancel the appointment!";
        }
        
        // inserts new notification
        $i=0;
        $db->executeSql("SELECT * FROM tb_booking WHERE dt_booking='$currentdate'");
        $result = $db->fetchAll();   
        $db->closeConnection();
        foreach($result as $row) {
            $i++;
        }

        if (count($result) > 0) {
            $db->executeSql('UPDATE `tb_notification` SET `text_notifica`="There were '.$i .' cancelations today.",`status_notifica`="Not seen"  WHERE title_notifica="Cancelation" AND date_notifica="'.$currentdate.'"');                     
            $db->closeConnection();
        } else{
            $db->executeSql('INSERT INTO `tb_notification`( `title_notifica`, `text_notifica`, `date_notifica`, `status_notifica`) VALUES ("Cancelation","An appointment was cancelled.","'.$currentdate.'","Not seen")');            
            $db->closeConnection();
        }
    } elseif($action == 'contact')
    {
        echo '
        
        <script type="text/javascript">
            function hide(){
                var classes=document.getElementsByClassName("respMensa");
                var i;
                
                for(i=0; i < classes.length; i++){
                    classes[i].style.display="none";
                }
            }
        </script>
        ';

        try {
            $db->executeSql("INSERT INTO `tb_contact` (`name_contact`,`phone_contact`,`email_contact`,`subject_contact`,`message_contact`,`date_contact`) VALUES ('{$contact_name}','{$contact_phone}','{$contact_email}','{$contact_subject}','{$contact_message}','{$currentdate}')");
            $db->closeConnection();
            echo "<span class='respMensa'> Message sent! </span>";
		    echo "<script>setTimeout('hide()' , 9000);</script>";
        } catch (Exception $e) {            
		    echo "<span class='respMensa'> Ops! Message NOT sent! </span>"; 
		    echo "<script>setTimeout('hide()' , 9000);</script>"; 
        }

        $i=0;
        $db->executeSql("SELECT * FROM tb_booking WHERE dt_booking='$currentdate'");
        $result = $db->fetchAll();   
        $db->closeConnection();
        foreach($result as $row) {
            $i++;
        }

        if (count($result) > 0) {
            $db->executeSql('UPDATE `tb_notification` SET `text_notifica`="There are '.$i .' new messages.",`status_notifica`="Not seen"  WHERE title_notifica="Messages" AND date_notifica="'.$currentdate.'"');
            $db->closeConnection();
        } else{
            $db->executeSql('INSERT INTO `tb_notification`( `title_notifica`, `text_notifica`, `date_notifica`, `status_notifica`) VALUES ("Messages","There is a new message.","'.$currentdate.'","Not seen")');
            $db->closeConnection();
        }

    }
}