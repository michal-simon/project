$(document).ready(function(){
	$('#form_contact').submit(function(){
		var form = $(this).serialize();		
		var action = $(this).attr('action');
		$.ajax({
			//url:"php/contact.php",
			url: action,
			method:"POST",
			type:"POST",
			data:form, 
			success: function(return_contact) {
				// Print resp id=div1
				$( "#resp_contact" ).html( return_contact );
				$('#form_contact')[0].reset();
			},
			error: function() {
				alert("Error finding file.");
			}
		});
		return false;
	});

	$('#form_register').submit(function(){
		var form2 = $(this).serialize();		
		var action = $(this).attr('action');
		$.ajax({
			//url:"php/register.php",
			url: action,
			method:"POST",
			type:"POST",
			data:form2, 
			success: function(return_register) { 
				$( '#resp_register' ).html(return_register);
			},
			error: function() {
				alert("Error finding file.");
			}
		});
		return false;
	});
	
	$('#form_login').submit(function(){
		var form3 = $(this).serialize();
		var action = $(this).attr('action');
		$.ajax({
			url: action,
			method:"POST",
			type:"POST",
			data:form3, 
			success: function(return_login) { 
				$( '#resp_login' ).html(return_login);
			},
			error: function() {
				alert("Error finding file directory");
			}
		});
		return false;
	});
	
	$('#form_consultation').submit(function(){
		var form4 = $(this).serialize();
		var action = $(this).attr('action');
		$.ajax({
			//url:"php/find_time.php",
			url: action,
			method:"POST",
			type:"POST",
			data:form4, 
			success: function(return_consultation) { 
				$( "#resp_consultation" ).html( return_consultation );
			},
			error: function() {
				alert("Error finding file directory");
			}
		});
		return false;
	});
	
	$('#form_data').submit(function(){
		var form5 = $(this).serialize();		
		var action = $(this).attr('action');
		$.ajax({
			//url:"php/update_data.php",
			url: action,
			method:"POST",
			type:"POST",
			data:form5, 
			success: function(return_data) { 
				$( "#resp_booking" ).html( return_data );
			},
			error: function() {
				alert("Error finding file directory");
			}
		});
		return false;
	});
	
	$('#form_cancel').submit(function(){
		var form6 = $(this).serialize();
		var action = $(this).attr('action');
		$.ajax({
			//url:"php/cancel_booking.php",
			url: action,
			method:"POST",
			type:"POST",
			data:form6, 
			success: function(return_cancel) {
				alert(return_cancel)
			},
			error: function() {
				alert("Error finding file directory");
			}
		});
		return false;
	});
	
	$('#form_booking').submit(function(){
		var form7 = $(this).serialize();
		var action = $(this).attr('action');
		$.ajax({
			//url:"php/insert_booking.php",
			url: action,
			method:"POST",
			type:"POST",
			data:form7, 
			success: function(return_bookme) { 
				$( "#resp_booking" ).html( return_bookme );				
				$( "#form_booking" )[0].reset(); 
				setTimeout(function(){ $(location).attr('href', 'booking'); }, 10000);
			},
			error: function() {
				alert("Error finding file directory");
			}
		});
		return false;
	});
});

var logcad=document.getElementById("pop-logcad");
var poplogin=document.getElementById("div-login");
var popregister=document.getElementById("div-register");
var mobile=document.getElementById("div-header-2");

function popLogin(){
    logcad.style.display="block";
    poplogin.style.display="block";
}
function popRegister(){
    logcad.style.display="block";
    popregister.style.display="block";
}
function closeLog(){
    logcad.style.display="none";
    poplogin.style.display="none";
}
function closeCad(){
    logcad.style.display="none";
    popregister.style.display="none";
}
function menuM(){
    mobile.style.display="block";
}
function closemobile(){
    mobile.style.display="none";
}
function dateAtime(){
	var date_consultation=document.getElementById("date_consultation").value;
	var place_consultation=document.getElementById("place_consultation").value;
	var resp_consultation=document.getElementById("resp_consultation").value;
	
	if (date_consultation && place_consultation && resp_consultation !="") {
	  document.getElementById("dt_a").value=date_consultation;
	  document.getElementById("hr_a").value=resp_consultation;
	  document.getElementById("loc_a").value=place_consultation;
	}
  }