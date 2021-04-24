<?php
require_once "config/init.php";
require_once "inc/checklogin.php";

$_title = "Subjects Form || " . SITE_TITLE;

$subject = new Subjects;

$act = "add";
if(isset($_GET['id']) && !empty($_GET['id'])){
    $act = "update";
    $id = (int)$_GET['id'];
    if($id <= 0){
        redirect("subjects.php", 'error', "Invalid subject Id");
    }

    $subject_info = $subject->getRowByRowId($id);
    if(!$subject_info){
        redirect("subjects.php", 'error', "Subject does not exists.");
    }
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
                    Subjects Form

                </h1>


                <hr>

                <div class="row">
                    <div class="col-12">
                        <form action="process/subject.php" method="post" class="form">
                            <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">Title:</label>
                                <div class="col-sm-12 col-md-9">
                                    <input type="text" name="subject_title" required placeholder="Enter Subject Title" class="form-control form-control-sm" value="<?php echo @$subject_info[0]->title; ?>">
                                </div>
                            </div>
                        <?php 
                            if($act == "add"){
                        ?>
                            <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">Subject Code:</label>
                                <div class="col-sm-12 col-md-9">
                                    <input type="text" name="subject_code" required placeholder="Enter Subject code" class="form-control form-control-sm">
                                </div>
                            </div>
                            <?php } ?>

                            <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">Subject Description:</label>
                                <div class="col-sm-12 col-md-9">
                                    <textarea name="description" id="description" rows="5" class="form-control form-control-sm" style="resize: none;"><?php echo @$subject_info[0]->description; ?></textarea>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">Class Select:</label>
                                <div class="col-sm-12 col-md-9">
                                    <select name="class_id" required id="class_id" class="form-control form-control-sm">
                                        <?php 
                                            $classes = new Classes;
                                            $all_classes = $classes->selectAllRows();
                                            if($all_classes){
                                                foreach($all_classes as $class_data){
                                            ?>
                                            <option value="<?php echo $class_data->id?>" <?php 
                                                    echo (isset($subject_info) && $subject_info[0]->class_id == $class_data->id) ? 'selected' : ''  
                                            ?>>
                                                <?php echo ucwords($class_data->class_name);?>
                                            </option>
                                            <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">Subject Teacher:</label>
                                <div class="col-sm-12 col-md-9">
                                    <select name="teacher_id" id="teacher_id" class="form-control form-control-sm">
                                        <option value="" selected disabled>-- Select Any One --</option>
                                        <?php 
                                            $users = new User;
                                            $all_users = $users->getUserByType('teacher');
                                            if($all_users){
                                                foreach($all_users as $user_data){
                                            ?>
                                            <option value="<?php echo $user_data->id?>" <?php 
                                                    echo (isset($subject_info) && $subject_info[0]->teacher_id == $user_data->id) ? 'selected' : ''  
                                            ?>>
                                                <?php echo ucwords($user_data->name);?>
                                            </option>
                                            <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-3">Status: </label>
                                <div class="col-9">
                                    <select name="status" id="status" class="form-control form-control-sm" required>
                                        <option value="active" <?php 
                                                    echo (isset($subject_info) && $subject_info[0]->status == 'active') ? 'selected' : ''  
                                            ?>>Active</option>
                                        <option value="inactive" <?php 
                                                    echo (isset($subject_info) && $subject_info[0]->status == 'inactive') ? 'selected' : ''  
                                            ?>>In-Active</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-3"></label>
                                <div class="col-9">
                                <input type="hidden" name="subject_id" value="<?php echo @$subject_info[0]->id;?>">
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