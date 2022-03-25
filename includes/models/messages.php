<?
//".rushsale."
if(!$g_enableMessages){
    header("Location: ./home.php?m=issue occured. Contact the developer");
}
if(isset($_POST["new_message"]) || isset($_POST['finalPrice']))
{
    $receiverId = $_POST["receiverId"];
    $receiverEmail = $_POST["receiverEmail"];
    $new_message = $_POST["new_message"];
    $timeAdded = time();
    $orderId = generateRandomString();
    
    
    
    if(isset($_FILES["fileToUpload"])){
            $randomName = generateRandomString();
            $target_dir = "./uploads/";
            $fileName_db = "aud_".$randomName.basename($_FILES["fileToUpload"]["name"]);
            $target_file = $target_dir . "aud_".$randomName.basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if($_FILES["fileToUpload"]["tmp_name"]!="") {
                
                $uploadOk = 1;
            
            // Check if file already exists
            if (file_exists($target_file)) {
                //echo "Sorry, file already exists.";
                $filename=basename( $_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
            }
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 5000000000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if(false) {
                echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed.";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                    $filename=basename( $_FILES["fileToUpload"]["name"]);
                    $uploadOk = 1;
                    
                    $new_message = $fileName_db;
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
            }
        }
        
        
        

    if($new_message!=""){
        $sql="insert into ".$g_projectSlug."_messages set id='$orderId', fromUser='$session_userId', toUser='$receiverId', timeAdded='$timeAdded', message='$new_message', status='new'";
        if(!mysqli_query($con,$sql))
        {
            echo "err3";
        }
    }

    
    /*send notification - @notf*/
    $userNotfDeets = getRow($con, "select * from ".$g_projectSlug."_users where id='$receiverId'");
    $notificationData = [
        'id' => generateRandomString(),
        'title' => 'New message from '.ucfirst($session_name),
        'desc' => $new_message,
        'redirectUrl' => $g_website.'/messages.php?u='.$session_userId,
        'toUser' => $receiverId,
        'email' => $userNotfDeets['email'],
    ];
    setNotification($con,$notificationData); // globalFunction 
    /*end of send notification - @notf*/
            
}


if(isset($_GET['u'])){
    $message_to_userId = $_GET['u'];
    $recieverId = $message_to_userId;
    if($session_userId==$message_to_userId){
        header("Location: ./?m=You can't message yourself.");
    }
    
    $sql="update ".$g_projectSlug."_messages set status='read' where (toUser='$session_userId' and fromUser='$message_to_userId') or (fromUser='$session_userId' and toUser='$message_to_userId')";
    if(!mysqli_query($con,$sql)) {echo "err1";}

    $sq     = "select * from ".$g_projectSlug."_users where id='$message_to_userId'";
    $result = $con->query($sq);
    $num    = mysqli_num_rows($result);
    if($num>0){
        while ($row = $result->fetch_assoc()) {
            $message_to_name = $row['name'];
            $receiverEmail = $row['email'];
            $recievers_temp_1 = $row;
            $recievers_temp_1['senderId'] = $row['id'];
        }
    }else{
       header("Location: ?not-found");
    }
    
}

//unread messages
$unreadMessages = array();
$sq = "select  count(*) nMessages, fromUser from ".$g_projectSlug."_messages m inner join ".$g_projectSlug."_users u 
    on m.fromUser=u.id where toUser='$session_userId' 
    and m.status='new' group by fromUser order by m.timeAdded asc";
$result1 = $con->query($sq);
$num = mysqli_num_rows($result1);
while ($row1 = $result1->fetch_assoc())
{
    $unreadMessages[$row1['fromUser']] = $row1['nMessages'];
}

?>