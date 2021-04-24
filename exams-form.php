<?php
require_once "config/init.php";
require_once "inc/checklogin.php";

$_title = "Exams Form || " . SITE_TITLE;

$exam = new Exams;
$schedule = new Schedule;

$act = "add";
if(isset($_GET['id']) && !empty($_GET['id'])){
    $act = "update";
    $id = (int)$_GET['id'];
    if($id <= 0){
        redirect("exams.php", 'error', "Invalid exam Id");
    }

    $exam_info = $exam->getRowByRowId($id);
    if(!$exam_info){
        redirect("exams.php", 'error', "Exam does not exists.");
    }

    $schedule_info = $schedule->getScheduleByExamId($id);

}
require_once "inc/header.php";

?>
<div id="wrapper">

    <?php require_once 'inc/sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <?php require_once 'inc/top-nav.php'; ?>
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <?Php flash(); ?>
                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">
                    Exams Form

                </h1>


                <hr>

                <div class="row">
                    <div class="col-12">
                        <form action="process/exam.php" method="post" class="form">
                            <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">Title:</label>
                                <div class="col-sm-12 col-md-9">
                                    <input type="text" name="exam_title" required placeholder="Enter Exam Title" class="form-control form-control-sm" value="<?php echo @$exam_info[0]->title; ?>">
                                </div>
                            </div>

                        <?php if(!isset($exam_info)) { ?>
                            <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">Class Select:</label>
                                <div class="col-sm-12 col-md-9">
                                    <select name="class_id" required id="class_id" class="form-control form-control-sm">
                                        <option value="" selected disabled>-- Select Any One--</option>
                                        <?php 
                                            $classes = new Classes;
                                            $all_classes = $classes->selectAllRows();
                                            if($all_classes){
                                                foreach($all_classes as $class_data){
                                            ?>
                                            <option value="<?php echo $class_data->id?>" <?php 
                                                    echo (isset($exam_info) && $exam_info[0]->class_id == $class_data->id) ? 'selected' : ''  
                                            ?>>
                                                <?php echo $class_data->class_name;?>
                                            </option>
                                            <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">Section Select:</label>
                                <div class="col-sm-12 col-md-9">
                                    <select name="section_id" id="section_id" class="form-control form-control-sm">                                        
                                        <option value="" disabled selected>--Select Class First--</option>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>

                            <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">Start Date:</label>
                                <div class="col-sm-12 col-md-9">
                                    <input type="date" name="start_date" required placeholder="Enter start date" class="form-control form-control-sm" value="<?php echo @$exam_info[0]->start_date; ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">End Date:</label>
                                <div class="col-sm-12 col-md-9">
                                    <input type="date" name="end_date" required placeholder="Enter end date" class="form-control form-control-sm" value="<?php echo @$exam_info[0]->end_date; ?>">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="" class="col-3">Status: </label>
                                <div class="col-9">
                                    <select name="status" id="status" class="form-control form-control-sm" required>
                                        <option value="upcoming" <?php 
                                                    echo (isset($exam_info) && $exam_info[0]->status == 'upcoming') ? 'selected' : ''  
                                            ?>>Upcoming</option>
                                        <option value="ended" <?php 
                                                    echo (isset($exam_info) && $exam_info[0]->status == 'ended') ? 'selected' : ''  
                                            ?>>Ended</option>
                                    </select>
                                </div>
                            </div>
                        

                            <hr>

                            <div class="row">
                                <div class="col-12">
                                    <h4 class="text-left">Subject Schedule</h4>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                    <div class="col-3">
                                            <h6 class="text-center">Subject Name</h6>
                                        </div>
                                        <div class="col-3">
                                            <h6 class="text-center">Exam Date</h6>
                                        </div>
                                        <div class="col-3">
                                            <h6 class="text-center">Full Mark</h6>
                                        </div>
                                        <div class="col-3">
                                            <h6 class="text-center">Pass Mark</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div id="exam_schedule">
                               <?php 
                                if(isset($schedule_info)){
                                    foreach($schedule_info as $exam_schedule){
                                    ?>
                                    <div class="form-group row">
                                        <label for="" class="col-3"><?php echo $exam_schedule->title;?></label>
                                        <div class="col-3">
                                            <input type="date" name="exam_schedule[<?php echo $exam_schedule->subject_id;?>][date]" class="form-control form-control-sm" value="<?php echo $exam_schedule->exam_date;?>" required>
                                        </div>
                                        <div class="col-3">
                                            <input type="number" min="1" max="100" name="exam_schedule[<?php echo $exam_schedule->subject_id;?>][full_mark]" class="form-control form-control-sm" value="<?php echo $exam_schedule->full_mark;?>" required>
                                        </div>
                                        <div class="col-3">
                                            <input type="number" min="1" max="100" name="exam_schedule[<?php echo $exam_schedule->subject_id;?>][pass_mark]" class="form-control form-control-sm" value="<?php echo $exam_schedule->pass_mark;?>" required>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                } else {
                                ?>
                                <div class="row">
                                    <div class="col-12">
                                        <p class="alert-info">Select Class First</p>
                                    </div>
                                </div>
                                <?php
                                }
                               ?>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-3"></label>
                                <div class="col-9">
                                <input type="hidden" name="exam_id" value="<?php echo @$exam_info[0]->id;?>">
                                    <button class="btn btn-danger btn-sm" type="reset">
                                        <i class="fa fa-times"></i> Reset
                                    </button>
                                    <button class="btn btn-success btn-sm" type="submit">
                                        <i class="fa fa-paper-plane"></i> Submit
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <?php require_once 'inc/copy.php'; ?>

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<?php
require_once "inc/footer.php";

?>
<script>
    $('#class_id').change(function(e){
        var class_id = $(this).val();
        var section_id = "<?php echo (isset($exam_info)) ? $exam_info[0]->section_id : '' ?>";
        var subject_id = "";

        
        $.ajax({
            url: "process/api.php",
            type: "get",
            data: {
                class_id: class_id,
                act: "get-section-with-subject"
            },
            success: function(response){
                if(typeof(response) != "object"){
                    response = JSON.parse(response);
                }

                var opt_html = "<option value='' selected>--Select Any One --</option>";
                var sub_html = "";
                if(response.status){
                    
                    $.each(response.data.sections_data, function(key, value){
                        opt_html += "<option value='"+value.id+"'";     // <option value='1'

                        if(value.id == section_id){
                            opt_html += " selected ";                     // <option value='1' selected>
                        }  
                        opt_html += ">Section "+value.section_name+"</option>";     //<option value='1' selected>Section I</option>
                    });
                    
                    <?php 
                        if(!isset($schedule_info) || empty($schedule_info)){
                    ?>

                    if(response.data.subjects){
                        $.each(response.data.subjects, function(sub_key, sub_value){
                            sub_html += "<div class='form-group row'>";
                            sub_html += "<label class='col-sm-3'>"+sub_value.title+"</label>";
                            sub_html += "<div class='col-sm-3'>";
                            sub_html += "<input class='form-control form-control-sm' name='exam_schedule["+sub_value.id+"][date]' required placeholder='Enter Exam date' type='date'>";
                            sub_html += "</div>";
                            sub_html += "<div class='col-sm-3'>";
                            sub_html += "<input class='form-control form-control-sm' name='exam_schedule["+sub_value.id+"][full_mark]' required placeholder='Enter Full mark' min='1' type='number'>";
                            sub_html += "</div>";
                            sub_html += "<div class='col-sm-3'>";
                            sub_html += "<input class='form-control form-control-sm' name='exam_schedule["+sub_value.id+"][pass_mark]' required placeholder='Enter Pass Mark' min='1' type='number'>";
                            sub_html += "</div>";
                            sub_html += "</div>";
                        });
                    }

                <?php } ?>
                }

                $('#section_id').html(opt_html);
                <?php 
                        if(!isset($schedule_info) || empty($schedule_info)){
                    ?>
                $('#exam_schedule').html(sub_html);
                        <?php } ?>
            }
        });
    });
    <?php 
        if($act == 'update'){
    ?>
        $('#class_id').change();
    <?php
        }
    ?>
</script>