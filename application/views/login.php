<!DOCTYPE html>
<html lang="en">

<body>

  <div class="content blog">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <?php
          echo $this->session->flashdata('notif'); ?>
          <div class="sidebar">
            <div class="widget">
              <h4>Login</h4>
              <form role='form' id="form_daftar" method='post' action='<?php echo base_url(); ?>Auth/login'>
                <div class="form-group">
                  <input type="text" name='nama' class="form-control" id="name" placeholder="Enter Name">
                </div>
                <div class="form-group">
                  <input type="password" name='pass' class="form-control" placeholder="Enter Password">
                </div>

                <button type="submit" class="btn btn-danger">Submit</button>
                <button type="reset" class="btn btn-default">Reset</button>
              </form>

            </div> <!-- widget end -->
          </div> <!-- sidebar end -->
        </div> <!-- kolom 8 end -->



      </div> <!-- row end -->
    </div> <!-- container end -->
  </div> <!-- konten blog -->

  <!-- Scroll to top -->
  <span class="totop"><a href="#"><i class="fa fa-chevron-up"></i></a></span>


</body>

</html>