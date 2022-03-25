<?php

// $logged, $session_role, $session_id, $session_userId, $session_password ,$session_name, $session_email, $session_phone, $session_data = "";
function setLoginUserSessionVariables(){
    global $con, $g_projectSlug, $logged, $session_role, $session_id, $session_userId, $session_password ,$session_name, $session_email, $session_phone, $session_data;
    if (isset($_SESSION['email'])&&isset($_SESSION['password']))
    {
        $session_password = $_SESSION['password'];
        $session_email =  $_SESSION['email'];
        $query = "SELECT *  FROM ".$g_projectSlug."_users WHERE email='$session_email' AND password='$session_password'";
        // echo $query;
        // exit();
        $result = $con->query($query);
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()) 
            {
                $logged=1;
                $session_role = $row['role'];
                $session_id = $row['id'];
                $session_userId = $row['id'];
                $session_password = $row['password'];
                $session_name = $row['name'];
                $session_email = $row['email'];
                $session_phone = $row['phone'];
                $session_data = $row;
            }
        }else
        {
            $logged=0;
        }
    }
    else
    {
            $logged=0;
    }
    
    if(isset($_SESSION['usernumber'])){
        $usernumber = $_SESSION['usernumber'];
        $sq     = "SELECT * from ".$g_projectSlug."_users where usernumber = '$usernumber'  ";
            $result = $con->query($sq);
            $num    = mysqli_num_rows($result);
            if ($num == 1) {
            	$logged = 1;
        	    	while ($row = $result->fetch_assoc()) {
        	    		$_SESSION['id'] = $row['id'];
        	    		$session_name = $row['name'];
        	            $session_email = $row['email'];;
        	            $session_userId = $row['id'];
        	            $session_role = $row['role'];
        	            $session_phone = $row['phone'];
                        $session_address = $row['address'];
                        $session_about = $row['about'];
                        $session_data = $row;
        	    }
            }
    }
}

// var_dump($_SESSION);
function mb_htmlentities($string, $hex = true, $encoding = 'UTF-8') {
    global $con;
    return mysqli_real_escape_string($con, $string);
}

function escape($string, $hex = true, $encoding = 'UTF-8') {
    global $con;
    return mysqli_real_escape_string($con, $string);
}


function setFlash($key, $value, $type){
    $_SESSION['flash_msg'][$key] = ['type' => $type, 'msg' => $value];
}

function getFlash($key){
    return $_SESSION['flash_msg'][$key]['msg'] ?? false;
}

function getFlashType($key){
	return $_SESSION['flash_msg'][$key]['type'] ?? false;
}

function removeFlash($key){
    unset($_SESSION['flash_msg'][$key]);
}


//primary functions

function generateRandomString($length = 10) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateId($length = 10) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function editDelete($table, $row, $id, $id_value, $whichBtns="ed"){
    global $session_role;
    global $g_main_admin_id;
    if($session_role=="admin" && $g_main_admin_id=="admin"){
        if (strpos($whichBtns, 'e') !== !true) {
        ?>
        <a class="btn btn-sm btn-warning" href="./g_edit.php?t=<?echo $table?>&r=<?echo $row?>&i=<?echo $id?>&iv=<?echo $id_value?>&c=<?echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>" style="color:white;background:orange;">Edit</a>
        <?}
            if (strpos($whichBtns, 'd') !== !true) {
        ?>
        <a class="btn btn-sm btn-danger" href="./g_delete.php?t=<?echo $table?>&r=<?echo $row?>&i=<?echo $id?>&iv=<?echo $id_value?>&c=<?echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>" style="color:white;background:red;">Delete</a>
        <?
        }
    }
}

function storeFile($file){
	$randomName = generateRandomString();
	$target_dir = "./uploads/";
	$fileName_db = "aud_".$randomName.basename($file["name"]);
	$target_file = $target_dir . "aud_".$randomName.basename($file["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
	if($file["tmp_name"]!="") {
		$uploadOk = 1;
        // Check if file already exists
		if (file_exists($target_file)) {
            //echo "Sorry, file already exists.";
			$filename=basename( $file["name"]);
			$uploadOk = 1;
		}
            // Check file size
		if ($file["size"] > 5000000000000) {
			$uploadOk = 0;
			return "";
		}
        
        // Allow certain file formats
        $allowrdFormats = ["jpg", "jpeg", "png", "gif", "mp4", "mp3", "docx"];
        if(!in_array($imageFileType, $allowrdFormats) ) {
          echo "Sorry, this format is not allowed. Format received: $imageFileType";
          $uploadOk = 0;
        }
        
        

        // Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			return "";
        // if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($file["tmp_name"], $target_file)) {
                //echo "The file ". basename( $file["name"]). " has been uploaded.";
				$filename=basename( $file["name"]);
				$uploadOk = 1;
				return $fileName_db;
			} else {
				return "";
			}
		}
	}
	return "";
}

