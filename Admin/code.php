<?php

require_once 'includes/database.php';
// if(!1){


// $sql = "select * from admin";
// $result=mysqli_query($conn,$sql);
// $rowCount=mysqli_num_rows($result); /// checking that something is returning from data base

//     if($rowCount>0)
//     {
//         while($row=mysqli_fetch_assoc($result))
//         {
//             echo $row['username']."<br>";

//         }
//     }
//     else{
//         echo "No results Found";
//     }

// }


if(isset($_POST['submit']))
{
        //Add Data Base connecttion

         $username=$_POST['username'];
         $password=$_POST['password'];
         $cpassword=$_POST['confirmpassword'];
         $email=$_POST['email'];
         $speciality=$_POST['speciality'];
        // $date=$_POST['date'];

        
        if(empty($username) || empty($email) || empty($password) || empty($cpassword) || empty($speciality))
        {
            header("Location:register.php?emptyfeilds&username=.$username");
            exit();
        }
        else if(!preg_match("/^[a-zA-Z0-9]*/",$username))
        {
            header("Location:register.php?invalidusername&username=.$username");
            exit();
            
        }
        else if($cpassword!=$password)
        {
            header("Location:register.php?passworddoesnotmatches&username=.$username");
            exit();
        }
        if(strlen($password)>8)
        {
        
            $sql="select username from admin where username=?";
            $stmt=mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt,$sql))
            {
                header("Location:register.php?queryfailed&username=.$username");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt,"s",$username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $rowCount=mysqli_stmt_num_rows($stmt);
                if($rowCount>0){
                    header("Location:register.php?usernametaken&username=.$username");
                    exit();
                }
                $sql="insert into attendance(username,password,email,speciality_id) values(?,?,?,?)";
                $stmt=mysqli_stmt_init($conn);

                if(!mysqli_stmt_prepare($stmt,$sql))
                {
                    header("Location:register.php?queryfailesd2&username=.$username");
                    exit();
                }
                else{

                  
                           
                            $hashedPass=password_hash($password,PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt,"ssss",$username,$hashedPass,$email,$speciality);
                            mysqli_stmt_execute($stmt);
                            
                            header("Location:register.php?SUCCESS!=registered");
                            exit();
                           
                }

            

            }


        }
        else{
            header("Location:register.php?LengthIsLessThan8");
                            exit();
        }
        
}


?>




























<!-- 
if(empty($username)  || empty($email) || empty($speciality) || empty($password) || empty($cpassword))
        {
            header("Location:register.php?emptyfeilds&username=".$username);
            exit(); 
        }
        else if(!preg_match("/^[a-zA-Z0-9]*/",$username))
        {
            header("Location:register.php?invalidusername&username=".$username);
            exit();
        } else if($password!=$cpassword)
        {
            header("Location:register.php?passwordnotmatched&username=".$username);
            exit();
        }
        else{
            $sql="select username from admin where username= ?";
            $stmt=mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql))
            {
            header("Location:register.php?queryfailed1&username=".$username);
            exit();
            } else{
                mysqli_stmt_bind_param($stmt,"s",$username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $rowCount = mysqli_stmt_num_rows($stmt);
                if($rowCount>0)
                {
                 header("Location:register.php?usernametaken&username=".$username);
                exit();
                }
                else{
                    $sql="insert into attendance(username,password,email,speciality_id) values (?,?,?,?) ";
                    $stmt=mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt,$sql))
                    {
                    header("Location:register.php?queryfailed2&username=".$username);
                    exit();
                    }
                        else{

                            $hashedPass=password_hash($password,PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt,"ssss",$username,$hashedPass,$email,$speciality);
                            mysqli_stmt_execute($stmt);
                            
                            header("Location:register.php?SUCCESS!=registered");
                            exit();
                           
                            
                            
                        }       
                    
                }

            }
            
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);    -->
