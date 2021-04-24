<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-gradient-primary  topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline small">
                    <?php echo ucwords($_SESSION['name']); ?>
                </span>
                <?php
                if (isset($_SESSION['image']) && !empty($_SESSION['image']) && file_exists(UPLOAD_DIR . '/user/' . $_SESSION['image'])) {
                    // file exists
                    $img_url = UPLOAD_URL . "/user/" . $_SESSION['image'];
                } else {
                    $img_url = IMAGES_URL . '/deafult-user.jpg';
                }
                ?>
                <img class="img-profile rounded-circle" src="<?php echo $img_url; ?>">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" id="update-profile">
                    <i class="fas fa-user fa-sm fa-fw mr-2 "></i> Profile </a>
                <a class="dropdown-item" href="#" id="password_change">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 "></i> Change Password</a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 "></i> Logout </a>
            </div>
        </li>
    </ul>
</nav>
<!-- End of Topbar -->
<!-- Modal -->
<div class="modal fade" id="profileupdate" tabindex="-1" role="dialog" aria-labelledby="profileupdaeLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileupdaeLabel">Update Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="process/user.php" method="post" enctype="multipart/form-data" class="form">
                <div class="modal-body">                    
                    <div class="form-group row">
                        <label for="" class="col-3">Name: </label>
                        <div class="col-9">
                            <input type="text" class="form-control form-control-sm" id="name" name="name" required value="<?php echo $_SESSION['name'];?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-3">Image: </label>
                        <div class="col-4">
                            <input type="file" name="image" accept="image/*" onchange="readURL(this, 'thumb')">
                        </div>
                        <div class="col-3">
                            <img src="<?php echo $img_url;?>" alt="" id="thumb" class="img img-fluid img-thumbnail">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                        Close
                    </button>
                    <button type="subit" class="btn btn-success">
                        <i class="fa fa-paper-plane"></i>
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="change_pwd" tabindex="-1" role="dialog" aria-labelledby="profileupdaeLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileupdaeLabel">Update Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="process/chagepassword.php" method="post" class="form">
                <div class="modal-body">                    
                    <div class="form-group row">
                        <label for="" class="col-3">Password: </label>
                        <div class="col-9">
                            <input type="password" class="form-control form-control-sm" id="password" name="password" required >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-3">Re-type Password: </label>
                        <div class="col-9">
                            <input type="password" class="form-control form-control-sm" id="re_password" name="re_password" required >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                        Close
                    </button>
                    <button type="subit" class="btn btn-success">
                        <i class="fa fa-paper-plane"></i>
                        Update password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>