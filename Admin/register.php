<?php
   include('includes/header.php');
   include('includes/navbar.php');
   include('includes/topbar.php');
    
   ?>

<form action="code.php" method="post">
<div class="py-5">
        <div class="container">
            <div class="g-3 align-items-center">
                <div class="col-mid-15">
                    <div class="card" style="width: 50rem;">
                        <div class="card-header">
                            <h4>Register</h4>
                        </div>
                        <div class="card-body">
                        <div class="form-group mb-3">
                                <label>Name</label>
                                <input style="padding: 10px;" type="name" name="username" placeholder="Full Name" class="form-control" >
                             </div>
                             <div class="form-group mb-3">
                            
                             <div class="form-group mb-3">
                                <label>Email Adress</label>
                                <input type="email" name="email" placeholder="Enter Email Adress" class="form-control" >
                             </div>
                             <div class="form-group mb-3">
                                <label>Date</label>
                                <input type="date" placeholder="Select Date" class="form-control" name="date">
                             </div>
                             <div class="form-group mb-3">
                                <label>Password</label>
                                <input type="password" placeholder="Enter Password" class="form-control" name="password">
                             </div>
                             <div class="form-group mb-3">
                                <input type="password" placeholder="Enter Password Again" class="form-control" name="confirmpassword">
                             </div>
                        <div class="form-group">
                             <label for="speciality">Select Experties</label>
                             <select class="browser-default custom-select" id="speciality"  name="speciality">
                            <option>Select Experties</option>
                            <option value="1" selected>Data Base Admin</option>
                            <option value="2">Webdeveloper</option>
                            <option value="3">User</option>
                          </select>
                          </div>

                            
                             <button style="margin:10px;" type="submit" class="btn btn-primary" name="submit">SUBMIT</button>
                             <a href="index.php" class="btn btn-secondary" role="button">Home</a>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

    <?php
    
    $sql="select * from admin ";
    $stmt=mysqli_stmt_init($conn);
    


    
    ?>

 
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>