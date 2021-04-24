<?php
require_once "config/init.php";
require_once "inc/checklogin.php";

$_title = "Teachers Form || " . SITE_TITLE;

$teacher = new Teachers;
$user = new User;

$act = "add";
if(isset($_GET['id']) && !empty($_GET['id'])){
    $act = "update";
    $id = (int)$_GET['id'];
    if($id <= 0){
        redirect("teachers.php", 'error', "Invalid teacher Id");
    }

    $teacher_info = $teacher->getRowByRowId($id);
    if(!$teacher_info){
        redirect("teachers.php", 'error', "Subject does not exists.");
    }

    $user_info = $user->getRowByRowId($teacher_info[0]->user_id);
    
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
                    Teachers Form

                </h1>


                <hr>

                <div class="row">
                    <div class="col-12">
                        <form action="process/teacher.php" method="post" class="form" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">Name:</label>
                                <div class="col-sm-12 col-md-9">
                                    <input type="text" name="name" required placeholder="Enter Name" class="form-control form-control-sm" value="<?php echo @$user_info[0]->name; ?>">
                                </div>
                            </div>

                            <?php 
                                if($act == 'add'){
                            ?>
                            <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">Email:</label>
                                <div class="col-sm-12 col-md-9">
                                    <input type="email" class="form-control form-control-sm" reuqired placeholder="Enter Student email" id="teacher_email" value="<?php echo @$user_info[0]->email;?>" name="email">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">Password:</label>
                                <div class="col-sm-12 col-md-9">
                                    <input type="password" class="form-control form-control-sm" reuqired placeholder="Enter Student password" id="user_password" name="password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">Re-Password:</label>
                                <div class="col-sm-12 col-md-9">
                                    <input type="password" class="form-control form-control-sm" reuqired placeholder="Enter Student password" id="teacher_re_password" name="re_password">
                                </div>
                            </div>
                                <?php } ?>

                                <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">Experience, In Years:</label>
                                <div class="col-sm-12 col-md-9">
                                    <input type="number" name="experience" required placeholder="Enter Experience in years" class="form-control form-control-sm" value="<?php echo @$teacher_info[0]->experience; ?>" min="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">Education:</label>
                                <div class="col-sm-12 col-md-9">
                                    <select name="education" required id="education" class="form-control form-control-sm">
                                        <option value="see" <?php 
                                                    echo (isset($teacher_info) && $teacher_info[0]->education == 'see') ? 'selected' : ''  
                                            ?>>SEE</option>
                                        <option value="+2"  <?php 
                                                    echo (isset($teacher_info) && $teacher_info[0]->education == '+2') ? 'selected' : ''  
                                            ?>>+2</option>
                                        <option value="bachelors"  <?php 
                                                    echo (isset($teacher_info) && $teacher_info[0]->education == 'bachelors') ? 'selected' : ''  
                                            ?>>Bachelors</option>
                                        <option value="masters" <?php 
                                                    echo (isset($teacher_info) && $teacher_info[0]->education == 'masters') ? 'selected' : ''  
                                            ?>>Masters Degree</option>
                                        <option value="mphil" <?php 
                                                    echo (isset($teacher_info) && $teacher_info[0]->education == 'mphil') ? 'selected' : ''  
                                            ?>>M. Phil</option>
                                        <option value="phd" <?php 
                                                    echo (isset($teacher_info) && $teacher_info[0]->education == 'phd') ? 'selected' : ''  
                                            ?>>PHD</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">Class Select:</label>
                                <div class="col-sm-12 col-md-9">
                                    <select name="class_id" required id="class_id" class="form-control form-control-sm">
                                        <option value="" disabled selected>--Select Any One--</option>
                                        <?php 
                                            $classes = new Classes;
                                            $all_classes = $classes->selectAllRows();
                                            if($all_classes){
                                                foreach($all_classes as $class_data){
                                            ?>
                                            <option value="<?php echo $class_data->id?>" <?php 
                                                    echo (isset($teacher_info) && $teacher_info[0]->class_id == $class_data->id) ? 'selected' : ''  
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


                            <div class="form-group row">
                                <label for="" class="col-sm-12 col-md-3">Subject Select:</label>
                                <div class="col-sm-12 col-md-9">
                                    <select name="subject_id" id="subject_id" class="form-control form-control-sm">                                        
                                        <option value="" disabled selected>--Select Class First--</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-3">Status: </label>
                                <div class="col-9">
                                    <select name="status" id="status" class="form-control form-control-sm" required>
                                        <option value="active" <?php 
                                                    echo (isset($user_info) && $user_info[0]->status == 'active') ? 'selected' : ''  
                                            ?>>Active</option>
                                        <option value="inactive" <?php 
                                                    echo (isset($user_info) && $user_info[0]->status == 'inactive') ? 'selected' : ''  
                                            ?>>In-Active</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-3">Image: </label>
                                <div class="col-4">
                                    <input type="file" name="image" id="image" accept="image/*">
                                </div>
                                <div class="col-2">
                                    <?php 
                                        if(isset($user_info) && !empty($user_info[0]->image) && file_exists(UPLOAD_DIR.'/teacher/'.$user_info[0]->image)){
                                        ?>
                                        <img src="<?php echo UPLOAD_URL.'/teacher/'.$user_info[0]->image;?>" alt="" class="img img-fluid img-thumbnail">
                                        <?php
                                        }
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-3"></label>
                                <div class="col-9">
                                    <input type="hidden" name="user_id" value="<?php echo @$teacher_info[0]->user_id;?>">
                                    <input type="hidden" name="teacher_id" value="<?php echo @$teacher_info[0]->id;?>">
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
        var section_id = "<?php echo (isset($teacher_info)) ? $teacher_info[0]->section_id : '' ?>";
        var subject_id = "<?php echo (isset($teacher_info)) ? $teacher_info[0]->subject_id : '' ?>";

        
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
                var sub_html = "<option value='' selected>--Select Any One --</option>";
                if(response.status){
                    
                    $.each(response.data.sections_data, function(key, value){
                        opt_html += "<option value='"+value.id+"'";     // <option value='1'

                        if(value.id == section_id){
                            opt_html += " selected ";                     // <option value='1' selected>
                        }  
                        opt_html += ">Section "+value.section_name+"</option>";     //<option value='1' selected>Section I</option>
                    });

                    if(response.data.subjects){
                        $.each(response.data.subjects, function(sub_key, sub_value){
                            sub_html += "<option value='"+sub_value.id+"'";     // <option value='1'

                            if(sub_value.id == subject_id){
                                sub_html += " selected ";                     // <option value='1' selected>
                            }  
                            sub_html += ">"+sub_value.title+"</option>"; 
                        })
                    }
                }

                $('#section_id').html(opt_html);
                $('#subject_id').html(sub_html);
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