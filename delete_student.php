<div id="delete_student<?php echo $row["student_id"]; ?>" class="w3-modal" style="z-index:2020;">
                <div class="w3-modal-content w3-animate-top w3-card-4" style="width:40%">
                    <header class="w3-container" style="background:#343a40; color:white;">
                        <span onclick="document.getElementById('delete_student<?php echo $row["student_id"]; ?>').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                        <h2 align="center">Are you sure???</h2>
                    </header>
                    <form id="delete_student_form<?php echo $row["student_id"]; ?>" role="form" method="POST">
                        <div class="card-body">
                            <div class="col-md-12" id="delete_error_section<?php echo $row["student_id"]; ?>"></div>
                            <div class="col-md-12" align="center">
                                <input type='hidden' name='admission_details_id' id="admission_details_id<?php echo $row["student_id"]; ?>" value='<?php echo $row["admission_details_id"]; ?>' />
                                <input type='hidden' name='action' id="action_delete<?php echo $row["student_id"]; ?>" value='delete_get_student' />
                                <div class="col-md-12" id="delete_loader_section<?php echo $row["student_id"]; ?>"></div>
                                <button type="button" id="delete_student_button<?php echo $row["student_id"]; ?>" class="btn btn-danger">Move To Trash</button>
                                <button type="button" onclick="document.getElementById('delete_get_student<?php echo $row["student_id"]; ?>').style.display='none'" class="btn btn-primary">Cancel</button>
                            </div>

                        </div>
                    </form>
                    <script>
                        $(function() {

                            $('#delete_student_button<?php echo $row["admission_details_id"]; ?>').click(function() {
                                $('#delete_loader_section<?php echo $row["admission_details_id"]; ?>').append('<center id = "delete_loading"><img width="50px" src = "images/ajax-loader.gif" alt="Currently loading" /><br/><br/></center>');
                                $('#delete_student_button<?php echo $row["admission_details_id"]; ?>').prop('disabled', true);
                                var action = $("#action_delete<?php echo $row["admission_details_id"]; ?>").val();
                                var admission_details_id = $("#admission_details_id<?php echo $row["admission_details_id"]; ?>").val();
                                var dataString = 'action=' + action + '&admission_details_id=' + admission_details_id;

                                $.ajax({
                                    url: 'include/controller.php',
                                    type: 'POST',
                                    data: dataString,
                                    success: function(result) {
                                        $('#delete_response').remove();
                                        if (result == "error") {
                                            $('#delete_error_section<?php echo $row["admission_details_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                        }
                                        if (result == "empty") {
                                            $('#delete_error_section<?php echo $row["admission_details_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something went wrong please try again!!!</div></div>');
                                        }
                                        if (result == "success") {
                                            $('#delete_error_section<?php echo $row["admission_details_id"]; ?>').append('<div id = "delete_response"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> Student Delete successfully!!!</div></div>');
                                            showDeletedData();

                                            function showDeletedData() {
                                                $.ajax({
                                                    url: 'include/view.php?action=get_student',
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
                                        $('#delete_student_button<?php echo $row["admission_details_id"]; ?>').prop('disabled', false);
                                    }

                                });
                            });

                        });

                    </script>
                </div>
            </div>