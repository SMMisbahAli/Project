<?
$g_website = dirname((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");;
// if anomoz server
if (strpos($g_website, 'projects.anomoz.com') !== false) {
    ini_set('session.cookie_lifetime', 60 * 60 * 24 * 100);
    ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 100);
    ini_set('session.save_path', '/tmp');
}

// Report simple running errors
error_reporting(E_ERROR);
ini_set('display_errors', '1');

session_start();
include_once("database.php");
require("./includes/email_css.php");

//some variables in database.php
$g_tagline = "The Best CRM in town. A CRM that contains all the features that you need to run a successfull business, and which takes care of all your business needs.";
$projectUrl = $g_website;
$g_signupEnabled = true;
    $g_accountSettingsEnabled = false;
    $g_forgetPasswordEnabled = false;
    $g_enable2fa = false;
$g_enableMessages = false;
    $g_enableMessages_fileSending = false;
$g_enableImport = false;
$g_enableExport = true;
$g_enableShowNotifications = false;
    $g_enableDeleteNotifications = false;
$g_enableEmployeeManagement = false;
    $g_enableEmployeeAccessAccount = false;
$g_enableTasksModule = true;
$g_enableCustomerManagement = true;
    $g_enableCustomerToLogin = false;
    $g_enableCustomerProfile = false;
    $g_enableCustomerSecondaryFields = false;
    $g_enableCustomerSecondaryFields_crud = false;
    $g_enableCustomerDocuments = false;
    $g_enableCustomerNotes = false;
    $g_enablePipelineManagement = false;
    $g_enablePipelineColorManagement = false;
$g_enableProjectsManagement = false;
    $g_enableProjectViewManagement = false;
    $g_enableProjectViewContentBoard = false;
    $g_enableProjectViewFiles = false;
    $g_enableProjectViewKanbanBoard = false;
$g_enableProductsManagement = false; 
    $g_enableInventoryManagement = true;
$g_enableInvoices = true;
    $g_enableInvoicesProductsItems = false;
    $g_enableInvoicesCustom = true;
$g_enablePaymentGateway = false;
    $g_enableStripe = false;
    $g_enablePaypal = false;
    $g_enableEwallet = false;
    $g_enableDepositeEwallet = false;
$g_enableCalendarReminder = true;
    $g_enableCalendarEdit = true;
    $g_enableCalendarAssignToOthers = true;
$g_enableNewsletters = false;
$g_enableTicketManagement = true;
    $g_enableTicketCustomTags = false;
$g_enableQuestionnaireManagement = false;
$g_enableCampaignsManagement = false; // more needed
$g_enableBulkDelete = false;
$g_showPasswordStrength = false;
$g_logo = "https://www.anomoz.com/style/logo.png";
$g_faviconlogo = $g_logo;
$g_enableLeftMenu = false;
$g_enablePWA = false;

//primary
require_once("./includes/core/session.php");
require_once("./includes/core/dbmodel.php");

//secondary
require_once('./includes/php-excel-reader/excel_reader2.php');
require_once('./includes/SpreadsheetReader.php');
require_once("./includes/models/importExport.php");

// echo $g_website;
setLoginUserSessionVariables();

$session_userId_filter = $session_userId;
if ($session_role == "admin") {
	$session_userId_filter = "";
}



function sendEmailNotification_mailjet($subject, $message, $email, $containsAttachment=0, $attachments = array()){
    global $g_projectTitle;
    $ch = curl_init();
    
    $from = "dev.email.sender2@anomoz.com";;
    
   
    if(true){
        $vars = json_encode(array (
  'Messages' => 
  array (
    0 => 
    array (
      'From' => 
      array (
        'Email' => 'hello@anomoz.com',
        'Name' => $g_projectTitle,
      ),
      'To' => 
      array (
        0 => 
        array (
          'Email' => $email,
          'Name' => 'Receiver',
        ),
      ),
      'Subject' => $subject,
      'TextPart' => $message,
      'HTMLPart' => $message,
      'CustomID' => 'AppGettingStartedTest',
    ),
  ),
), true);
    
    }
    
    
    curl_setopt($ch, CURLOPT_URL,"https://api.mailjet.com/v3.1/send");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $headers = [
        'X-Apple-Tz: 0',
        'X-Apple-Store-Front: 143444,12',
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Encoding: gzip, deflate',
        'Accept-Language: en-US,en;q=0.5',
        'Cache-Control: no-cache',
        'Content-Type: application/json; charset=utf-8',
        'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
        'X-MicrosoftAjax: Delta=true',
    ];
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_USERPWD, "0a297227ed9bd3e7fe0cc8a2b455c1d6:94d2e1d6327833ec4f1129b8c669b7bc");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    
    $server_output = curl_exec ($ch);
    
    curl_close ($ch);
    if($server_output!=""){
        // var_dump($server_output);
    }else{
        // echo "email sent to $email";
    }

}


