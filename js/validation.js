function checkPasswords(){
    var oldPassword = document.getElementById("oldPassword").value; 
    var newPassword = document.getElementById("newPassword").value; 
    var repeatPassword = document.getElementById("repeatPassword").value;  

    document.getElementById("errors").style = "display:none";


   var request = new XMLHttpRequest();
    request.onload = function (){
    if(request.status == 200){
        
            if(request.response == ""){
                location.href = 'login.php';
            }
            document.getElementById("errors").innerText = request.response;
            document.getElementById("errors").style = "display:block";  
            return false; 
                      
    }
    
 };
 
 request.open("POST","passwordValidation.php",true);
 request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
 request.send("oldPassword="+oldPassword+"&newPassword="+newPassword+"&repeatPassword="+repeatPassword);


 return false;
}

function showSubevents(subeventNumber){

   var subevents = document.getElementById("subevents" + subeventNumber);

    var button = document.getElementById("showSubevents" + subeventNumber);
    
   if (subevents.style.display === "none") {
        subevents.style.display = "block";
    } else {
        subevents.style.display = "none";
   }
}





function validate(){

    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    document.getElementById("error").style = "display:none";

        var request = new XMLHttpRequest();
        request.onload = function (){
        if(request.status == 200){
            console.log(username);
            
                if(request.response == ""){
            
                    console.log(username);
                    if (username == "admin"){
                        location.href = 'upload.php';
                    } else{
                        location.href = 'profile.php';
                    }
            }
                document.getElementById("error").innerText = request.response;
                document.getElementById("error").style = "display:block";  
                return false; 
                          
        }
        
     };
    
     request.open("POST","validation.php",true);
     request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
     request.send("username="+username+"&password="+password);
     
return false;
 
}
