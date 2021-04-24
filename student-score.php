<?php
require_once "config/init.php";
require_once "inc/checklogin.php";

$_title = "Student Score Form || " . SITE_TITLE;

$student = new Students;
$score = new Scores;
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
    $exam = $exam->getRowByRowId($_GET['exam_id']);
    $score_data = $score->getScroeByStudentIdAndExam($_GET['exam_id'], $sid);

    
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
                    Exam result of <em><?php echo $exam[0]->title;?></em>
                </h1>

                <hr>

                <div class="row">
                    <div class="col-12">
                            <div class="row">
                                <div class="col-12">
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

                                </div>
                            </div>

                            <hr>
                            <div class="row ">
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
                            </div>
                            <hr>

                            <div id="subs">
                            <?php 
                                foreach($score_data as $key => $scores){
                                    $schedule = new Schedule;
                                    $sub_info = $schedule->getSubjectByexamId($scores->exam_id, $scores->subject_id);
                            ?>
                            <div class="row">
                                <p class="col-3">
                                    <strong><?php echo $scores->title;?></strong>
                                </p>
                                <p class="col-3">
                                    <strong><?php echo $sub_info[0]->full_mark;?></strong>
                                </p>
                                <p class="col-3">
                                    <strong><?php echo $sub_info[0]->full_mark;?></strong>
                                </p>
                                <p class="col-3">
                                <?php echo $scores->obtained_score;?>
                                </p>
                            </div>
                            <hr>
                            <?php
                                }
                            ?>
                            </div>

                            <div id="button">

                            </div>


                       
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