function sendEmailNotification_sendgrid($subject, $message, $email, $cta = [])
{
    global $g_projectTitle, $g_tagline, $session_email, $domainName;
    
    $ch = curl_init();
    
    $link = $cta[0];
    $cta_text = $cta[1];
        
    if($link==""){
        $link = $domainName;
        
    }if($cta_text==""){
        $cta_text = "View now!";
    }
    
    $to = $email;
    if($email!=""){
        $from = "dev.email.sender2@anomoz.com";;
        
        if(true){
            $vars = json_encode(array (
              'from' => 
              array (
                'email' => $from,
                "name" => $g_projectTitle
              ),
              'personalizations' => 
              array (
                0 => 
                array (
                  'to' => 
                  array (
                    0 => 
                    array (
                      'email' => $to,
                    ),
                  ),
                  'dynamic_template_data' => 
                  array (
                      "project_name" =>$g_projectTitle,
                      "subject" => $subject,
                      "email_title" => $subject,
                      "email_description" => $message,
                      "cta_button_show" => "none",
                      "cta_text" =>$cta_text,
                      "cta_link" => $link,
                      "footer_text" => $g_tagline
                  ),
                ),
              ),
              'template_id' => 'd-c67176d9259e4deca91872f7d0ce2f57',
            ), true);
        }
        
        curl_setopt($ch, CURLOPT_URL,"https://api.sendgrid.com/v3/mail/send");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $headers = [
            'X-Apple-Tz: 0',
            'X-Apple-Store-Front: 143444,12',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Encoding: gzip, deflate',
            'Accept-Language: en-US,en;q=0.5',
            'Cache-Control: no-cache',
            'Content-Type: application/json; charset=utf-8',
            'Host: www.anomoz.com',
            'Referer: http://www.anomoz.com/index.php', //Your referrer address
            'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
            'X-MicrosoftAjax: Delta=true',
            'Authorization: Bearer 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'
        ];
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $server_output = curl_exec ($ch);
        
        curl_close ($ch);
        if($server_output!=""){
            var_dump($server_output);
        }else{
            // echo "email sent to $email";
        }
    }else{
        echo "$subject: $email email is empty";
    }

}

function sendEmailNotification_simple($subject, $message, $email, $containsAttachment=0, $attachments = array()){
    $message = ($message);
    global $g_projectTitle;
   
    if($message!=""){
        $from = 'dev.email.sender1@anomoz.com'; 
        $fromName = $g_projectTitle;
        if($containsAttachment!=1){
            $to = $email; 
             
            $email_body = $message;
            $htmlContent = $email_body; 
            
            // Set content-type header for sending HTML email 
            $headers = "MIME-Version: 1.0" . "\r\n"; 
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
             
            // Additional headers 
            $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 

            // Send email 
            if(mail($to, $subject, $htmlContent, $headers)){ 
                //  echo "Email sent to: ".$email;
            }else{ 
               echo 'Email sending failed.'; 
            }
        }else{
            $mail = new PHPMailer(); // defaults to using php "mail()"

            $mail->AddReplyTo($from,$fromName);
            $mail->SetFrom($from, $fromName);
            
            $mail->AddAddress($email, "Anomoz Softwares");       
            $mail->Subject    = $subject;       
            $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
            
            $mail->MsgHTML($message);
            // $pdf->Output("Test Invoice.pdf","F");
            foreach ($attachments as $att){
                // $path = "/home2/anomozco/projects.anomoz.com/formwizardpdf/example00.pdf";
                // $mail->AddAttachment($att, '', $encoding = 'base64', $type = 'application/pdf');
                $mail->addStringAttachment(file_get_contents($att), 'Packing List.pdf', $encoding = 'base64', $type = 'application/pdf');
                // echo "fileattached $att<br>";
            }
            $emailsent = $mail->Send();
            if(!$emailsent) {
              $message =  "Invoice could not be send. Mailer Error: " . $mail->ErrorInfo;
            } else {
              $message = "Email sent!";
            }
            echo $message;
        }
       
    }                                       

}


