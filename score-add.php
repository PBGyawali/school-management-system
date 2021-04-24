<?php
require_once "config/init.php";
require_once "inc/checklogin.php";

$_title = "Student Score Form || " . SITE_TITLE;

$student = new Students;
$exam = new Exams;

$act = "add";
if(isset($_GET['sid']) && !empty($_GET['sid'])){
    $act = "update";
    $sid = (int)$_GET['sid'];
    if($sid <= 0){
        redirect("students.php", 'error', "Invalid exam Id");
    }

    $student_info = $student->getStudentInfoById($sid);
    if(!$student_info){
        redirect("students.php", 'error', "Student does not exists.");
    }

    $exams = $exam->getCompletedExamsByClass($student_info[0]->class_id, $student_info[0]->section_id);
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
                    Student Score Form
                </h1>

                <hr>

                <div class="row">
                    <div class="col-12">
                        <form action="process/score.php" method="post" class="form">
                            
                            <div class="row">
                                <div class="col-6">
                                    <img src="<?php echo UPLOAD_URL.'/student/'.$student_info[0]->image ?>" alt="" class="img img-fluid img-thumbnail">
                                </div>

                                <div class="col-6">
                                    <h4 class="text-center">Student Information</h4>
                                    <hr>
                                    <div class="row">
                                        <span class="col-3">
                                            <strong>Name: </strong>
                                        </span>
                                        <span class="col-9">
                                            <?php echo $student_info[0]->name;?>
                                        </span>
                                    </div>

                                    <div class="row">
                                        <span class="col-3">
                                            <strong>Email: </strong>
                                        </span>
                                        <span class="col-9">
                                            <?php echo $student_info[0]->email;?>
                                        </span>
                                    </div>

                                    <div class="row">
                                        <span class="col-3">
                                            <strong>Class: </strong>
                                        </span>
                                        <span class="col-9">
                                            <?php echo $student_info[0]->class_name;?>
                                        </span>
                                    </div>

                                    <div class="row">
                                        <span class="col-3">
                                            <strong>Section: </strong>
                                        </span>
                                        <span class="col-9">
                                            <?php echo $student_info[0]->section_name;?>
                                        </span>
                                    </div>

                                    <div class="row">
                                        <span class="col-3">
                                            <strong>Roll No.: </strong>
                                        </span>
                                        <span class="col-9">
                                            <?php echo $student_info[0]->roll_no;?>
                                        </span>
                                    </div>

                                    <hr>

                                    <div class="row">
                                        <div class="col-3">
                                            <strong>Select Exam: </strong>
                                        </div>
                                        <div class="col-9">
                                            <select name="exam_id" id="exam_id" required class="form-control form-control-sm">
                                                <option value="" disabled selected>--Select Any One--</option>
                                                <?php 
                                                    if($exams){
                                                        foreach($exams as $exam_data){
                                                        ?>
                                                        <option value="<?php echo $exam_data->id;?>">
                                                            <?php echo $exam_data->title;?>
                                                        </option>
                                                        <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <strong class="text-left">Subjects</strong>
                                </div>
                                <div class="col-3">
                                    <strong class="text-left">Full Mark</strong>
                                </div>
                                <div class="col-3">
                                    <strong class="text-left">Pass Mark</strong>
                                </div>
                                <div class="col-3">
                                    <strong class="text-left">Obtained Mark</strong>
                                </div>
                                <input type="hidden" name="student_id" value="<?php echo $student_info[0]->id;?>">
                            </div>
                            <hr>

                            <div id="subs">

                            </div>

                            <div id="button">

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
    $('#exam_id').change(function(){
        var exam_id = $(this).val();
        var student_id = "<?php echo $sid; ?>";

        getExamsSubs(exam_id, student_id);
    });


    function getExamsSubs(exam_id, student_id){
        $.ajax({
            url: "process/api.php",
            type: "post",
            data: {
                act: "get-score-by-exam",
                exam_id: exam_id,
                student_id: student_id
            },
            success: function(response){
                if(typeof(response) != "object"){
                    response = JSON.parse(response);
                }


                if(response.status){
                    var html_div = "";
                        
                    $.each(response.data, function(key, value) {
                        html_div += "<div class='form-group row'>";
                        html_div += "<label class='col-md-3'>"+value.title+"</label>";
                        html_div += "<span class='col-md-3'>"+value.full_mark+"</span>";
                        html_div += "<span class='col-md-3'>"+value.pass_mark+"</span>";
                        html_div += "<div class='col-md-3'>";
                        html_div += "<input type='number' name='score["+value.subject_id+"]' value='"+value.obtained_score+"' class='form-control-sm form-control' min='0' max='"+value.full_mark+"' value=''>";
                        html_div += "</div>";
                        html_div += "</div>";
                    });
                    $('#subs').html(html_div);

                    var button_html = "<hr>";
                    button_html += "<div class='form-group row' id=''>";
                    button_html += "<div class='col-12'>";
                    button_html += "<button class='btn btn-success btn-sm btn-block'>";
                    button_html += "<i class='fa fa-paper-plane'></i> Add Score";
                    button_html += "</button>";
                    button_html += "</div>";
                    button_html += "</div>";
                    $('#button').html(button_html);

                }

            }
        });
    }
</script>