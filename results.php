<?php
    require_once "config/init.php";
    require_once "inc/checklogin.php";

    $_title = "Exams List || " . SITE_TITLE;
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
                    Exams List
                </h1>


                <hr>

                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered table-hover table-sm" id="table">
                            <thead class="thead-dark">
                                <th>Exam</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php 
                                    $exams = new Exams;
                                    $all_data = $exams->getAllCompletedExams();
                                    
                                    if($all_data){
                                        foreach($all_data as $key => $row){
                                        ?>
                                        <tr>
                                            <td><?php echo $row->title;?></td>        
                                            <td><?php echo $row->class_name;?></td>        
                                            <td>
                                                <?php echo ($row->section_name) ? "Section ". $row->section_name : ''?>
                                            </td>        
                                            <td><?php echo $row->start_date;?></td>        
                                            <td><?php echo $row->end_date;?></td>        
                                            <td>
                                                <?php 
                                                    $today_date = strtotime(date("Y-m-d"));
                                                    $start_date = strtotime($row->start_date);
                                                    $end_date = strtotime($row->end_date);
                                                    if($today_date < $start_date){
                                                        //echo "Upcoming";
                                                    } else if($today_date >= $start_date && $start_date <= $end_date){
                                                        //echo "Running";
                                                    } else {
                                                        //echo "Ended";
                                                    }
                                                ?>


                                                <span class="badge badge-<?php echo (($row->status) == 'upcoming') ? 'success' : 'danger';?>">
                                                    <?php echo ucfirst($row->status);?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="view-result.php?exam_id=<?php echo $row->id;?>" class="btn btn-sm btn-warning btn-circle">
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