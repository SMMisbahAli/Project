<?php
require "./../database.php";
header('Content-Type: application/json');

$from = $_GET['from'];
$to = $_GET['to'];

$query_posts= "select u.name, m.id, m.message, m.timeAdded,
m.fromUser from
".$g_projectSlug."_messages m inner join ".$g_projectSlug."_users u on m.fromUser=u.id  where m.fromUser in ('$from', '$to') 
and m.toUser in ('$from', '$to')  order by m.timeAdded asc "; 

// echo $query_posts;

//echo $query_posts;
$result_posts = $con->query($query_posts); 

$posts_arr = array();
if ($result_posts->num_rows > 0)
{ 
    //add 
    while($row = $result_posts->fetch_assoc()) 
    { 
        $post_item = array(
        'id' => $row['id'],    
        'timeAdded' => date("d M Y H:i",$row['timeAdded']),
        'message' => $row['message'],
        'name' => $row['name'],
        'title' => $row['title'],
        'description' => $row['description'],
        'messageId' => $row['id'],
        'senderId' => $row['fromUser'],
        'status' => $row['status'],
        'isEscrow' => $row['isEscrow'],
        'finalPrice' => $row['finalPrice'],
        'paymentMethod' => $row['paymentMethod'],
        'offerStatus' => $row['offerStatus'],
        'rating' => $row['rating'],
        'orderId' => $row['orderId'],
        
      );

      // Push to "data"
      array_push($posts_arr, $post_item);
    }
}



$payload->messages = $posts_arr;

echo json_encode($payload);



?>