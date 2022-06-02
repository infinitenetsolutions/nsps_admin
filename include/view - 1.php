<?php
    //Starting Session
    if(empty(session_start()))
        session_start();
    //DataBase Connectivity
    include "config.php";
    include "db_class.php";

     // echo $superadmin;
   //$superauthority = $_SESSION["superauthority"];
   //$permissionVal=explode('||',$autority[$page_no]); 

 //print_r($permissionVal);

    
    // Setting Time Zone in India Standard Timing
    $random_number = rand(111111,999999); // Random Number
    $s_no = 1; //Serial Number
    $visible = md5("visible");
    $trash = md5("trash");
    date_default_timezone_set("Asia/Calcutta");
    $date_variable_today_month_year_with_timing = date("d M, Y. h:i A");
    //All File Directries Start
    $university_logos_dir = "../images/university_logos";
    $admission_profile_image_dir = "images/student_images";
    $certificates = "images/student_certificates";
    //Creating Object NSUNIV
    $objectDefault = new DBEVAL();
    $objectDefault->sql = "";
    $objectDefault->hostName = "";
    $objectDefault->password = "";
    $objectDefault->dbName =   "";
   // $objectDefault->new_db("localhost", "root", "", "nsucms_demo_nsuniv");
    //Creating Object NSUCMS
    $objectSecond = new DBEVAL();
    $objectSecond->sql = "";
    $objectSecond->hostName = "";
    $objectSecond->userName = "";
    $objectSecond->password = "";
    $objectSecond->dbName =   "";
    //$objectSecond->new_db("localhost", "root", "", "nsucms_cms");
    //All File Directries End
    if(isset($_GET["action"])){
    //Action Section Start
        /* ---------- All Admin(Backend) View Codes Start ---------- */
        
        /* ---------- All View Codes Start ------------------------- */
       

          //Branches Start
          if($_GET["action"] == "get_branches"){
            ?>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Branch Name</th>
                            <th>Branch Address</th>
                            <th>Branch Phone No</th>
                            <th class="project-actions text-center">Action </th>
                        </tr>
                    </thead>
                    <tbody>         
                       <?php 
                            $sql = "SELECT * FROM `tbl_branch`
                                    ORDER BY `id` ASC";
                            $result = $con->query($sql);
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()){
                                ?>
                                    <tr>
                                        <td><?php echo $s_no; ?></td>
                                        <td><?php echo $row["branch_name"] ?></td>
                                        <td><?php echo $row["branch_address"] ?></td>
                                        <td><?php echo $row["branch_phone"] ?></td>
                                        <td class="project-actions text-center">
                                            <button class="btn btn-info btn-sm" onclick="document.getElementById('edit_branches<?php echo $row['id']; ?>').style.display='block'">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="document.getElementById('delete_branches<?php echo $row['id']; ?>').style.display='block'">
                                                <i class="fas fa-trash">
                                                </i>
                                                Delete
                                            </button>
                                        </td>
                                        
        <!-- Branches Edit Section Start -->
        <div id="edit_branches<?php echo $row["id"]; ?>" class="w3-modal" style="z-index:2020;">
            <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                <header class="w3-container" style="background:#343a40; color:white;">
                    <span onclick="document.getElementById('edit_branches<?php echo $row['id']; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                    <h2 align="center">Edit Branch</h2>
                </header>
                <form id="edit_branch_form<?php echo $row["id"]; ?>" role="form" method="POST">
                    <div class="card-body">
                        <div class="col-md-12" id="edit_error_section<?php echo $row["id"]; ?>"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Branch Name</label>
                                    <input type="text" name="edit_branch_name" id="edit_branch_name<?php echo $row["id"]; ?>" class="form-control" value="<?php echo $row["branch_name"]; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Branch Address</label>
                                    <input type="text" name="edit_branch_address" id="edit_branch_address<?php echo $row["id"]; ?>" class="form-control" value="<?php echo $row["branch_address"]; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Branch Phone No</label>
                                    <input type="text" name="edit_branch_phone" id="edit_branch_phone<?php echo $row["id"]; ?>" class="form-control" value="<?php echo $row["branch_phone"]; ?>">
                                </div>

                                <div class="form-group">
                                </div>
                            </div>

                        </div>
                        <input type='hidden' name='edit_branch_id' id="edit_branch_id<?php echo $row["id"]; ?>" value='<?php echo $row["id"]; ?>' />
                        <input type='hidden' name='action' id="action<?php echo $row["id"]; ?>" value='edit_branches' />
                        <div class="col-md-12" id="edit_loader_section<?php echo $row["id"]; ?>"></div>
                        <button type="button" id="edit_branch_button<?php echo $row["id"]; ?>" class="btn btn-primary">Update</button>
                        <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                    </div>
                </form>
                <script>
                    $(function() {

                            $('#edit_branch_button<?php echo $row["id"]; ?>').click(function() {
                            $('#edit_loader_section<?php echo $row["id"]; ?>').append('<center id = "edit_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
                            //$('#edit_branch_button<?php echo $row["id"]; ?>').prop('disabled', true);
                            var action = $("#action<?php echo $row["id"]; ?>").val();   
                            var edit_branch_id = $("#edit_branch_id<?php echo $row["branch_id"]; ?>").val();
                            var edit_branch_name = $("#edit_branch_name<?php echo $row["branch_id"]; ?>").val();
                            var dataString = 'action='+ action + '&edit_branch_id='+ edit_branch_id + '&edit_branch_name='+ edit_branch_name;

                            $.ajax({
                                url: 'include/controller.php',
                                type: 'POST',
                                data: dataString,
                                success: function(result) {
                                    $('#edit_response').remove();
                                    if(result == "exsits"){
                                        $('#edit_error_section<?php echo $row["id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i> This Branch have already exsits!!!</div></div>');
                                    }
                                    if(result == "error"){
                                        $('#edit_error_section<?php echo $row["id"]; ?>').append('<div id = "edit_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                    }
                                    if(result == "empty"){
                                        $('#edit_error_section<?php echo $row["id"]; ?>').append('<div id = "edit_response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i>  Please fill out Branch Name!!!</div></div>');
                                    }
                                    if(result == "success"){
                                        $('#edit_error_section<?php echo $row["id"]; ?>').append('<div id = "edit_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Branch Updated successfully!!!</div></div>');
                                        showUpdatedData();
                                        function showUpdatedData(){
                                            $.ajax({
                                                url: 'include/view.php?action=get_branches',
                                                type: 'GET',
                                                success: function(result) {
                                                    $("#data_table").html(result);
                                                }
                                            });
                                        }
                                    }
                                    $('#edit_loading').fadeOut(500, function() {
                                        $(this).remove();
                                    });
                                    // $('#edit_branches_button<?php echo $row["id"]; ?>').prop('disabled', false);
                                }

                            });
                        });

                    });

                </script>
            </div>
        </div>
        <!-- Branches Edit Section End -->
                            
                                        <!-- Branches delete Section Start -->
                                        <div id="delete_branches<?php echo $row["id"]; ?>" class="w3-modal" style="z-index:2020;">
                                            <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                                                <header class="w3-container" style="background:#343a40; color:white;">
                                                    <span onclick="document.getElementById('delete_branches<?php echo $row['id']; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                                    <h2 align="center">Are you sure???</h2>
                                                </header>
                                                <form id="delete_branch_form<?php echo $row["id"]; ?>" role="form" method="POST">
                                                    <div class="card-body">
                                                        <div class="col-md-12" id="delete_error_section<?php echo $row["id"]; ?>"></div>
                                                        <div class="col-md-12" align="center">
                                                            <input type='hidden' name='delete_branch_id' id="delete_branch_id<?php echo $row["id"]; ?>" value='<?php echo $row["id"]; ?>' />
                                                            <input type='hidden' name='action' id="action_delete<?php echo $row["id"]; ?>" value='delete_branches' />
                                                            <div class="col-md-12" id="delete_loader_section<?php echo $row["id"]; ?>"></div>
                                                            <button type="button" id="delete_branch_button<?php echo $row["id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                                            <button type="button" onclick="document.getElementById('delete_branches<?php echo $row['id']; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                                                        </div>
                                                        
                                                        <!--<button type="reset" class="btn btn-danger">Reset</button>-->
                                                    </div>
                                                </form>
                                                <script>
                                                    $(function() {
    
                                                            $('#delete_branch_button<?php echo $row["id"]; ?>').click(function() {
                                                            $('#delete_loader_section<?php echo $row["id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                                            $('#delete_branch_button<?php echo $row["id"]; ?>').prop('disabled', true);
                                                            var action = $("#action_delete<?php echo $row["id"]; ?>").val();
                                                            var delete_branch_id = $("#delete_branch_id<?php echo $row["id"]; ?>").val();
                                                            var dataString = 'action='+ action + '&delete_branch_id='+ delete_branch_id;
    
                                                            $.ajax({
                                                                url: 'include/controller.php',
                                                                type: 'POST',
                                                                data: dataString,
                                                                success: function(result) {
                                                                    $('#delete_response').remove();
                                                                    if(result == "error"){
                                                                        $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                    }
                                                                    if(result == "empty"){
                                                                        $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                                                    }
                                                                    if(result == "success"){
                                                                        $('#delete_error_section<?php echo $row["id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Course Delete successfully!!!</div></div>');
                                                                        showDeletedData();
                                                                        function showDeletedData(){
                                                                            $.ajax({
                                                                                url: 'include/view.php?action=get_branches',
                                                                                type: 'GET',
                                                                                success: function(result) {
                                                                                    $("#data_table").html(result);
                                                                                }
                                                                            });
                                                                        }
                                                                    }
                                                                    $('#delete_loading').fadeOut(500, function() {
                                                                        $(this).remove();
                                                                    });
                                                                    $('#delete_branch_button<?php echo $row["id"]; ?>').prop('disabled', false);
                                                                }
    
                                                            });
                                                        });
    
                                                    });
    
                                                </script>
                                            </div>
                                        </div>
                                        <!-- Branches delete Section End -->
                                    </tr>
                                <?php 
                                    $s_no++;
                                }
                            } else
                                echo '
                                    <div class="alert alert-warning alert-dismissible">
                                        <i class="icon fas fa-exclamation-triangle"></i>  No data available now!!!
                                    </div>';
                        ?>
                    </tbody>
                </table>
                <script>
                    $(function() {
                        $("#example1").DataTable();
                        $('#example2').DataTable({
                            "paging": true,
                            "lengthChange": false,
                            "searching": false,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                        });
                    });
    
                </script>
            <?php
            }
            //Branches End

      
    
 
       
        ?>
           
           
        <?php
        
        //All Deleted Lists End
        /* ---------- All View Codes End ------------------------- */
        /* ---------- All Fetch Codes Start ---------------------- */
       

    

      
                                 
       
        /* ---------- All Admin(Backend) View Codes End ---------- */
    //Action Section End   
    }
?>