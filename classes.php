<?php
require_once "config/init.php";
require_once "inc/checklogin.php";
$_title = "Classes List || " . SITE_TITLE;
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
                    Classes List
                    <a href="javascript:;" class="addmodal btn btn-success btn-sm float-right">
                        <i class="fa fa-plus"></i> Add Class
                    </a>
                </h1>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered table-hover table-sm" id="table">
                            <thead class="thead-dark">
                                <th>Title</th>
                                <th>Section</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php 
                                    $class = new Classes;
                                    $all_data = $class->selectAllRows();                                    
                                    if($all_data){
                                        foreach($all_data as $key => $row){
                                        ?>
                                        <tr>
                                            <td><?php echo $row->class_name?></td>
                                            <td>
                                                <?php 
                                                    $section= New Section();
                                                    $get_sections = $section->getSectionByClass($row->id);
                                                    if($get_sections){
                                                        ?>
                                                        <span class="btn btn-link show-section">
                                                            View Section
                                                        </span>
                                                        <ul class="sect-list collapse">
                                                        <?php
                                                        foreach($get_sections as $section_info){
                                                            ?>
                                                            <li class="section-name">
                                                                <?php echo $section_info->section_name?>

                                                                <a href="javascript:;" data-class_id="<?php echo $row->id;?>" data-data='{"id":<?php echo $section_info->id?>, "section_name": "<?php echo $section_info->section_name?>"}' class="btn btn-primary btn-circle btn-xs ml-3 section_edit" >
                                                                    <i class="fa fa-pen"></i>
                                                                </a>
                                                                <a href="process/section.php?id=<?php echo $section_info->id?>" onclick="return confirm('Are you sure you want to delete this section?');" class="btn btn-danger btn-circle btn-xs" >
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </li>
                                                            <?php
                                                        }
                                                        ?>
                                                        </ul>
                                                        <?php
                                                    }
                                                ?> 
                                            </td>
                                            <td><?php echo $row->detail;?></td>
                                            <td>
                                                <span class="badge badge-<?php echo ($row->status == 'active') ? 'success' : 'danger';?>">
                                                    <?php echo ucfirst($row->status);?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="javascript:;" data-class_id="<?php echo $row->id;?>" class="btn btn-info btn-sm btn-circle sectionadd" title="Add Section">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <a href="javascript:;" class="btn btn-primary btn-sm btn-circle editclass" title="Edit Class" data-id="<?php echo $row->id;?>">
                                                    <i class="fa fa-pen"></i>
                                                </a>
                                                <a href="process/classes.php?id=<?php echo $row->id?>" onclick="return confirm('Are you sure you want to delete this class?');" class="btn btn-danger btn-sm btn-circle" title="Delete Class">
                                                    <i class="fa fa-trash"></i>
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
            <form action="process/classes.php" method="post" class="form" id="class_form">
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
<script>
    $('.addmodal').click(function(){
        $('#class_name').val(null);
        $('#detail').val(null);
        $('#status').val('active');
        $('#class_id').val(null);

        $('#classmodal').modal('show');
    });

    $('.editclass').click(function(e){
        e.preventDefault();
        var edit_id = $(this).data('id');           // data-id="123"
        $.ajax({
            url: "./process/api.php",
            type: "post",
            data:{
                class_id: edit_id,
                act: "get-class"
            },
            success:function(response){
                if(typeof(response) != "object"){
                    response = JSON.parse(response);
                }

                if(response.status){
                    $('#class_name').val(response.data[0].class_name);
                    $('#detail').val(response.data[0].detail);
                    $('#status').val(response.data[0].status);
                    $('#class_id').val(response.data[0].id);

                    $('#classmodal').modal('show');
                }
            }
        });
    });

    $('.sectionadd').click(function(e){
        e.preventDefault();
        $('#section_title').val('');
        $('#section_id').val('');

        $('#section_class_id').val($(this).data('class_id'));
        $('#sectionmodal').modal('show');
    });

    $('.show-section').click(function(){
        $(this).parent().find('ul').toggleClass('collapse');
    });

    $('.section_edit').click(function(e){
        e.preventDefault();
        var data = $(this).data('data');
        if(typeof(data) != "object"){
            data = JSON.parse(data);
        }
        $('#section_name').val(data.section_name);
        $('#section_id').val(data.id);
        $('#section_class_id').val($(this).data('class_id'));
        $('#sectionmodal').modal('show');
    });
</script>