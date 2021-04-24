<?php
    require_once "config/init.php";
    require_once "inc/checklogin.php";

    $_title = "Students List || " . SITE_TITLE;
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
                    Students List

                    <a href="students-form.php" class="addmodal btn btn-success btn-sm float-right">
                        <i class="fa fa-plus"></i> Add Students
                    </a>
                </h1>


                <hr>

                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered table-hover table-sm" id="table">
                            <thead class="thead-dark">
                                <th>Name</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Roll No.</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php 
                                    $students = new Students;
                                    $all_data = $students->getAllStudents();
                                    
                                    if($all_data){
                                        foreach($all_data as $key => $row){
                                        ?>
                                        <tr>
                                            <td><?php echo $row->user_name;?></td>        
                                            <td><?php echo $row->class_name;?></td>        
                                            <td>
                                                <?php 
                                                    echo ($row->section_name) ? "Section ".$row->section_name : '';
                                                ?>
                                            </td>        
                                            <td><?php echo $row->roll_no;?></td>        
                                            <td>
                                                <span class="badge badge-<?php echo (($row->status) == 'active') ? 'success' : 'danger';?>">
                                                    <?php echo ucfirst($row->status);?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="students-form.php?id=<?php echo $row->id?>" class="btn btn-primary btn-circle btn-sm">
                                                    <i class="fa fa-pen"></i>
                                                </a>
                                                <a href="process/student.php?id=<?php echo $row->id;?>" onclick="return confirm('Are you sure you want to delete this students?')" class="btn btn-danger btn-circle btn-sm">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                                <a href="score-add.php?sid=<?php echo $row->id;?>" class="btn btn-sm btn-circle btn-info">
                                                    <i class="fa fa-plus"></i>
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