function uploadMultipleFile($file,$k,$target_dir = "./uploads/"){
    $randomName = generateRandomString();
    $fileName_db = "aud_".$randomName.basename($file["name"][$k]);
    $target_file = $target_dir . $fileName_db;

    //The temp file path is obtained
    $tmpFilePath = $file['tmp_name'][$k];
   //A file path needs to be present
    if ($tmpFilePath != ""){
      //File is uploaded to temp dir
      if(move_uploaded_file($tmpFilePath, $target_file)) {
        return $fileName_db;
      }
      return "default.png";
    }
}


function convertArrayToIndexArray($arr){
    $temparr = [];
    foreach($arr as $row){
        $temparr[$row] = $row;
    }
    return $temparr;
}

function secondsToTime($inputSeconds) {
    $secondsInAMinute = 60;
    $secondsInAnHour = 60 * $secondsInAMinute;
    $secondsInADay = 24 * $secondsInAnHour;

    // Extract days
    $days = floor($inputSeconds / $secondsInADay);

    // Extract hours
    $hourSeconds = $inputSeconds % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);

    // Extract minutes
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);

    // Extract the remaining seconds
    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    $seconds = ceil($remainingSeconds);

    // Format and return
    $timeParts = [];
    $sections = [
        'day' => (int)$days,
        'hour' => (int)$hours,
        'minute' => (int)$minutes,
    ];

    foreach ($sections as $name => $value){
        if ($value > 0){
            $timeParts[] = $value. ' '.$name.($value == 1 ? '' : 's');
        }
    }

    return implode(', ', $timeParts);
}


function renderFormFieldsFromCrudJson($arrayFields_crud){
    ?>
    <? foreach ($arrayFields_crud as $col => $info) { ?>
		<div class="form-group">
			<? if (strpos($info[1], "hidden") === false) { ?>
				<label><? echo ucfirst(str_replace("_", " ", $col)) ?></label>
				<? if ($info[4] != "") { ?>
					<small><? echo $info[4] ?></small>
				<? } ?>
			<? } ?>
			<? if ($info[0] == "input" && in_array($info[3], ["text", "email", "password", "number", "file", "date", "time", "color", "datetime", "checkbox", "radio"])) { ?>
				<? if (in_array($info[3], ["checkbox", "radio"])) { ?>
					<? foreach ($info[2] as $i => $option) { ?>
						<div class="form-check">
							<input name="<? echo $col ?><? if ((strpos($info[1], 'multiple') !== false)) {
															echo '[]';
														} ?>" class="form-check-input" type="<? echo $info[3] ?>" value="<? echo $i ?>" id="<? echo $col ?>" <? echo $info[1] ?>>
							<label class="form-check-label" for="<? echo $col ?>">
								<? echo ucfirst(str_replace("_", " ", $option)) ?>
							</label>
						</div>
					<? } ?>
				<? } else { ?>
					<input type="<? echo $info[3] ?>" name="<? echo $col ?><? if ((strpos($info[1], 'multiple') !== false)) {
																				echo '[]';
																			} ?>" class="form-control" <? echo $info[1] ?>>
				<? } ?>
			<? } else if ($info[0] == "select") { ?>
				<select name="<? echo $col ?><? if ((strpos($info[1], 'multiple') !== false)) {
													echo '[]';
												} ?>" class="form-control" <? echo $info[1] ?>>
					<? foreach ($info[2] as $i => $option) { ?>
						<option value="<? echo $i ?>"><? echo $option ?></option>
					<? } ?>
				</select>
			<? } else if ($info[0] == "input" && in_array($info[3], ["image"])) { ?>
				<input type="file" name="<? echo $col ?><? if ((strpos($info[1], 'multiple') !== false)) {
															echo '[]';
														} ?>" class="form-control" <? echo $info[1] ?>>
			<? } else if ($info[0] == "textarea") { ?>
				<textarea type="text" name="<? echo $col ?>" class="form-control" <? echo $info[1] ?>></textarea>
			<? } else { ?>
				<code><? echo $col ?> Couldn't render</code>
			<? } ?>
		</div>
	<? } ?>
    <?
}

