<?php 
    $page_no = "11";
    $page_no_inside = "11_5";
    include "include/authentication.php";
    $visible = md5("visible");	
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NETAJI SUBHAS PUBLIC SCHOOL | Enter Marks</title>
    <link rel="icon" href="images/logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
    </script>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        table,
        th,
        td {
            border-collapse: collapse;
        }

    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php include 'include/navbar.php'; ?>
        <?php include 'include/aside.php'; ?>

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Enter Marks</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Enter Marks</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">                                             
                            <div class="card-body" style="margin-top: 0px;">
							 <form role="form" method="POST" id="add_marks_form">
                                <div class="row">                                                                     
										<?php 										 									
									    if (isset($_GET['class_id']) && ($_GET['section_id']) && ($_GET['subject_id']) && ($_GET['exam_id'])) {																				 
							$sql = "SELECT * FROM `tbl_subjects` WHERE class_id = '".$_GET['class_id']."' && section_id = '".$_GET['section_id']."' && subject_id = '".$_GET['subject_id']."'";
										$row = $con->query($sql);
										$row_course = $row->fetch_assoc();  
                                        
										//get class name
                                        $sql_class = "SELECT * FROM `tbl_class`
                                                       WHERE `status` = '$visible' && `course_id` = '".$row_course["class_id"]."'";
                                        $result_class = $con->query($sql_class);
                                        $row_class_name = $result_class->fetch_assoc();
										
										//get section name
										$sql_sec = "SELECT * FROM `tbl_section`
                                                       WHERE `section_id` = '".$row_course["section_id"]."'";
                                        $result_sec = $con->query($sql_sec);
                                        $row_sec = $result_sec->fetch_assoc(); 


                                        //get exam name
                                        $sql_exam = "SELECT * FROM `tbl_exam`
                                                       WHERE `exam_id` = '".$_GET['exam_id']."'";
                                        $result_ex = $con->query($sql_exam);
                                        $row_ex = $result_ex->fetch_assoc(); 

															
										?> 

                                  <div class="col-12">
                                        <div class="form-group">                                        
                                            <input type="hidden" value="<?php echo $row_ex["exam_id"] ?>" name="exam_id"> 
                                            <label>Exam : <?php echo $row_ex["exam_name"] ?></label>                                         
                                        </div>
                                    </div>


									<div class="col-12">
                                        <div class="form-group">										
                                            <input type="hidden" value="<?php echo $row_course["class_id"] ?>" name="class_id">	
											<label>Class : <?php echo $row_class_name["course_name"] ?></label>											
                                        </div>
                                    </div>
									
									<div class="col-12">
                                        <div class="form-group">
										  <input type="hidden" value="<?php echo $row_sec["section_id"] ?>" name="section_id">
                                            <label>Section : <?php echo $row_sec["section_name"] ?></label>                                           
                                        </div>
                                    </div>								
                                   
									<div class="col-12">
                                        <div class="form-group">
										 <input type="hidden" value="<?php echo $row_course["subject_id"] ?>" name="subject_id">
                                            <label>Subject Name : <?php echo $row_course["subject_name"] ?></label>                                           
                                        </div>
                                    </div>  
									<?php } ?> 									
                                </div>
                                          
							<table id="example1" class="table table-bordered table-striped" style="overflow-x:auto;">
        						<thead>
        							<tr>
        								<th width="10%">S.No</th>
        								<th width="10%">Reg.No</th>
        								<th width="10%">Roll No</th>																
        								<th width="20%">Marks Obtained</th>								
        							</tr>
        						</thead>				
        						<tbody>         
        								<?php 
        								$s_no = 1; //Serial Number
        								$sql = "SELECT * FROM `tbl_student` 							
        								where `tbl_student`.`course_id` = '".$row_course["class_id"]."' && `tbl_student`.`section_id` = '".$row_sec["section_id"]."'";

        								$row = $con->query($sql);
        								if ($row) {
        	                             if($row->num_rows > 0){
        								while($rows= $row->fetch_assoc()){ 
                                             // $roll_no =  $rows["roll_no"];

                                       //get marks
                                        $sql_mark = "SELECT * FROM `tbl_marks`
                                                       WHERE `reg_no` = '".$rows["reg_no"]."' &&  `subject_id` = '".$_GET['subject_id']."'";
                                        $result_mark = $con->query($sql_mark);
                                        $row_mark = $result_mark->fetch_assoc(); 
        								?>
        										<tr>
        											<td><?php echo $s_no; ?></td>  																					
        											<td><input type="text" value="<?php echo $rows["reg_no"] ?>" name="reg_no[]" class="form-control" readonly></td>  
        											<td><input type="text" value="<?php echo $rows["roll_no"] ?>" name="" class="form-control" readonly></td>  
        											
        											<td><input type="number" name="external_marks[]" value="<?php echo $row_mark["external_marks"] ?>" class="form-control numberbox" min="0" max="100"></td>											
        										</tr>
        									<?php 
        									$s_no++;
        								}
        								 }
                 //                         else { 
        								 
        								
        								 // }
        								}								 
        							?>
        							
        							<tr>
        							<td height="40" colspan="8" valign="middle" align="center" class="narmal">		
        							<input type='hidden' name='action' value='add_marks' />
        							  <div class="col-md-12" id="loader_section"></div>
        							  <button type="button" id="add_marks_button" class="btn btn-primary">Add</button>
        							  <button type="reset" class="btn btn-danger">Reset</button> 
        							</td>
        						  </tr>
        						</tbody>				
                              </table>
                   <div class="col-12" id="error_section"></div>				 
				 </form>
				  </div>    
                        </div>
                    </div>

                </div>

        </div>
        </section>
        <!-- /.content -->
    </div>

    <?php include 'include/footer.php'; ?>

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <!-- date-range-picker -->
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- Page script -->
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            });

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            });

        });

    </script>
   <script>
    $(function() {

        $('#add_marks_button').click(function() {
            $('#loader_section').append('<center id = "loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /></center>');
            $('#add_marks_button').prop('disabled', true);
            $.ajax({
                url: 'include/controller.php',
                type: 'POST',
                data: $('#add_marks_form').serializeArray(),
                success: function(result) {
                    $('#response').remove();
                    if(result == "courseempty")
                        $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Please First Add!!!</div></div>');
                    if(result == "empty")
                        $('#error_section').append('<div id = "response"><div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-exclamation-triangle"></i>  Please fill out all required fields!!!</div></div>');
                    if(result == "error")
                        $('#error_section').append('<div id = "response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                    if(result == "success"){
                        $('#add_marks_form')[0].reset();
                        $('#error_section').append('<div id = "response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Added successfully!!!</div></div>');
                    }
                    if(result == "update"){
                        $('#add_marks_form')[0].reset();
                        $('#error_section').append('<div id = "response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Updated successfully!!!</div></div>');
                    }
                    console.log(result);
                    $('#loading').fadeOut(500, function() {
                        $(this).remove();
                    });
                    $('#add_marks_button').prop('disabled', false);
                }

            });
        });

    });

    
    $('.numberbox').keyup(function(){
  if ($(this).val() > 100){
    alert("You have entered more than 100");
    $(this).val('100');
  }
});

</script>
</body>

</html>