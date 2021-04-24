<?php
require_once "config/init.php";
require_once "inc/checklogin.php";

$_title = "Subjects List || " . SITE_TITLE;
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
                    Subjects List

                    <a href="subject-form.php" class="addmodal btn btn-success btn-sm float-right">
                        <i class="fa fa-plus"></i> Add Subjects
                    </a>
                </h1>


                <hr>

                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered table-hover table-sm" id="table">
                            <thead class="thead-dark">
                                <th>Title</th>
                                <th>Subject Code</th>
                                <th>Class</th>
                                <th>Teacher</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php 
                                    $subject = new Subjects;
                                    $all_data = $subject->getClassInfo();
                                    if($all_data){
                                        foreach($all_data as $key => $row){
                                        ?>
                                        <tr>
                                            <td><?php echo ucwords($row->title);?></td>
                                            <td><?php echo $row->subject_code;?></td>
                                            <td><?php echo ucwords($row->class_name);?></td>
                                            <td><?php echo ucwords($row->name);?></td>
                                            <td>
                                                <span class="badge badge-<?php echo (($row->status) == 'active') ? 'success' : 'danger';?>">
                                                    <?php echo ucfirst($row->status);?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="subject-form.php?id=<?php echo $row->id?>" class="btn btn-primary btn-circle btn-sm">
                                                    <i class="fa fa-pen"></i>
                                                </a>
                                                <a href="process/subject.php?id=<?php echo $row->id;?>" onclick="return confirm('Are you sure you want to delete this subject?')" class="btn btn-danger btn-circle btn-sm">
                                                    <i class="fa fa-times"></i>
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


<!-- Modal -->
<div class="modal fade" id="classmodal" tabindex="-1" role="dialog" aria-labelledby="classmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="classmodalLabel">Class Add Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="process/Subjects.php" method="post" class="form" id="class_form">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="" class="col-3">Class Title: </label>
                        <div class="col-9">
                            <input type="text" class="form-control from-control-sm" id="class_name" name="class_name" required placeholder="Enter Class Name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-3">Class Detail: </label>
                        <div class="col-9">
                            <textarea name="detail" id="detail" class="form-control form-control-sm" rows="4" style="resize: none;"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-3">Status: </label>
                        <div class="col-9">
                            <select name="status" id="status" class="form-control form-control-sm" required>
                                <option value="active">Active</option>
                                <option value="inactive">In-Active</option>
                            </select>
                        </div>
                    </div>
                
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="class_id" name="class_id" value="">
                    <button type="reset" class="btn btn-danger btn-sm" data-dismiss="modal">
                        <i class="fa fa-times"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-paper-plane"></i> Store Class
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="sectionmodal" tabindex="-1" role="dialog" aria-labelledby="sectionmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sectionmodalLabel">Section Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="process/section.php" method="post" class="form" id="section_form">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="" class="col-3">Section Title: </label>
                        <div class="col-9">
                            <input type="text" class="form-control from-control-sm" id="section_name" name="section_name" required placeholder="Enter Class Name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="section_id" name="section_id" value="">
                    <input type="hidden" id="section_class_id" name="class_id" value="">
                    <button type="reset" class="btn btn-danger btn-sm" data-dismiss="modal">
                        <i class="fa fa-times"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-paper-plane"></i> Store Section
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once "inc/footer.php";

?>