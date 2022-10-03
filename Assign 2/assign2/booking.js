//Travis Hun_19056383
//File booking.js that use xhr object to get all the inputs once button is clicked
var xhr = createRequest(); 
function booking()  
	{     
		if(xhr) {     
			var obj = document.getElementById('targetDiv');     
			var name = document.getElementById('cname').value;     
			var phone = document.getElementById('phone').value;     
			var unit = document.getElementById('unumber').value;     
			var streetNo = document.getElementById('snumber').value;     
			var streetName = document.getElementById('stname').value;     
			var suburb = document.getElementById('sbname').value;     
			var destSuburb = document.getElementById('dsbname').value;     
			var pickupDate = document.getElementById('date').value;     
			var pickupTime = document.getElementById('time').value;     
			var requestbody ="cus_name="+encodeURIComponent(name)+" &phone_No="+encodeURIComponent(phone)+" &unit_No="+encodeURIComponent(unit)
            +" &street_No="+encodeURIComponent(streetNo)+" &street_Name="+encodeURIComponent(streetName)+" &suburb="+encodeURIComponent(suburb)
            +" &dest_Suburb="+encodeURIComponent(destSuburb)+" &pickup_Date="+encodeURIComponent(pickupDate)+" &pickup_Time="+encodeURIComponent(pickupTime);     
			
            xhr.open("POST", "booking.php", true);     
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");     
			xhr.onreadystatechange = function() 
			{             
				if (xhr.readyState == 4 && xhr.status == 200) 
				{ 
					obj.innerHTML = xhr.responseText;
				} 
			}    
			xhr.send(requestbody); 
		}
	}