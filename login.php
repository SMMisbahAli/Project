<?php
   include('includes/header.php');
   include('includes/navbar.php');

?>

<form action="">
<div class="py-5">
        <div class="container">
            <div class="row justify-align-content-center">
                <div class="col-mid-5">
                    <div class="card">
                        <div class="card-header">
                            <h4>Log In </h4>
                            
                        </div>
                        <div class="card-body" >
                            <div class="form-group mb-3">
                                <label>Email Address</label>
                                <input type="email" placeholder="Enter Email Adress" class="form-control">
                             </div>
                             <div class="form-group mb-3">
                                <label>Password</label>
                                <input type="password" placeholder="Enter Password" class="form-control" >
                             </div>
                             <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary" >LOG IN</button>
                               
                                <p class="message">Not registered? <a href="register.php">Create an account</a></p>
                             </div>
 
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

    <?php
   include('includes/footer.php');
?>