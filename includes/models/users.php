<?
include_once("global.php");
if(isset($_GET['logout'])){
    $_SESSION['email'] = "";
    $_SESSION['password'] = "";
    header("Location: ./?");
}

if(isset($_POST['login'])){
    ;
    $email = mb_htmlentities(($_POST['email']));
    $password = mb_htmlentities( md5(md5(sha1( $_POST['password'])).'Anomoz')); 
    $query= "select * from ".$g_projectSlug."_users where email='$email' and password='$password'"; 
    $result = $con->query($query);
    
    if($result->num_rows>0){
    while($row = $result->fetch_assoc()) 
    { 
        $_SESSION['email'] = $row['email'];
        $_SESSION['password'] = $row['password'];
        $logged=1;
        header("Location: ./home.php");
    }
    }
    else{
        ?>
        <script>window.location = "./login.php?err=failed";</script>
        <?
    }
}


if(isset($_POST['create_user'])){
    $first_name = mb_htmlentities(($_POST['first_name']));
    $first_name = preg_replace('/[^a-zA-ZÀ-ÿ \-]/', '', $first_name);
    
    $last_name = mb_htmlentities(($_POST['last_name']));
    $last_name = preg_replace('/[^a-zA-ZÀ-ÿ \-]/', '', $last_name);

    $name = $first_name." ".$last_name;

    $email = mb_htmlentities(($_POST['email']));
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    
    $password = mb_htmlentities( md5(md5(sha1( $_POST['password'])).'Anomoz')); 
    $id=generateRandomString();
    $timeAdded=time();
    $query = "insert into ".$g_projectSlug."_users set id='$id',first_name='$first_name',last_name='$last_name', name='$name', email='$email',password='$password',timeAdded='$timeAdded'";
    $stmt = $con->prepare($query);
    if(!$stmt->execute())
    {
        die('bind_param() failed: ' . htmlspecialchars($stmt->error));
        echo "err";
    }else{
        
       $_SESSION['email'] = $email;
       $_SESSION['password'] = $password;
       header("Location: ./home.php");
        
    }
}
?>