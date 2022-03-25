<?
include_once("global.php");

if(!isset($_GET['bId']))
	header("Location:./home.php");


$idFromName=array();
$users=getAll($con,"SELECT * from dashboardmanagement_users");
foreach($users as $row)
{
	$idFromName[$row['id']]=$row['name'];
}
$boardId=$_GET['bId'];

if(isset($_POST['new_card']))
{
	$id=generateRandomString();
	$title=$_POST['title'];
	$description=$_POST['description'];
	$assigned_to=$_POST['assigned_to'];
	$boxId=$_POST['boxId'];
	$actionId=$_POST['actionId'];
	$label=$_POST['label'];

	if(isset($_POST['move_to']))
	{
		$boxId = $_POST['move_to']; 
	}


	$timeAdded=time();
	
	if($actionId=="")
		$query="insert into dashboardmanagement_board_cards set id='$id' , title='$title',description='$description',boxId='$boxId',boardId='$boardId',userId='$session_id',timeAdded='$timeAdded',
	assigned_to='$assigned_to',label='$label'";
	else
		$query="update dashboardmanagement_board_cards set title='$title',description='$description',boxId='$boxId',boardId='$boardId',assigned_to='$assigned_to',label='$label' where id='$actionId'";
	
	$result=$con->query($query);
	if(!$result)
			echo $con->error;
}
?>

<!DOCTYPE html>

<html lang="en">

	<head>
	    <?require("./includes/views/head.php")?>
		<link href="assets/css/pages/login/login-1.css" rel="stylesheet" type="text/css" />
	</head>


