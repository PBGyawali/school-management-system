<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>  
    <!--
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>-->
    
    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo JS_URL;?>/jquery.min.js"></script>
    <script src="<?php echo JS_URL;?>/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo JS_URL;?>/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo JS_URL;?>/sb-admin-2.min.js"></script>
    <script src="<?php echo PLUGINS_URL;?>/datatables/datatables.min.js"></script>
    <script>
        $('#table').DataTable();

        //setTimeout(function(){
          //  $('.alert').slideUp();
        //}, 3000);


        $('#update-profile').click(function(e){
            e.preventDefault();
            $('#profileupdate').modal('show');
        });

        $('#password_change').click(function(e){
          e.preventDefault();
          $('#change_pwd').modal('show');
        });

        function readURL(input, image_id) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#'+image_id)
                      .attr('src', e.target.result);
              };
              reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</body>

</html>