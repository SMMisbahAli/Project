<?php
   include('includes/header.php');
   include('includes/navbar.php');

?>

<form action="go.php">
<div class="py-5">
        <div class="container">
            <div class="g-3 align-items-center">
                <div class="col-mid-15">
                    <div class="card">
                        <div class="card-header">
                            <h4>Register</h4>
                        </div>
                        <div class="card-body">
                        <div class="form-group mb-3">
                                <label>Name</label>
                                <input type="name" placeholder="Full Name" class="form-control">
                             </div>
                             <div class="form-group mb-3">
                             <label>Age</label>
                                <input type="number" placeholder="Enter Your Age" class="form-control" maxlength="4">
                             </div>
                             <div class="form-group mb-3">
                                <label>Email Adress</label>
                                <input type="email" placeholder="Enter Email Adress" class="form-control">
                             </div>
                             <div class="form-group mb-3">
                                <label>Password</label>
                                <input type="password" placeholder="Enter Password" class="form-control">
                             </div>
                             <div class="form-group mb-3">
                                <input type="password" placeholder="Enter Password Again" class="form-control">
                             </div>
                             <div class="form-group mb-3">
                             <select class="form-select" aria-label="User">
                            <option selected>User Profile</option>
                            <option value="1">User</option>
                            <option value="2">Admin</option>
                            
            
                            </select>
                            <p class="float-end">The User Profile has been requested  </p>
                            </div>
                             <button type="submit" class="btn btn-primary" >SUBMIT</button>
                             <a href="index.php" class="btn btn-secondary" role="button">Home</a>
                                
                             
                             
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
