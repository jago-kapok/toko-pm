<div class="container-fluid">
  <div class="container" style="margin-top:8%">
    <div class="col-md-4 offset-md-4">
	  <div class="card">
        <div class="card-header" style="background-color:; padding:30px">
          <h3 class="card-title" style="float:none">
		    <center>
			  <img src="<?= base_url('assets/'); ?>dist/img/AdminLTELogo__.png" class="mr-auto" width="115">
			</center>
		  </h3>
        </div>
        <form action="auth/login" method="POST">
          <div class="card-body">
			<?= $this->session->flashdata('message'); ?>
            <div class="form-group">
              <label class="text-secondary">Username</label>
              <input type="text" name="username" class="form-control" placeholder="Enter Username">
            </div>
            <div class="form-group">
              <label class="text-secondary">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Enter Password">
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>