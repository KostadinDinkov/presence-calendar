
function validate(){
   
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    console.log(username);
    console.log(password);
    document.getElementById("error").style = "display:none";

    console.log(username);
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
     console.log(username);
return false;
 
}