function sendEmailNotification($subject, $message, $email){
    sendEmailNotification_sendgrid($subject, $message, $email);                                     
}


function setNotification($con,$data){
    global $g_projectTitle, $g_projectSlug, $g_enableShowNotifications;
    $id = $data['id'];
    $toUser = $data['toUser'];
    $title = $data['title'];
    $desc = $data['desc'];
    $redirectUrl = $data['redirectUrl'];
    $email = $data['email'];

    $sql="INSERT INTO `".$g_projectSlug."_notifications`(`notification_id`, `to_user_id`, `title`, `description`, `redirect_url`) VALUES ('".$id."','$toUser','$title','$desc','$redirectUrl')";
    if(!mysqli_query($con,$sql)){
        echo mysqli_error($con);
        return !true;
    }
    
    if(!true){
        if($redirectUrl!=""){
            $viewLink = "<a href=\"$redirectUrl\" style=\"text-align: center;
                margin: 1px auto;
                justify-content: center;
                display: block;
                background: #0a2b6e;
                padding: 10px;
                border-radius: 10px;
                width: 150px;
                color: white;\" >View </a>";
    
        }
        $email_content.="
        <div
            
            style=\"text-align: center;
            margin: 1px auto;
            justify-content: center;
            display: block;
            background: #f0f3fe;
            padding: 10px;
            border-radius: 10px;
            color: black;
    
    
            \">
    
        
        <h2 style='text-align: center;padding-bottom: 5px;font-size: 30px !important;font-weight: 800;'>$g_projectTitle</h2>
        
        <h4 style='text-align: center;padding-bottom: 5px;font-size: 20px;'>$title</h4>
        <p style='text-align: center;font-size: 18px;'>$desc</p>
        
        $viewLink
    
    </div>
    ";
        $email_template = $email_template_top.$email_content.$email_template_bottom;
        // sendEmailNotification($title,$email_template,$email, $redirectUrl); // for santino
    
    }
    
    if($g_enableShowNotifications){
        sendEmailNotification_sendgrid($title, $desc, $email, [$redirectUrl, "View Now!"]);
    }
    return true;
}





$g_main_admin_id = "admin";
$g_body_class = "kt-page--loading-enabled kt-page--loading kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--left kt-aside--fixed kt-page--loading";
$g_body_class = "";


//check if logged in 
$allowedUrls = array("", "index.php", "forget_password.php", "signup.php", "login.php", "password_reset.php", "book_packages.php","load_services.php" ,
"process.php","callback.php", "maincss.php", "invoices.php");
$filenameLink = basename($_SERVER['PHP_SELF']);
if((!$_SESSION['email']) && (!in_array($filenameLink, $allowedUrls))){
    header("Location: ./");
    exit();
}


$g_enableEdit = true;
$g_enableDelete = true;



$getCustomersFromDB = getAll($con,"SELECT * FROM ".$g_projectSlug."_users");
$g_allUsersInfo = [];
foreach($getCustomersFromDB as $k => $v){
	$g_allUsersInfo[$v['id']] = $v; 
}

function validatePrevilage(){
    return true;
}

?>
<script >
setInterval(function(){ 
    $.get( "cronJob.php" );
}, 10000);
</script>