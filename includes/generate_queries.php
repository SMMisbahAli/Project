<?require("../database.php");

$g_projectSlug = "lastingPatientCrma";



function generateRandomString($length = 10) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


//generate DROP TABLE queries
if(true){
    $tables = ["attendance","transaction","attendance_dates","calendar_reminders","crud","customers","customer_fields",
    "customer_field_values","documents","inventory_history","invoices","messages","invoices_products","module","newsletters",
    "notes","notifications","password_resets","payments","permissions","pipelines","products","projects","questionnaires","questionnaires_questions",
    "questionnaires_answers","salary","tags","tasks","tickets","ticket_replies","ticket_tags","users"];
    
    $g_projectSlug_small = strtolower($g_projectSlug);
    foreach ($tables as $tb){
        echo "DROP TABLE IF EXISTS `$g_projectSlug"."_$tb`; DROP TABLE IF EXISTS `$g_projectSlug_small"."_$tb`;<Br>";
    }
}

//generate multiple copy entries queries
if(false){
    
    
    for($i=0; $i<10; $i++){
        $id = generateRandomString();
        $query = "INSERT INTO `dandelPropertySite_properties` (`id`, `title`, `address`, `description`, `pictures`, `category`, `timeAdded`, `userId`, `cost`, `bedrooms`, `bathrooms`, `area`) VALUES ('$id', 'For Sale', 'In publishing and graphic design, Lorem ipsum is a ', 'In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available. WikipediaIn publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available. WikipediaIn publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available. WikipediaIn publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available. WikipediaIn publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available. Wikipedia', '[\"aud_0GU55N5E9Jhouse8.png\",\"aud_9TEYB5VRKQhouse6.png\",\"aud_BLZ5EIVQH0house5.png\",\"aud_VB2BP4SUY4house4.png\",\"aud_PTKW25KLB6house3.png\",\"aud_RMMLSSQ05Lhouse2.png\"]', 'For Sale', '1646033100', 'admin', '100', '4', '3', '1000');";
        echo $query."<br>";
    }
    
    
}