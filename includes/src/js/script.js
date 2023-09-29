// let btn_register = document.getElementById("btnRegister");
// let register_section = document.getElementById("register_section");
// let login_section = document.getElementById("login_section");

// btn_register.addEventListener('click', (e) => {
//     e.preventDefault()
//     login_section.style.display = "none";
//     register_section.style.display = "block";

// });

$(document).ready(function(){
    
    
    $("#btnRegister").click(function(){
      $("#register_section").slideDown();
      $("#login_section").css("display", "none");
    });
    $("#btnLogin").click(function(){
      $("#login_section").slideDown();
      $("#register_section").hide();
    });

    


  });