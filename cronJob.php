<?
require("./global.php");
date_default_timezone_set("Asia/Karachi");
$boards=getAll($con,"select * from dashboardManagement_boards");
foreach($boards as $row)
{
	$timeNow=time();
	$timeNow=date('h:i a', time());
	$timePrompt = date('h:i a', strtotime($row['prompt_time']));
	echo "Time Now".$timeNow."Time prompt_time".$timePrompt;
	if($timeNow == $timePrompt || true)
	{ 
		$boardId=$row['id'];
		$query="select *,u.id as userId from dashboardmanagement_board_users bu inner join dashboardManagement_users u on bu.userId=u.id where boardId='$boardId'";
		$boardUsers=getAll($con,$query);
		
		foreach($boardUsers as $row)
		{
			$userId=$row['userId'];
			$query="update dashboardManagement_users set prompt_user='Yes' , boardId='$boardId' where id='$userId'";
			$result = $con->query($query);

			if(!$result)
				echo $con->error;
			else
				echo "updated";
		}
	}
}
?>