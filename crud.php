<?  require("./global.php");
$primaryTableName = "crud";

$getCustomersFromDB = getAll($con,"SELECT * FROM ".$g_projectSlug."_users");
$customerArr = [];
foreach($getCustomersFromDB as $k => $v){
	$customerArr[$v['id']] = ucfirst($v['name']); 
}


$arrayFields_crud = array(
    // field_name [type, isrequired, array_select, inner_type] <= "template"
    "name" => ["input", "multiple", "", "file"],
    "customerId" => ["input", "hidden value='$customer_id'", "", "text"],
    // "document" => ["input", "", "", "file"],
    "email" => ["input", "multiple", convertArrayToIndexArray(["Yes", "No"]), "checkbox"],
);

//for generating table generation queries
if(false){
    $t = "DROP TABLE IF EXISTS ".$g_projectSlug."_".$primaryTableName."; CREATE TABLE ".$g_projectSlug."_".$primaryTableName."(<br>id VARCHAR(200) PRIMARY KEY,<br>";
    foreach($arrayFields_crud as  $col => $info){
        if((strpos($info[1], 'multiple') !== false) || $col[0]=="textarea"){$textSide = "longtext";}else{$textSide = "VARCHAR(256)";}
        $t.= "$col $textSide DEFAULT '' ,<Br>";
    }
    $t.= "timeAdded VARCHAR(256) NULL,<br>userId VARCHAR(256) NULL);";
    echo "<code>$t</code>";
}

//for insert & update
if(isset($_POST['create_package'])){
    $timeAdded = time();
    $actionId = mb_htmlentities(($_POST['actionId']));
    $files_array = [];
	$queryExtra = '';
	foreach($arrayFields_crud as  $col => $info){
	    
	    if(in_array($info[3], ["image", "file"])){
            //for images
	        if(isset($_FILES[$col])){
	            
	            if((strpos($info[1], 'multiple') !== false)){
	                $imageArray = [];
	                foreach ($_FILES[$col]['tmp_name'] as $k => $pic) {
            			$figure = uploadMultipleFile($_FILES[$col],$k,"./uploads/");
            			$imageArray[] = $figure;
            		}
            		$fileLink = json_encode($imageArray, true);
	            }else{
	                $fileLink = storeFile($_FILES[$col]); 
	            }
	            
                $files_array[$col] = $fileLink;
            }
	    }else{
	        //for text
	        //if multiple type field
    	    if((strpos($info[1], 'multiple') !== false)){
    	        $val = (json_encode($_POST[$col], true));
    	    }else{
    	        $val = mb_htmlentities($_POST[$col]);
    	    }
    	    
    	    if($val!='' && $val!=NULL){
    	        $queryExtra.= ", $col='".$val."' ";
    	    }
    	    
	    }
	}

    $timeAdded = time();
    $id = generateRandomString();
    if($actionId==""){
        $actionId = $id;
        $query = "insert into ".$g_projectSlug."_".$primaryTableName." set id='$id' $queryExtra, timeAdded='$timeAdded', userId='$session_userId' ";
        $stmt = $con->prepare($query);
        if(!$stmt){echo "err: <code>$query</code>";}
        if(!$stmt->execute()){echo "err: <code>$query</code>";}
    }else{
        //update
        $query = "update ".$g_projectSlug."_".$primaryTableName." set id='$actionId' $queryExtra where id='$actionId'";
        $stmt = $con->prepare($query);
        if(!$stmt){echo "err: <code>$query</code>";}
        if(!$stmt->execute()){echo "err: <code>$query</code>";}
    }
    
    //update files
    foreach($files_array as $col => $file){
        if($file!=""){
            $stmt = $con->prepare("update ".$g_projectSlug."_".$primaryTableName." set $col='$file' where id='$actionId'");
            if(!$stmt){echo "err: <code>$query</code>";}
            if(!$stmt->execute()){echo "err: <code>$query</code>";}
        }
    }

    if($g_redirectHomeOnSave){
        header("Location: ./home.php?m=Data was saved successfully!");
    }else{
        $rStr = "";
        if(isset($_GET['id'])){$rStr =  "&id=".$_GET['id'];}
        header("Location: ?m=Data was saved successfully!".$rStr);
    }
    
}

if(isset($_GET['delete-record'])){
    $id = mb_htmlentities($_GET['delete-record']);
    if($id!="admin"){
        $stmt = $con->prepare("delete from ".$g_projectSlug."_".$primaryTableName." where id=?");
        $stmt->bind_param("s", $id);
        if(!$stmt->execute()){echo "err";}
    }
}

if($g_enableBulkDelete){
    if(isset($_POST['delete_bulk'])){
        $del  = "('".implode("', '", $_POST['delete_bulk'])."')";
        $sql="delete from ".$g_projectSlug."_".$primaryTableName." where id in $del";
        if(!mysqli_query($con,$sql))
        {
            echo"can not";
        }
    }

}


?>
<!DOCTYPE html>


