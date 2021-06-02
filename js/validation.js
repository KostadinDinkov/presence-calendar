function checkPasswords(){
    var oldPassword = document.getElementById("oldPassword").value; 
    var newPassword = document.getElementById("newPassword").value; 
    var repeatPassword = document.getElementById("repeatPassword").value;  

    document.getElementById("errors").style = "display:none";

    console.log(oldPassword);
    console.log(newPassword);
    console.log(repeatPassword);

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

function validate(){
   
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    document.getElementById("error").style = "display:none";

        var request = new XMLHttpRequest();
        request.onload = function (){
        if(request.status == 200){
            console.log(username);
            
                if(request.response == ""){
                    console.log("a" + request.response+ "a");
                    location.href = 'profile.php';
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