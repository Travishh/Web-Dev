//Travis Hun_19056383
//File admin.js that use xhr object to search for booking by getting booking reference as an input once the submit button is clicked
var xhr = createRequest(); 
function searchBooking()  
{     
	if(xhr) {     
			var obj = document.getElementById('searchResult');
			var bookRef =  document.getElementById('bsearch').value;         
			var requestbody="bookRef="+encodeURIComponent(bookRef);

            xhr.open("POST", "admin.php", true);     
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
