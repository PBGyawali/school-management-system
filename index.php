<?php
require_once 'config/init.php';

// If a user is already logged in
if(isset($_SESSION['token']) && !empty($_SESSION['token'])){
    redirect("dashboard.php",'info', "You are already logged in");
}

if(isset($_COOKIE['_au']) && !empty($_COOKIE['_au'])){
  redirect("dashboard.php",'info', "Welcome back to Admin panel!");
}


$_title = "Login || " . SITE_TITLE;
require "inc/header.php"; ?>

<div class="container">

  <!-- Outer Row -->
  <div class="row justify-content-center">

    <div class="col-sm-12 col-md-6">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg-12">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                </div>
                
                <?php flash(); ?>

                <form class="user" method="post" action="process/login.php">
                  
                  <div class="form-group">
                    <input type="email" required name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                  </div>
                  
                  <div class="form-group">
                    <input type="password" required name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                  </div>
                  
                  <div class="form-group">
                    <div class="custom-control custom-checkbox small">
                      <input type="checkbox" name="remember_me" value="1" class="custom-control-input" id="customCheck">
                      <label class="custom-control-label" for="customCheck">Remember Me</label>
                    </div>
                  </div>
                  
                  <button type="submit" class="btn btn-primary btn-user btn-block">
                    Login
                  </button>

                </form>

                <hr>
                <div class="text-center">
                  <a class="small" href="forgot-password.html">Forgot Password?</a>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>

<?php require 'inc/footer.php'; ?>