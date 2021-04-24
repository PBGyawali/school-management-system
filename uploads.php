<?php
  require_once "config/init.php";
 //require_once "inc/checklogin.php";

  $_title = "Upload || ".SITE_TITLE;
  require_once "inc/header.php";  
  $section = new Section;
  $class = new Classes;
?>
  <div id="wrapper">
    <?php require_once 'inc/sidebar.php';?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <?php require_once 'inc/top-nav.php';?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <?Php flash();?>          
        </div>
        <!-- /.container-fluid -->   
        
        <div class="col-12 p-0">    
<div class="d-flex flex-column" >  
<span id="message"></span>
<!-- Tabs navs -->
<ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
     <li class="nav-item" role="presentation">
    <a class="nav-link active tabbutton" data-id="ex1-tabs-0" data-mdb-toggle="tab" href="#ex1-tabs-0" role="tab" aria-controls="ex1-tabs-0" aria-selected="true">File Settings</a>
  </li>   
</ul>
<!-- Tabs navs -->

<!-- Tabs content -->
<div class="tab-content" id="ex1-content">
  </div><!-- end of 1st tab div content -->
  
  <div class="tab-pane show" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
  <form method="post" class="website setting_form" id="website_setting_form" enctype="multipart/form-data" action="process/upload.php">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Upload Section</h6>
                </div>
                <div clas="col text-right" >
                    <button type="submit" name="website_edit_button" id="website_edit_button" class="btn btn-primary btn-sm edit_button"><i class="fas fa-edit"></i> Save</button>
                    &nbsp;&nbsp;
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- form left side -->
                <div class="col-md-6">                    
                    <div class="form-group">
                        <label>Uploader Message</label>
                        <textarea  name="uploader_message" id="uploader_message" value="" required class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Class</label>
                        <select name="class_id" id="class_id" class="form-control" required>
                        <option value=""selected disabled hidden>Select Class</option>
                        <?php echo $class->load_class_list()?>                      	
                        </select>                        
                    </div>  
                </div>
                
                 <!-- form right side -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>File name</label>
                        <input type="text" name="file_description" id="website_tagline"value=""  class="form-control" />
                    </div>

                    <div class="form-group">
                        <label>Section</label>
                        <select name="section_id" id="section_id" class="form-control" required>
                        <option value=""selected disabled hidden>Select Section</option>
                        <?php echo $section->load_grade_list()?>                      	
                        </select>                        
                    </div>                    
                    <div class="form-group">
                    <label>Select File</label><br />
                    <input type="file" name="file" id="file"  class=" file_upload" data-allowed_file='[<?php echo '"' . implode('","', ALLOWED_FILES) . '"'?>]' data-upload_time="later"/>
                    <br />
                    <span class="text-muted">Only <?php  echo join(' and ', array_filter(array_merge(array(join(', ', array_slice(ALLOWED_FILES, 0, -1))), array_slice(ALLOWED_FILES, -1)), 'strlen'));?> extensions are supported</span><br />
                   </div>
                </div>
            </div>
        </div>
    </div>
</form>
  </div><!-- end of 2nd tab div content -->
  </div>
<!-- last two div above belongs to Tabs content -->
</body>
</html>

      </div>
      <!-- End of Main Content -->
        <?php require_once 'inc/copy.php'; ?>
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>  
<?php   require_once "inc/footer.php";?>