<?php
    require_once "config/init.php";
    require_once "inc/checklogin.php";

    $_title = "Exams List || " . SITE_TITLE;
    require_once "inc/header.php";


    $exam = new Exams;
    $result = new Result;

    $act = "add";
    if(isset($_GET['exam_id']) && !empty($_GET['exam_id'])){
        $act = "update";
        $id = (int)$_GET['exam_id'];
        if($id <= 0){
            redirect("exams.php", 'error', "Invalid exam Id");
        }

        $exam_info = $exam->getRowByRowId($id);
        if(!$exam_info){
            redirect("exams.php", 'error', "Exam does not exists.");
        }

        $result_info = $result->getResultByExamId($id);

    }

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
                    Result of Exam
                </h1>


                <hr>

                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered table-hover table-sm">
                            <thead class="thead-dark">
                                <th>Name</th>
                                <th>Class</th>
                                <th>Total</th>
                                <th>Percentage</th>
                                <th>Result</th>
                                <th>View</th>
                            </thead>
                            <tbody>
                                <?php 
                                    if($result_info){
                                        foreach($result_info as $row){
                                            $student = new Students;
                                            $student_info = $student->getStudentInfoById($row->student_id);
                                            
                                    ?>
                                    <tr class="<?php echo $row->result == 'fail' ? 'table-danger' : 'table-success';?>">
                                        <td>
                                            <?php
                                                echo $student_info[0]->name;
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $student_info[0]->class_name;?>
                                            <?php echo ($student_info[0]->section_name) ? "Section ".$student_info[0]->section_name : ''; ?>
                                        </td>
                                        <td>
                                            <?php echo $row->total_obtained_score?>
                                        </td>
                                        <td>
                                            <?php echo $row->percentage?>
                                        </td>
                                        <td>
                                            <?php echo $row->result?>
                                        </td>
                                        <td>
                                            <a href="student-score.php?exam_id=<?php echo $row->exam_id?>&sid=<?php echo $row->student_id?>" class="btn btn-circle btn-sm btn-warning">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    }
                                
                                ?>
                            </tbody>
                        </table>
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