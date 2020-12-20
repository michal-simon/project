<?php
include("config/config.php");
//gets active session of user logged in
$user = $ses->getNode('logged');

#echo 'ID USUARIO: '. $user['id_login'];

#echo '<pre>';
#echo var_dump($user);
#echo '</pre>';

#exit();
?>
<!DOCTYPE html>
<html>
<head>
	<title>J. Fagundes | Financial Consultants</title>
	<meta charset="UTF-8">
   <link rel="icon" href="<?php echo $url->getBase();?>assets/imagens/icon.jpg">
   
   <script defer src="<?php echo $url->getBase();?>assets/font-awesome/fontawesome-all.js"></script> 
   <script defer src="<?php echo $url->getBase();?>assets/js/jquery.min.js"></script> 
   <script defer src="<?php echo $url->getBase();?>assets/js/index.js"></script> 

   <link rel="stylesheet" href="<?php echo $url->getBase();?>assets/css/index.css?<?=time();?>">
</head>
<body>

	<div id="pop-logcad">
	    <div class="loginregister" id="div-login">
	    	<span class="close" onclick="closeLog()"><i class="fas fa-times"></i></span><br><br>
	    	<form method="post" id="form_login" action="<?php echo $url->getBase();?>ajax/?action=login">
	      	<label style="margin-bottom: 6px; margin-top: 13px;">  <i class="fas fa-at"></i> E-mail:</label><br>
	      		<input type="text" name="email_log" required=""><br>
	      	<label style="margin-bottom: 6px; margin-top: 13px;">  <i class="fas fa-lock"></i> Password:</label><br>
	      		<input type="password" name="password_log" required=""><br>
	      	<button name="btn-login-access" id="btn-login-access" class="bk-azul-escuro color-white">Access</button><br>
	      	<p id="resp_login" ></p>
	      </form>
	    </div>  

	    <div class="loginregister" id="div-register">
	    	<span class="close" onclick="closeCad()"><i class="fas fa-times"></i></span><br><br>
	    	<form method="post" action="<?php echo $url->getBase();?>ajax/?action=register" id="form_register">
	    	<label style="margin-bottom: 6px; margin-top: 13px;">  <i class="fas fa-user"></i> Full name:</label><br>
	      		<input type="text" name="name_cad" required><br>
	      	<label style="margin-bottom: 6px; margin-top: 13px;">  <i class="fas fa-at"></i> E-mail:</label><br>
	      		<input type="text" name="email_cad" required><br>
	      	<label style="margin-bottom: 6px; margin-top: 13px;">  <i class="fas fa-lock"></i> Inform password:</label><br>
	      		<input type="password" name="password_cad" required><br>
	      	<label style="margin-bottom: 6px; margin-top: 13px;">  <i class="fas fa-lock"></i> Inform password again:</label><br>
	      		<input type="password" name="clone_password_cad" required><br>

	      	<button name="btn-register" id="btn-register" class="bk-azul-escuro color-white">Create account</button><br>
	      	<p id="resp_register" > </p>
	      	</form>
	    </div>	
	</div>

	<nav class="color-white bk-azul"> 
		<div id="div-header-1">
			<a href="<?php echo $url->getBase();?>" class="link-nav">
				<p id="logo">J.Fagundes</p>
			</a>
		</div>
		
		<div id="div-header-2">
			<a href="#" class="color-white" onclick="closemobile()"><p id="closeM">close</p></a>
			<?php if(!isLoggedin()): ?>
				<a href="#" class="link-nav color-white" onclick="popLogin()"> <span id="login-nav"> <i class="fas fa-sign-in-alt la icons2"></i>Login</span></a>
				<span class="separator"> | </span>
				<a href="#" class="link-nav color-white" onclick="popRegister()"> <span id="register-nav"><i class="fas fa-users icons2"></i>Register</span></a>			
			<?php else: ?>
				<a href="<?php echo $url->getBase(); ?>booking" class="link-nav color-white"> <span id="booking-nav" title=""><i class="far fa-calendar-alt icons2"></i>My Appointments</span></a> 
				<span class="separator"> | </span>
				<?php if($user['access_login'] == 2): ?>
				<a href="<?php echo $url->getBase(); ?>booking-list" class="link-nav color-white"> <span id="booking-nav" title=""><i class="far fa-calendar-alt icons2"></i>List Appointments</span></a> 
				<span class="separator"> | </span>
				<?php endif; ?>
				<a href="<?php echo $url->getBase(); ?>logout" class="link-nav color-white"> <i class="fas fa-sign-out-alt icons2"></i>Logout</span></a> 
			<?php endif; ?>
			<span class="separator"> | </span>
			<a href="<?php echo $url->getBase(); ?>about" class="link-nav color-white"> <span id="about"> About </a> 
		</div>

		<div id="div-header-3">
			<a href="#" class="color-white" onclick="menuM()"><i class="fas fa-bars"></i></a>
		</div>
	</nav>

	<?php
		if(isset($pagina)){
			if(empty($pagina)){
				include("paginas/home.inc.php");
			} else{
				if(file_exists("paginas/{$pagina}.inc.php")){
					include("paginas/{$pagina}.inc.php");
				}else{
					include("paginas/404.inc.php");
				}
			}
		} else {
			include("paginas/home.inc.php");
		}
		?>

	<footer class="bk-azul">
	   <div id="div-contact">
	      <form method="POST" action="<?php echo $url->getBase();?>ajax/?action=contact" id="form_contact">

	      	<h3 class="color-white-box"><i class="far fa-envelope"></i> Contact us!</h3>

	         <label class="label-cont color-white-box" for="contact-name">Name</label>
	         <input type="text" name="contact_name" id="contact_name" placeholder="Full name" maxlength="120" required> 


	         <label class="label-cont color-white-box" for="contact-phone">Phone</label>
	         <input type="text" name="contact_phone" id="contact_phone" maxlength="11" required><br>


	         <label class="label-cont color-white-box" for="contact-email">E-mail</label>
	         <input type="text" name="contact_email" id="contact_email" maxlength="60"> 


	         <label class="label-cont color-white-box" id="Messent" for="contact-subject">Subject</label>
	         <input type="text" name="contact_subject" id="contact_subject" maxlength="30" required><br>
 

	         <textarea placeholder="Insert your message" name="contact_message" maxlength="600" required></textarea><br>
	         <p>
	         	<span style="margin:10px;padding: 0;" class="color-white" id="resp_contact"></span>
	         	<button type="submit" id="btn-send" name="btn-send" style="color: #192B35; background: #f7f7f7;">Send</button>
	         </p>
	      </form>
	   </div>
	   <div id="div-address">
	      <h4 class="margin0 color-white-box"><i class="fas fa-map-marker-alt"></i> Dublin </h4>
	      <p class="margin0 color-white-box">152 Parnell Street | City Center <br> Dublin <br><i class="fas fa-phone"></i> 083 45645645</p><br>
	      <h4 class="margin0 color-white-box"><i class="fas fa-map-marker-alt"></i> Cork</h4>
	      <p class="margin0 color-white-box">1562 Occone`l Street | City Center <br> Cork <br><i class="fas fa-phone"></i> 085 1231231</p>
	   </div>
	</footer>
	<p style="text-align: center; font-size: 12px; font-style: italic; padding: 0 0 12px 0; margin: 0;" class="bk-azul color-white">Developed by Jonatas Fagundes | 2020</p> 
</body>
</html>