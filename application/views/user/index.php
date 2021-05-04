<div class="container-fluid mt-2">
  <?= $this->session->flashdata('message'); ?>
  <div class="row mb-1">
	<div class="col-md-8">
	  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#form_create"><i class="fa fa-plus-square"></i>
	    &nbsp;&nbsp;Tambah
	  </button>
	</div>
	<div class="col-md-4 pull-right">
	  <div class="input-group">
		<input id="searching" class="form-control form-control-sm" placeholder="Cari Data ...">
		<div class="input-group-prepend">
		  <div class="">
			<select id="pagelength" class="form-control form-control-sm" readonly>
			  <option value="10">10</option>
			  <option value="25">25</option>
			  <option value="50">50</option>
			  <option value="100">100</option>
			</select>
		  </div>
		</div>
	  </div>
	</div>
  </div>
  <table id="table_data" class="table table-bordered table-striped" width="100.1%">
	<thead class="bg-info">
      <tr>
		<th>#</th>
        <th>Nama Lengkap</th>
        <th>Username</th>
        <th>Alamat</th>
        <th>No. Telepon</th>
        <th>Level</th>
        <th>Action</th>
      </tr>
    </thead>
  </table>
</div>

<div class="modal fade" id="form_create" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Pengguna Baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
	  <form action="<?= base_url('user/create'); ?>" method="POST">
      <div class="modal-body">
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Nama Lengkap</label>
		  <div class="col-md-8">
		    <input name="user_fullname" class="form-control form-control-sm">
		  </div>
		</div>
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Username <span class="text-danger">*</span></label>
		  <div class="col-md-8">
		    <input name="user_name" class="form-control form-control-sm" required>
		  </div>
		</div>
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Password <span class="text-danger">*</span></label>
		  <div class="col-md-8">
		    <input  name="user_password" class="form-control form-control-sm" required>
		  </div>
		</div>
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Alamat</label>
		  <div class="col-md-8">
		    <input name="user_address" class="form-control form-control-sm">
		  </div>
		</div>
		<div class="form-row">
		  <label class="col-md-4 col-form-label">No. Telepon</label>
		  <div class="col-md-8">
		    <input name="user_phone" class="form-control form-control-sm">
		  </div>
		</div>
		<div class="form-row">
		  <label class="col-md-4 col-form-label">Level <span class="text-danger">*</span></label>
		  <div class="col-md-8">
		    <select name="user_level" class="form-control form-control-sm" required>
			  <option selected disabled>--- Pilih Level ---</option>
			  <?php foreach($level AS $value){ ?>
				<option value="<?php echo $value['level_id'] ?>"><?php echo $value['level_desc'] ?></option>
			  <?php } ?>
			</select>
		  </div>
		</div>
	  </div>
      <div class="modal-footer">
	    <img src="<?= base_url('assets/'); ?>dist/img/AdminLTELogo__.jpeg" class="mr-auto" width="115">
        <button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary btn-sm btn-form">Simpan</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<div class="modal fade" id="user_update" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Edit Data Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
	  <form action="<?= base_url('user/update'); ?>" method="POST">
      <div class="modal-body">
		<input type="hidden" name="user_id">
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Nama Lengkap</label>
		  <div class="col-md-8">
		    <input name="user_fullname" class="form-control form-control-sm">
		  </div>
		</div>
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Username <span class="text-danger">*</span></label>
		  <div class="col-md-8">
		    <input name="user_name" class="form-control form-control-sm" required>
		  </div>
		</div>
		<div class="form-row mb-1">
		  <label class="col-md-4 col-form-label">Alamat</label>
		  <div class="col-md-8">
		    <input name="user_address" class="form-control form-control-sm">
		  </div>
		</div>
		<div class="form-row">
		  <label class="col-md-4 col-form-label">No. Telepon</label>
		  <div class="col-md-8">
		    <input name="user_phone" class="form-control form-control-sm">
		  </div>
		</div>
		<div class="form-row">
		  <label class="col-md-4 col-form-label">Level <span class="text-danger">*</span></label>
		  <div class="col-md-8">
		    <select name="user_level" class="form-control form-control-sm" required>
			  <option selected disabled>--- Pilih Level ---</option>
			  <?php foreach($level AS $value){ ?>
				<option value="<?php echo $value['level_id'] ?>"><?php echo $value['level_desc'] ?></option>
			  <?php } ?>
			</select>
		  </div>
		</div>
	  </div>
      <div class="modal-footer">
		<img src="<?= base_url('assets/'); ?>dist/img/AdminLTELogo__.jpeg" class="mr-auto" width="115">
        <button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm btn-form">Update</button>
      </div>
	  </form>
    </div>
  </div>
</div>
