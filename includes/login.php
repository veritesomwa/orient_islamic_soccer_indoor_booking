<?php 



// Login

function login($conn, $email, $md5password){
    $query = "SELECT * FROM `users` WHERE `user_email`='".$email."' AND `user_password`='".$md5password."' ";
    if ($query_run = mysqli_query($conn, $query)){
        if ($num_rows = mysqli_num_rows($query_run) == 0){
            return false;
        }else{
            return $query_run;
        }
    }
}


function checkPasswordMatch($pass1, $pass2){
  if ($pass1 == $pass2){
    return true;
  }else{
    return false;
  }
}

function isValidPassword($pass){
  if (preg_match('/^(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $pass)) {
    return true;
  } else {
    return false;
  }
}

function checkExistingUser($conn, $email){
  $query = "SELECT * FROM `users` WHERE `user_email`='".$email."' ";
  $result = mysqli_query($conn, $query);
  if($num_rows = mysqli_num_rows($result) == 0){
    return false;
  }else{
    return true;
  }
}

function validate_email($email) {
  // Check if email address is valid
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Extract the domain from the email address
    $domain = substr(strrchr($email, "@"), 1);
    
    // Check if the domain has a valid MX record
    if (checkdnsrr($domain, "MX")) {
      return true;
    }
  }
  
  return false;
}



if (isset($_POST['btn_login'])){

  echo "<style>#login_section{display:block}#register_section{display:none}</style>";

    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $passwordHash = md5($password);

    if (!empty($email) & !empty($password)){
        $result = login($conn, $email, $passwordHash);

        if ($result == false){
            $msgLogin = "Invalid User Credentials";
        }else{
            $rows = mysqli_fetch_array($result);
            $_SESSION['user_id'] = $rows['user_id'];
            $_SESSION['user_firstname'] = $rows['user_firstname'];
            $_SESSION['user_lastname'] = $rows['user_lastname'];
            $_SESSION['user_email'] = $rows['user_email'];
            $_SESSION['user_password'] = $rows['user_password'];
            $_SESSION['user_number'] = $rows['user_number'];

            header("Location: ".$script_name);
;        }
    }else{
        $msgLogin = "All fields are required";
    }


}
// Register
if (isset($_POST['btn_register'])){

    ?>

    <script>
      $(document).ready(function(){
    
          $("#register_section").slideDown();
          $("#login_section").css("display", "none");

      });
    </script>

    <?php

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $regemail = $_POST['regemail'];
    $regpassword = $_POST['regpassword'];
    $regpassword2 = $_POST['regpassword2'];
    $number = $_POST['number'];

    
    $error = 0;
    
    if (!empty($firstname) && !empty($lastname) && !empty($regemail) && !empty($regpassword) && !empty($regpassword2) && !empty($number)){
        
    }else{
      $error += 1;
      $bigError = "<span class='alert alert-danger'>error: all fields are required.</span>";
    }

    if (checkExistingUser($conn, $regemail)){
      $regemailError = "This email already exists...";
      $error += 1;
    }else{
      
    }

    if (validate_email($regemail)){

    }else{
      $regemailError = "Invalid Email format\n";
      $error += 1;
    
    }

    if (isValidPassword($regpassword)){
      
    }else{
      $regpassError =  "Password must be more than 8 Characts and contain a-z, A-Z, 0-9";
      $error += 1;

    }

    if (checkPasswordMatch($regpassword, $regpassword2)){

    }else{
      $regpassError2 = "<br>Passwords do not match!";
      $error += 1;
    }
    $hash  = md5($regpassword);

    if ($error == 0){
      $sql = "INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`, `user_email`, `user_password`, `user_number`) VALUES (NULL, '".$firstname."', '".$lastname."', '".$regemail."', '".$hash."', '".$number."')";

      
      
        if (mysqli_query($conn, $sql)) {
          $result = login($conn, $regemail, $hash);

          if ($result == false){
              echo "Invalid User Credentials";
          }else{
              $rows = mysqli_fetch_array($result);
              $_SESSION['user_id'] = $rows['user_id'];
              $_SESSION['user_firstname'] = $rows['user_firstname'];
              $_SESSION['user_lastname'] = $rows['user_lastname'];
              $_SESSION['user_email'] = $rows['user_email'];
              $_SESSION['user_password'] = $rows['user_password'];
              $_SESSION['user_number'] = $rows['user_number'];

              header("Location: ".$script_name);
  ;        }
        }
      

    }

    

}