<html lang="en">

	<!-- begin::Head -->
	<head><?require("./includes/views/head.php")?>
</head>

	<!-- end::Head -->

	<!-- begin::Body -->
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
							    
							    <?if(isset($_GET['m'])){?>
							        <div class="alert alert-info"><?echo $_GET['m']?></div>
							    <?}?>

								<div class="kt-portlet kt-portlet--mobile">
									<div class="kt-portlet__head kt-portlet__head--lg">
										<div class="kt-portlet__head-label">
											<span class="kt-portlet__head-icon">
											</span>
											<h3 class="kt-portlet__head-title">
												<?echo ucfirst(str_replace("_", " ", $primaryTableName));?>
											</h3>
										</div>
										<div class="kt-portlet__head-toolbar">
											<div class="kt-portlet__head-wrapper">
												<div class="kt-portlet__head-actions">
												    
												    <?//renderImportExportButtons();?>
												    
													<a href="#" class="btn btn-brand btn-elevate btn-icon-sm" data-toggle="modal" data-target="#create_record_modal">
														<i class="la la-plus"></i>
														New Record
													</a>
															
												</div>
											</div>
										</div>
									</div>
									<div class="kt-portlet__body">
                                        <form action="" method="post">
                                            <?if($g_enableBulkDelete){?>
                                                <button type="button" class="btn btn-info btn-sm text-white " onclick="selectAll();">Select All</button>
                                                <button type="submit"  class="btn btn-danger btn-sm text-white ">Delete Bulk</button>
                                            <?}?>
    										<!--begin: Datatable -->
    										<table class="table table-striped- table-bordered table-hover table-checkable add-search" id="kt_table_1">
    											<thead>
    												<tr>
    												    <?if($g_enableBulkDelete){?><th>Select</th><?}?>
    													<?$query = "select * from ".$g_projectSlug."_".$primaryTableName." t order by timeAdded desc";
    												    $header = getRow($con, $query. " limit 1");
    												    foreach($arrayFields_crud as  $col => $info){
												            if(array_key_exists($col, $header)){
													            if(strpos($info[1], "hidden")===false){?>
													                <th><?echo ucfirst(str_replace("_", " ", $col))?></th>
    													<?}}}?>
    												
    													<th>Actions</th>
    												</tr>
    											</thead>
    											<tbody>
    											    <?$results = getAll($con, $query);
    											    foreach($results as $row){?>
        												<tr>
        												    <?if($g_enableBulkDelete){?>
            												    <th><div class="form-check">
                                                                    <label class="form-check-label">
                                                                      <input class="form-check-input" type="checkbox" name="delete_bulk[]" value="<?echo $row['id']?>">
                                                                      <span class="form-check-sign">
                                                                        <span class="check"></span>
                                                                      </span>
                                                                    </label>
                                                                  </div>
                                                                 </th>
                                                            <?}?>
        													<?foreach($arrayFields_crud as $col => $info){
        													    if((strpos($info[1], 'multiple') !== false)){$row[$col] = json_decode($row[$col], true);}
        													    if(strpos($info[1], "hidden")===false){?>
        													    <td>
        													        <?
        													        if(array_key_exists($col, $header)){
            													        if(false){
            													            //especial cases & formatting like badges etc
            													        }else{
                													        if(in_array($info[3], ["image", "file"])){
                													            if((strpos($info[1], 'multiple') !== false)){
                													                $files = $row[$col];
                													            }else{
                													                $files = [$row[$col]];
                													            }
                													            foreach($files as $file){?>
                													                <?if($file!=""){?>
                													                    <?if($info[3]=="image"){?>
                													                        <a href="./uploads/<?echo $file?>" target="_blank"><img src="./uploads/<?echo $file?>" class="img-thumbnail" style="height:90px;"  onerror="this.src='./assets/media/404.png';"></a>
                													                    <?}else if($info[3]=="file"){?>
                													                        <a href="./uploads/<?echo $file?>" target="_blank" class='badge btn-info btn-sm'>View File</a>
                													                    <?}?>
                													                <?}?>
                													            <?}?>
                													            
                    													    <?}else{
                    													        if((strpos($info[1], 'multiple') !== false)){
                    													           foreach(($row[$col]) as $mData){
                    													               echo $mData.", ";
                    													           }
                    													        }else{
                    													            echo ($row[$col]);
                    													        }
                													        }
                													    }
            													    }?>
        													    </td>
        													<?}}?>
        													
        													<td>
        													    <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#create_record_modal" data-mydata='<?echo  (json_encode($row, true));?>' >Edit</a>
        													    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#delete_record" data-url="?<?if(isset($_GET['id'])){echo "id=".$_GET['id']."&";}?>delete-record=<?echo $row['id']?>">Delete</a>
        													</td>
        												</tr>
    												<?}?>
    												
    											</tbody>
    										</table>
                                        </form>
										<!--end: Datatable -->
									</div>
								</div>
							
							
							</div>

							
							

							<!-- end:: Content -->
						</div>
					</div>

					<!-- begin:: Footer -->
					
					<?require("./includes/views/footer.php")?>

					<!-- end:: Footer -->
				</div>
			</div>
		</div>
        
        
        <?require("./includes/views/footerjs.php")?>
		

	</body>

	<!-- end::Body -->
	
	<div class="modal fade" id="create_record_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modelTitle">Insert</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					</button>
				</div>
				<div class="modal-body">
					
					<form class="kt-form" action="" method="Post" enctype="multipart/form-data">
						<div class="kt-portlet__body">
						    
						    <?foreach($arrayFields_crud as $col => $info){?>
						    <div class="form-group">
						        <?if(strpos($info[1], "hidden")===false){?>
								    <label><?echo ucfirst(str_replace("_", " ", $col))?></label>
								    <?if($info[4]!=""){?>
								        <small><?echo $info[4]?></small>
								    <?}?>
								<?}?>
								<?if($info[0]=="input" && in_array($info[3], ["text", "email", "password", "number", "file", "date", "time", "color", "datetime", "checkbox", "radio"])){?>
								    <?if(in_array($info[3], ["checkbox", "radio"])){?>
								        <?foreach($info[2] as $i=> $option){?>
    								        <div class="form-check">
                                              <input name="<?echo $col?><?if((strpos($info[1], 'multiple') !== false)){echo '[]'; }?>" class="form-check-input" type="<?echo $info[3]?>" value="<?echo $i?>" id="<?echo $col?>" <?echo $info[1]?>>
                                              <label class="form-check-label" for="<?echo $col?>">
                                                <?echo ucfirst(str_replace("_", " ", $option))?>
                                              </label>
                                            </div>
                                        <?}?>
								    <?}else{?>
								    <input type="<?echo $info[3]?>" name="<?echo $col?><?if((strpos($info[1], 'multiple') !== false)){echo '[]'; }?>" class="form-control" <?echo $info[1]?>  >
								    <?}?>
								<?}else if($info[0]=="select"){?>
								    <select name="<?echo $col?><?if((strpos($info[1], 'multiple') !== false)){echo '[]'; }?>" class="form-control" <?echo $info[1]?>  >
    								    <?foreach($info[2] as $i=> $option){?>
    								        <option value="<?echo $i?>"><?echo $option?></option>
    								    <?}?>
								    </select>
								<?}else if($info[0]=="input" && in_array($info[3], ["image"])){?>
								    <input type="file" name="<?echo $col?><?if((strpos($info[1], 'multiple') !== false)){echo '[]'; }?>" class="form-control" <?echo $info[1]?>  >
								<?}else if($info[0]=="textarea"){?>
								    <textarea type="text" name="<?echo $col?>" class="form-control" <?echo $info[1]?>  ></textarea>
								<?}else{?>
								    <code><?echo $col?> Couldn't render</code>
								<?}?>
							</div>
							<?}?>
						
							<input type="text" name="actionId" value="" hidden>
							
						</div>
						<div class="kt-portlet__foot">
							<div class="kt-form__actions">
								<input type="submit" name="create_package" value="Submit" class="btn btn-primary">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							</div>
						</div>
					</form>
				</div>
			
			</div>
		</div>
	</div>
	
	
	<script>
	    $(document).ready(function(){
	    	
          $("#create_record_modal").on('show.bs.modal', function (e) {
            //get data-id attribute of the clicked element
            var mydata = $(e.relatedTarget).data('mydata');
            console.log(mydata);
            //console.log("mydata", mydata)
            if(mydata!= null){
            	$("#modelTitle").html("Update");
            	<?foreach($arrayFields_crud as $col => $info){
            	    if((strpos($info[1], "hidden")===false) && !in_array($info[3], ["file", "image"])){?>
            	        <?if(!in_array($info[3], ["checkbox", "radio"])){?>
                            $("<?echo $info[0]?>[name='<?echo $col?><?if((strpos($info[1], 'multiple') !== false)){echo '[]'; }?>']").val(mydata['<?echo $col?>'])
                        <?}else{?>
                            if(mydata['<?echo $col?>']!=""){isChecked = true;}else{isChecked = false;}
                            $("<?echo $info[0]?>[name='<?echo $col?><?if((strpos($info[1], 'multiple') !== false)){echo '[]'; }?>']").prop('checked', isChecked);
                        <?}?>
                <?}}?>
                $("input[name='actionId']").val(mydata['id'])
            }else{
            	$("#modelTitle").html("Insert");
                $("input[name='actionId']").val("")
                <?foreach($arrayFields_crud as $col => $info){
                    if((strpos($info[1], "hidden")===false) && !in_array($info[3], ["file", "image"])){?>
                        <?if(!in_array($info[3], ["checkbox", "radio"])){?>
                            $("<?echo $info[0]?>[name='<?echo $col?><?if((strpos($info[1], 'multiple') !== false)){echo '[]'; }?>']").val("")
                        <?}?>
                <?}}?>

                $("input[name='actionId']").val("")
                
            }

          });
	    })
	</script>
				
		
								
</html>