<body class="<?echo $g_body_class?>">

		<?require("./includes/views/header.php")?>
        
        	<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

					<!-- begin:: Header -->
					
                    <?require("./includes/views/topmenu.php")?>
					<!-- end:: Header -->

					<!-- begin:: Aside -->
					<?require("./includes/views/leftmenu.php")?>

					<!-- end:: Aside -->
					<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
						<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

							<!-- end:: Subheader -->

							<!-- begin:: Content -->

							<div class="kt-container  kt-grid__item kt-grid__item--fluid">
							    

 							<form method="get" action="">
									
								<div class="row" style="margin-bottom: 30px;">
									<div class="col-md-3">
										<div class="input-group">
											<div class="input-group-prepend"><span class="input-group-text"><i class="flaticon2-search-1"></i></span></div>
											<input type="text" name="search" class="form-control kt-quick-search__input" placeholder="Search...">
										</div>
									</div>
									<div class="col-md-3">
										<select  id="select_criteria" name="select_criteria" class="form-control" onchange="displayCriteria()">
											<option value="" disabled selected >--Select Search Criteria--</option>
											<option value="members">Member</option>
											<option value="labels">Label</option>
										</select>
									</div>
									<div class="col-md-3" style="display:none;" id="members_id">
										<select name="s_member" class="form-control">
											<option value="" disabled selected>--Search By Assigned Member--</option>
											<?
											$boxUsers=getAll($con,"SELECT *,u.id as user_id from dashboardmanagement_board_users bu INNER join dashboardmanagement_users u on bu.userId=u.id where bu.boardId='$boardId'");
											foreach($boxUsers as $row){?>
												<option value="<?echo $row['user_id']?>"><?echo $row['name']?></option>
												<?}?>
										</select>
									</div>
									<div class="col-md-3" style="display:none;" id="label_id">
										<select class="form-control" name="s_label">
											<option value="" selected disabled>--Select Label--</option>
											<option value="Low">Low</option>
											<option value="Medium">Medium</option>
											<option value="High">High</option>
										</select>
									</div>
									<input type="text" name="bId" value="<?echo $boardId?>" hidden>
									<div class="col-md-2" style="text-align: center;">
										<input type="submit" class="btn btn-primary" value="Search">
									</div>
								</div>
								<div class="row " style="text-align:center;margin-bottom: 20px;">
									<div class="col-md-2" style="margin-top: 10px;"><b>TEAM MEMBERS</b></div>
									<div class="col-md-8" style="text-align: left;">
										<?
								$boxUsers=getAll($con,"SELECT *,u.id as user_id from dashboardmanagement_board_users bu INNER join dashboardmanagement_users u on bu.userId=u.id where bu.boardId='$boardId'");
								foreach($boxUsers as $row){?>
										<span style="margin-left: 10px;width: 80px;" class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold"><?echo $row['first_name']?></span>
									<?}?>
									</div>
								</div>
							</form>
							

							<div class="row">
								<?$list=array("TODO","PROGRESS","CODE REVIEW","DONE");
								$pics_link=array("https://todolist.klaro.cards/s/img_general_todo_BIG.png","https://d117h1jjiq768j.cloudfront.net/images/default-source/company-section/vision-mission-banner.jpg","https://cdn.searchenginejournal.com/wp-content/uploads/2021/04/google-product-reviews-update-606f3672ab023.jpg","https://previews.123rf.com/images/carmenbobo/carmenbobo1506/carmenbobo150600542/41642909-rubber-stamp-with-word-done-inside-vector-illustration.jpg");
								for($i=0;$i<4;$i++){?>
								<div class="col-lg-6 col-xl-6 order-lg-1 order-xl-1">
										<div class="kt-portlet kt-portlet--fit kt-portlet--head-lg kt-portlet--head-overlay kt-portlet--skin-solid kt-portlet--height-fluid">
											<div class="kt-portlet__head kt-portlet__head--noborder kt-portlet__space-x">
												<div class="kt-portlet__head-label">
													<h3 style="color: black;" class="kt-portlet__head-title">
														<p>
															<?echo $list[$i];?>
														</p>
													</h3>
												</div>
												<div class="kt-portlet__head-toolbar">
												<!-- 	<a href="#" class="btn btn-label-light btn-sm btn-bold " >
														PRIORITY
													</a> -->
												</div>
											</div>
											<div class="kt-portlet__body kt-portlet__body--fit">
												<div class="kt-widget17">
													<div class="kt-widget17__visual kt-widget17__visual--chart kt-portlet-fit--top kt-portlet-fit--sides" style="background-color: #fd397a">
														<div class="kt-widget17__chart" style="background-image: url('<?echo $pics_link[$i]?>');height:320px;background-size: cover;background-repeat: no-repeat;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
															<canvas id="kt_chart_activities" style="display: block; width: 427px; height: 216px;" width="427" height="216" class="chartjs-render-monitor"></canvas>
														</div>
													</div>

													<?
													$array_boxId=$list[$i];
													if(!isset($_GET['search']))
														$query="select * from dashboardmanagement_board_cards where boardId='$boardId' && boxId='$array_boxId'";
													else
													{
														$search=$_GET['search'];
														$s_member=$_GET['s_member'];
														$s_label=$_GET['s_label'];

														if((!isset($_GET['s_label'])) && (!isset($_GET['s_member'])))
														{
															$query="select * from dashboardmanagement_board_cards where ( description LIKE '%$search%' ||  title LIKE '%$search%') && boardId='$boardId' && boxId='$array_boxId'";
														}
														else
														{
															$query="select * from dashboardmanagement_board_cards where ( description LIKE '%$search%' ||  title LIKE '%$search%') && boardId='$boardId' && boxId='$array_boxId' && label LIKE '%$s_label%' && assigned_to LIKE '%$s_member%' ";
														}
													}

													$cardsForBacklog=getAll($con,$query);
													?>
													<div class="kt-widget17__stats">
														<?foreach($cardsForBacklog as $row){?>
														<a data-toggle="modal" data-target="#add_new_card" data-mydata='<?echo  (json_encode($row, true));?>'>
															<div class="kt-widget17__items">
																<div class="kt-widget17__item">
																	<span class="kt-widget17__subtitle" style="text-align: center;">
																		<?
																		if($row['label']=="Low")
																			echo "<span style='float: right;' class='badge badge-primary'>Low Priority</span>";
																		else if($row['label']=="High")
																			echo "<span style='float: right;' class='badge badge-danger'>High Priority</span>";
																		
																		else if($row['label']=="Medium")
																			echo "<span style='float: right;' class='badge badge-warning'>Medium Priority</span>";
																		
																		if($row['assigned_to']!="")
																			echo "<span   style='float: right;margin-right: 5px;' class='badge badge-primary'>Assigned To : ".$idFromName[$row['assigned_to']]."</span>";

																		if($row['userId']!=$session_id )
																		{
																			echo "<span   style='float: right;margin-right: 5px;' class='badge badge-primary'>Created By : ".$idFromName[$row['userId']]."</span>";
																		}
																		?>
																		

																		<b>
																			<?echo $row['title']?>
																		</b> 
																	</span>
																	<span class="kt-widget17__desc">
																		<?echo $row['description']?>
																	</span>
																</div>
															</div>
														</a>
														<?}?>

													</div>

												</div>
											</div>
											<div style="margin-bottom: 40px;text-align: center;margin-top: 20px;">
												<a onclick="fillBoxId('<?echo $list[$i]?>')" href="#" class="btn btn-brand btn-elevate btn-icon-sm" data-toggle="modal" data-target="#add_new_card">
															<i class="la la-plus"></i>
															Add A Card
												</a>
											</div>

										</div>
									</div>
								<?}?>
							</div>
							</div>

							
							
						</div>
					</div>

					<!-- begin:: Footer -->
					
					<?require("./includes/views/footer.php")?>

					<!-- end:: Footer -->
				</div>
			</div>
		</div>
        
        
        <?require("./includes/views/footerjs.php")?>
		