function renderModalJqueryFromCrudJson($arrayFields_crud){
    ?>
    if (mydata != null) {
		$("#modelTitle").html("Update");
		<? foreach ($arrayFields_crud as $col => $info) {
			if ((strpos($info[1], "hidden") == false) && !in_array($info[3], ["file", "image"])) { ?>
				<? if (!in_array($info[3], ["checkbox", "radio"])) { ?>
					$("<? echo $info[0] ?>[name='<? echo $col ?><? if ((strpos($info[1], 'multiple') !== false)) {
						echo '[]';
					} ?>']").val(mydata['<? echo $col ?>'])
				<? } else { ?>
					if (mydata['<? echo $col ?>'] != "") {
						isChecked = true;
					} else {
						isChecked = false;
					}
					$("<? echo $info[0] ?>[name='<? echo $col ?><? if ((strpos($info[1], 'multiple') !== false)) {
    					echo '[]';
    				} ?>']").prop('checked', isChecked);
				<? } ?>
		<? }
		} ?>
		$("input[name='actionId']").val(mydata['id'])
	} else {
		$("#modelTitle").html("Insert");
		$("input[name='actionId']").val("")
		<? foreach ($arrayFields_crud as $col => $info) {
			if ((strpos($info[1], "hidden") == false) && !in_array($info[3], ["file", "image"])) { ?>
				<? if (!in_array($info[3], ["checkbox", "radio"])) { ?>
					$("<? echo $info[0] ?>[name='<? echo $col ?><? if ((strpos($info[1], 'multiple') !== false)) {
						echo '[]';
					} ?>']").val("")
				<? } ?>
		<? }
		} ?>

		$("input[name='actionId']").val("")

	}
    <?
}




//if enabled twilio
// require_once __DIR__ . '/vendor/Twilio/autoload.php';
// use Twilio\Rest\Client;
function sendansms($phonenumber,$message){

    $smsErrMsg = null;
    try{
      // Your Account SID and Auth Token from twilio.com/console
        $sid = 'AC3266101362ec113da0700e395def752a';
        $token = 'b170048db896220e0f8817e7d40fd7ec';
        $client = new Client($sid, $token);
        
        // Use the client to do fun stuff like send text messages!
        $client->messages->create(
            // the number you'd like to send the message to
            $phonenumber,
            array(
                // A Twilio phone number you purchased at twilio.com/console
                'from' => '+18563910805', 
                // the body of the text message you'd like to send
                'body' => $message
            )
        );
        return "SMS Sent Successfully.";
    }catch(Exception $e){
        $smsErrMsg = $e->getMessage();
    }
    return $smsErrMsg;
    
}


function testEmailServer(){
    sendEmailNotification_simple("Testing email sent.", "This is a test email sent.", "snahmed1998@gmail.com");
    echo "Email sent";
}


function testSMSServer(){
    echo sendansms("923362286024", "This is a test sms sent.");
}

function printArray($array){
    echo "<pre><code>";
    var_dump($array);
    echo "</code></pre>";
}

function sendRequest($url, $type="GET", $postFields = [], $headers = ['Content-Type:application/json']){
    
    
    if(strtolower($type)=="get"){
        $type_bool = 0;
    }else{
        $type_bool = 1;
    }
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, $type_bool);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    if(strtolower($type)=="post"){
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($postFields));
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $server_output = curl_exec($ch);
    
    curl_close ($ch);
    return $server_output;
}


function generateRandomUsername(){
    $result = json_decode(sendRequest("https://randomuser.me/api/", "get", [], ['Content-Type:application/json']), true);
    return $result['results'][0]['login']['username'];
}


function checkPermission($module_name, $action_needed,$session_userId){
    global $con;

    $query = "SELECT $action_needed from ".$g_projectSlug."_module WHERE userId = '$session_userId' AND module_name = '$module_name' ";
    $result = $con->query($query);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) 
        {
           // print_r($row);
            if ($row[$action_needed] == 'Y') {
                return true;
            }
            if($row[$action_needed] == 'N'){

                return false;
            }
            if($row[$action_needed] == ''){

                return true;
            }
            
        }
    }
   
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


$timeAdded = time();
$time = time();
?>