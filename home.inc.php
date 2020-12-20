
	<div id="container">
		<div id="rgba">
			
			<div id="contentone" class="color-white">
				<h1>J.Fagundes, Financial Consultants</h1>
				<h3>The solution for your financial issues!</h3>
				<p> We will help you out elaborating a plan to how control your finances and improve your results in order to give you a better quality of life. Furthermore, you will learn to get good habits and how to spend your money wisely. Make an appointment!
               </p>
            <?php
               	if(isset($_SESSION['logged'])==false){          
					echo '<button onclick="popLogin()" class="bk-azul-escuro principal">Make Appointment</button>';
				}
				else if (isset($_SESSION['logged'])==true AND $_SESSION['logged']>0){
					echo '<a href="'.$url->getBase().'booking" > <button class="bk-azul-escuro principal">Make Appointment </button></a>';
				}
			?>
				<a href="<?php echo $url->getbase();?>about"><button class="bk-azul-escuro principal">About</button></a>
            	<p id="gratis">First appointment is free of charge!</p>
			</div>
		</div>
	</div>