<div class="modal fade" id="add_new_card" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header" >
					<h5 class="modal-title" id="modelTitle">Insert</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					
					<form class="kt-form" action="" method="Post" enctype="multipart/form-data">
						<div class="kt-portlet__body">
						    
						    <div class="form-group">
								<label>Title</label>
								<input type="text" name="title" class="form-control" required  >
							</div>
						

						    <div class="form-group">
								<label>Description</label>
								<textarea name="description" class="form-control" required></textarea>
							</div>

						    <div class="form-group">
								<label>Assign This Card To User</label>
								<select name="assigned_to" class="form-control">
									<?
								$boxUsers=getAll($con,"SELECT *,u.id as user_id from dashboardmanagement_board_users bu INNER join dashboardmanagement_users u on bu.userId=u.id where bu.boardId='$boardId'");
								foreach($boxUsers as $row){?>
									<option value="<?echo $row['user_id']?>"><?echo $row['name']?></option>
									<?}?>
								</select>
							</div>
							<div class="form-group">
								<label>Attach A Label</label>
								<select class="form-control" name="label">
									<option value="Low">Low</option>
									<option value="Medium">Medium</option>
									<option value="High">High</option>
								</select>
							</div>
							<div class="form-group">
								<label>Move The Card To Section</label>
								<select class="form-control" name="move_to">
									<option value="TODO">TODO</option>
									<option value="PROGRESS">PROGRESS</option>
									<option value="CODE REVIEW">CODE REVIEW</option>
									<option value="DONE">DONE</option>
								</select>
							</div>
							<input type="text" name="boxId" value="" hidden>
							<input type="text" name="actionId" value="" hidden>
						</div>
						<div class="kt-portlet__foot">
							<div class="kt-form__actions">
								<input type="submit" name="new_card" value="Submit" class="btn btn-primary">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</form>
				</div>
			
			</div>
		</div>
	</div>
	
	</body>
	<script>

		$(document).ready(function(){
	    	

          $("#add_new_card").on('show.bs.modal', function (e) {
            //get data-id attribute of the clicked element
            var mydata = $(e.relatedTarget).data('mydata');
            if(mydata!= null){

            	$("#modelTitle").html("Card Details");
                $("input[name='title']").val(mydata['title'])
                $("input[name='actionId']").val(mydata['id'])
                $("input[name='boxId']").val(mydata['boxId'])
          		$("textarea[name='description']").val(mydata['description'])
          		$("select[name='assigned_to']").val(mydata['assigned_to'])
          		$("select[name='label']").val(mydata['label'])
          		$("select[name='move_to']").val(mydata['boxId'])
			}else{
            	$("#modelTitle").html("Add Card");
                $("input[name='title']").val("")
                $("textarea[name='description']").val("")
                $("select[name='assigned_to']").val("")
                $("input[name='actionId']").val("")
          		$("select[name='move_to']").val("")
            }

            
          });
	    })

		function fillBoxId(myboxId)
		{
			$("input[name='boxId']").val(""+myboxId+"");
		}
		function displayCriteria()
		{
			var displayId = $('#select_criteria').val();
			if(displayId == "members")
			{
				$('#members_id').show();
				$('#label_id').hide();
			}
			else
			{
				$('#members_id').hide();
				$('#label_id').show();
			}
		}

	</script>
	
</html>