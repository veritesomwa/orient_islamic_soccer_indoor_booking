
<style>
    #navBar{
        position: fixed;
        top:0;
        width: 100%;
    }

</style>
<?php 
$getPosistion = strpos($_SESSION['user_email'], "@");
$username = substr($_SESSION['user_email'], 0, $getPosistion);

?>
    
    <script>

  $(function(){
    $(".toggle").on("click", function(){
      if($(".item").hasClass("active")){
        $(".item").removeClass("active");
      }else{
        $(".item").addClass("active");
      }
    });
  });
    </script>

    
    <section class="vh-100">
        <div class="h-custom">
        <!-- <a href="includes/logout.php"><button class="btn btn-primary">Sign Out</button></a> -->

        <nav id="navBar">

            <ul class="menu">
                <li class="logo"><a href="#"><span style="color:#ddd">OrientIndoor</span><span style="color:#ee6666">Bookings<span></a></li>
                <li class="item"><a href="#bookings">Bookings</a></li>
                <li class="item"><a href="#members">Members</a></li>
                <!-- <li class="item"><a href="#">Services</a></li> -->
                <div class="dropdown button item">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown"><?php echo $username;?></a>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">Profile</a>
                        <a href="includes/logout.php" class="dropdown-item">Log Out</a>
                    </div>
                </div>
                <!-- <li class="item button secondary"><a href="#" class="fab fa-add" style="font-size:20px"></a></li> -->
                <li class="toggle"><span class="bars"></span></li>
            </ul>

        </nav>
        <div style="height:100px">

        </div>

        <div id="bookings" class="container">
            <br>
            <h1>Bookings<form method="POST"><button class="btn btn-info" name="btnBook" type="submit"><span style="font:bold 30px tahoma"class="fab fa-add"></span></button> <button class="btn btn-danger" name="btnRemoveBook" type="submit"><span style="font:bold 30px tahoma"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z"/></svg></span></button></form></h1>

            <?php 

            function checkExistingBooking($conn, $id){
                $query = "SELECT * FROM `bookings` WHERE `user_id`='".$id."' ";
                $result = mysqli_query($conn, $query);
                if($num_rows = mysqli_num_rows($result) == 0){
                return false;
                }else{
                return true;
                }
            }

                if (isset($_POST['btnBook'])){
                    if (checkExistingBooking($conn, $_SESSION['user_id'])){
                        ?><script>alert("You are already booked.")</script><?php
                    }else{
                        $sql_book = "INSERT INTO `bookings`(`bookings_id`, `user_id`, `booked`) VALUES (NULL ,'".$_SESSION['user_id']."','true')";
                        $sql_book_run = mysqli_query($conn, $sql_book);
                    }
                }

                if (isset($_POST['btnRemoveBook'])){
                    if (checkExistingBooking($conn, $_SESSION['user_id'])){
                        $sql_book = "DELETE FROM `bookings` WHERE user_id='".$_SESSION['user_id']."'";
                        $sql_book_run = mysqli_query($conn, $sql_book);
                    }else{
                        ?><script>alert("You are not booked.")</script><?php
                    }
                }
            
            ?>

            <div class="table-responsive">
            <table class="table table-light table-striped table-bordered">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Firstname</th>
                    <th scope="col">Lastname</th>
                    <th scope="col">Email</th>
                    <th scope="col">Number</th>
                    </tr>
                </thead>

                <tbody>

                <?php
            
                    $query = "SELECT * FROM users, bookings WHERE users.user_id = bookings.user_id AND bookings.booked='true'";
                    $query_run = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($query_run)){
                        
                        ?>
                            <tr class="<?php if ($row['user_id'] == $_SESSION['user_id']) {echo "table-success";}?>">
                                <th scope="row"><?php echo $row['user_id']?></th>
                                <td><?php echo $row['user_firstname']?></td>
                                <td class="activate"><?php echo $row['user_lastname']?></td>
                                <td class="activate"><?php echo $row['user_email']?></td>
                                <td><?php echo $row['user_number']?></td>
                            </tr>
                        <?php
                    }
                
                ?>
                    
                </tbody>

            <table>
            </div>

            
        </div>
        
        
        <div id="members" class="container">
            <br>
            <h1>Members</h1>


            <div class="table-responsive">
            <table class="table table-light table-striped table-bordered">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Firstname</th>
                    <th scope="col">Lastname</th>
                    <th scope="col">Email</th>
                    <th scope="col">Number</th>
                    </tr>
                </thead>
                <tbody>

                <?php
            
                    $query = "SELECT * FROM users";
                    $query_run = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_array($query_run)){
                        
                        ?>
                            <tr class="<?php if ($row['user_id'] == $_SESSION['user_id']) {echo "table-success";}?>">
                                <th scope="row"><?php echo $row['user_id']?></th>
                                <td><?php echo $row['user_firstname']?></td>
                                <td class="activate"><?php echo $row['user_lastname']?></td>
                                <td class="activate"><?php echo $row['user_email']?></td>
                                <td><?php echo $row['user_number']?></td>
                            </tr>
                        <?php
                    }
                
                ?>
                    
                </tbody>
            </table>
            </div>
            
        </div>

        </div>

        

        <div
            class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-dark">
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


<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>