?>


<br>
           
<section class="vh-100" id="login_section">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="includes/src/img/draw2.png"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form action="<?php echo $script_name; ?>" method="POST">
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            <p class="lead fw-normal mb-0 me-3">Sign in with</p>
            <button type="button" class="btn btn-primary btn-floating mx-1">
              <i class="fab fa-facebook-f"></i>
            </button>

            <button type="button" class="btn btn-primary btn-floating mx-1">
              <i class="fab fa-twitter"></i>
            </button>

            <button type="button" class="btn btn-primary btn-floating mx-1">
              <i class="fab fa-linkedin-in"></i>
            </button>
          </div>

          <div class="divider d-flex align-items-center my-4">
            <p class="text-center fw-bold mx-3 mb-0">Or</p>
          </div>

          <!-- Email input -->
          <div class="form-outline mb-4">
            <input type="email" id="email" name="email" class="form-control form-control-lg"
              placeholder="Enter a valid email address" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>"/>
            <label class="form-label" for="eamil">Email address</label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
            <input type="password" id="password" name="password" class="form-control form-control-lg"
              placeholder="Enter password" />
            <label class="form-label" for="password">Password</label>
            <div style="float:right;margin-top:10px;" id="showpassword" class="btn btn-danger fa-solid fa-eye show"></div>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <!-- Checkbox -->
            <div class="form-check mb-0">
              <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
              <label class="form-check-label" for="form2Example3">
                Remember me
              </label>
            </div>
            <a href="#!" class="text-body">Forgot password?</a>
          </div>
          <br>
          <div style="font: 17px tahoma;color:#ee6666;"><?php if(isset($msgLogin)) echo $msgLogin;?></div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" name="btn_login" class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="#Register"
                class="link-danger" id="btnRegister">Register</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>
  <div
    class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
    <!-- Copyright -->
    <div class="text-white mb-3 mb-md-0">
    Copyright © 2023. otangobaby. All rights reserved.
    </div>
    <!-- Copyright -->

    <!-- Right -->
    <div>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-google"></i>
      </a>
      <a href="#!" class="text-white">
        <i class="fab fa-linkedin-in"></i>
      </a>
    </div>
    <!-- Right -->
  </div>
</section>


<style>
  .visible-scrollbar{
    overflow: scroll;
    height: 350px;
  }
</style>


<section class="vh-100" id="register_section" style="display:none">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="includes/src/img/draw2.png"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form action="<?php echo $script_name; ?>" method="POST">
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            <p class="lead fw-normal mb-0 me-3">Sign up with</p>
            <button type="button" class="btn btn-primary btn-floating mx-1">
              <i class="fab fa-facebook-f"></i>
            </button>

            <button type="button" class="btn btn-primary btn-floating mx-1">
              <i class="fab fa-twitter"></i>
            </button>

            <button type="button" class="btn btn-primary btn-floating mx-1">
              <i class="fab fa-linkedin-in"></i>
            </button>
          </div>

          <div class="divider d-flex align-items-center my-4">
            <p class="text-center fw-bold mx-3 mb-0">Or</p>
          </div>

          <div class="visible-scrollbar">

          <!-- Firstname input -->
          <div class="form-outline mb-4">
            <input type="text" id="firstname" name="firstname" class="form-control form-control-lg"
              placeholder="Enter First Name" value="<?php if(isset($_POST['firstname']))echo $_POST['firstname']?>"/>
            <label class="form-label" for="firstname"></label>
          </div>
          <!-- Lastname input -->
          <div class="form-outline mb-4">
            <input type="text" id="lastname" name="lastname" class="form-control form-control-lg"
              placeholder="Enter Last Name" value="<?php if(isset($_POST['lastname']))echo $_POST['lastname']?>"/>
            <label class="form-label" for="lastname"></label>
          </div>
          <!-- Email input -->
          <div class="form-outline mb-4">
            <input type="text" id="regemail" name="regemail" class="form-control form-control-lg"
              placeholder="Enter a valid email address" value="<?php if(isset($_POST['regemail']))echo $_POST['regemail']?>"/>
            <label class="form-label text-danger" for="regemail"><?php if (isset($regemailError)) echo $regemailError; ?></label>
            
          </div>
          <!-- Password input -->
          <div class="form-outline mb-3">
            <input type="password" id="regpassword" name="regpassword" class="form-control form-control-lg"
              placeholder="Enter password" value="<?php if(isset($_POST['regpassword']))echo $_POST['regpassword']?>"/>
            <label class="form-label text-danger" for="regpassword"><?php if (isset($regpassError)) echo $regpassError; ?></label>
            <label class="form-label text-danger" for="regpassword"><?php if (isset($regpassError2)) echo $regpassError2; ?></label>
            <div style="float:right;margin-top:10px;margin-bottom:10px;" id="regshowpassword1" class="btn btn-danger fa-solid fa-eye show"></div>
          </div>
          <!-- Password input -->
          <div class="form-outline mb-3">
            <input type="password" id="regpassword2" name="regpassword2" class="form-control form-control-lg"
              placeholder="Confirm Your Password" value="<?php if(isset($_POST['regpassword2']))echo $_POST['regpassword2']?>"/>
              <label class="form-label text-danger" for="regpassword2"><?php if (isset($regpassError2)) echo $regpassError2; ?></label>
              <div style="float:right;margin-top:10px;margin-bottom:10px;" id="regshowpassword2" class="btn btn-danger fa-solid fa-eye show"></div>
          </div>
          <div class="form-outline mb-4">
            <input type="tel" id="number" name="number" class="form-control form-control-lg"
              placeholder="Phone Number" value="<?php if(isset($_POST['number']))echo $_POST['number']?>"  data-mdb-input-mask="+48 999-999-999" />
            <label class="form-label" for="number">Phone Number</label>
          </div>


          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" name="btn_register" class="btn btn-danger btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">Register</button>
            <p class="small fw-bold mt-2 pt-1 mb-0" id="btnLogin">Already have an account? <a href="#Login"
                class="link-danger">Login Instead</a></p>
            
          </div>
          <br>
          <div><?php if (isset($bigError)) echo $bigError; ?></div>

 </form>
      </div>
    </div>
  </div>
  <!-- <div
    class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
     Copyright -->
    <div class="text-white mb-3 mb-md-0">
    Copyright © 2023. otangobaby. All rights reserved.
    </div>
    <!-- Copyright -->

    <!-- Right -->
    <div>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-google"></i>
      </a>
      <a href="#!" class="text-white">
        <i class="fab fa-linkedin-in"></i>
      </a>
    </div>
    <!-- Right -->
  </div> 
</section>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/03b5212320.js" crossorigin="anonymous"></script>
<script>
    function showpassword(opener, password){
      $(opener).click(function(e){
        var target = e.currentTarget
        if($(target).hasClass('show')){
          $(target).removeClass('show');
          $(target).removeClass('fa-eye').addClass('fa-eye-slash');
          $(password).attr("type", "text");
        }else{
          $(target).removeClass('fa-eye-slash').addClass('fa-eye');
          $(target).addClass('show');
          $(password).attr("type", "password");
        }
      })
    }

    showpassword("#showpassword", "#password");
    showpassword("#regshowpassword1", "#regpassword");
    showpassword("#regshowpassword2", "#regpassword2");
    
</script>
<script src="includes/src/js/script.js"></script>

</body>
</html>