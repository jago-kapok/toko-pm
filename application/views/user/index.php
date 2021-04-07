<div class="container-fluid mt-2">
  <?= $this->session->flashdata('message'); ?>
  <div class="row mb-1">
	<div class="col-md-8">
	  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#create_user"><i class="fa fa-plus-square"></i>
	    &nbsp;&nbsp;Insert User
	  </button>
	  <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#import_user"><i class="fa fa-file-import"></i>
	    &nbsp;&nbsp;Import Data
	  </button>
	</div>
	<div class="col-md-4 pull-right">
	  <div class="input-group">
		<input id="searching" class="form-control form-control-sm" placeholder="Search Data ...">
		<span class="input-group-append">
		  <a href="<?= base_url('user/export') ?>" class="btn btn-success btn-sm"><i class="fa fa-file-download"></i>
			&nbsp;&nbsp;Export Data
		  </a>
		</span>
	  </div>
	</div>
  </div>
  <table id="example" class="table table-striped">
	<thead class="bg-info">
      <tr>
		<th>#</th>
        <th>Full Name</th>
        <th>Username</th>
        <th>Password</th>
        <th>Email</th>
        <th>Level</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $a = 1;
        foreach($user as $u) { ?>
        <tr>
          <th scope="row"><?= $a++; ?></th>
          <td><?= $u['nama_user']; ?></td>
          <td><?= $u['username']; ?></td>
          <td><?= md5($u['username']); ?></td>
          <td><?= $u['email_user']; ?></td>
		  <?php if($u['id_level'] == 1) : ?>
			<td>Admin</td>
		  <?php else : ?>
			<td>Teknisi</td>
		  <?php endif; ?>
          <td>
            <a href="javascript:void(0)" class="badge badge-info p-1" title="Edit Data" data-toggle="modal" data-target="#update_user"
			  data-id_user="<?= $u['id_user']; ?>"
			  data-nama_user="<?= $u['nama_user']; ?>"
			  data-username="<?= $u['username']; ?>"
			  data-password="<?= $u['password']; ?>"
			  data-email_user="<?= $u['email_user']; ?>"
			  data-telp_user="<?= $u['telp_user']; ?>"
			  data-id_level="<?= $u['id_level']; ?>"
			>
			  <i class="fas fa-edit"></i>
		    </a>
            <a href="<?= base_url('user/delete/').$u['id_user']; ?>" class="badge badge-danger p-1" title="Delete Data" onclick="return confirm('Are you sure to delete this ?')">
			  <i class="fas fa-trash"></i>
		    </a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<div class="modal fade" id="create_user" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Insert New User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
	  <form action="<?= base_url('user/create'); ?>" method="POST">
      <div class="modal-body">
        <div class="form-group">
		  <label>Full Name</label>
		  <input name="nama_user" class="form-control form-control-sm">
		</div>
		<div class="form-row">
		  <div class="form-group col-md-6">
			<label>Username <span class="text-danger">*</span></label>
			<input name="username" class="form-control form-control-sm" required>
		  </div>
		  <div class="form-group col-md-6">
			<label>Password <span class="text-danger">*</span></label>
			<input type="password" name="password" class="form-control form-control-sm" required>
		  </div>
		</div>
		<div class="form-row">
		  <div class="form-group col-md-6">
			<label>Email Address</label>
			<input type="email" name="email_user" class="form-control form-control-sm">
		  </div>
		  <div class="form-group col-md-6">
			<label>Phone Number</label>
			<input type="tel" name="telp_user" class="form-control form-control-sm">
		  </div>
		</div>
		<div class="form-group">
		  <label>Level</label>
		  <select name="id_level" class="form-control form-control-sm" required>
			<option value="1">Admin</option>
			<option value="2">Teknisi</option>
		  </select>
		</div>
	  </div>
      <div class="modal-footer">
		<img src="<?= base_url('assets/'); ?>dist/img/AdminLTELogo__.png" class="mr-auto" width="115">
        <button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm btn-form">Save</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<div class="modal fade" id="update_user" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Edit Data User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
	  <form action="<?= base_url('user/update'); ?>" method="POST">
      <div class="modal-body">
        <div class="form-group">
		  <label>Full Name</label>
		  <input type="hidden" name="id_user" class="form-control form-control-sm">
		  <input name="nama_user" class="form-control form-control-sm">
		</div>
		<div class="form-row">
		  <div class="form-group col-md-6">
			<label>Username <span class="text-danger">*</span></label>
			<input name="username" class="form-control form-control-sm" required>
		  </div>
		  <div class="form-group col-md-6">
			<label>Password <span class="text-danger">*</span></label>
			<input type="password" name="password" class="form-control form-control-sm" required>
		  </div>
		</div>
		<div class="form-row">
		  <div class="form-group col-md-6">
			<label>Email Address</label>
			<input type="email" name="email_user" class="form-control form-control-sm">
		  </div>
		  <div class="form-group col-md-6">
			<label>Phone Number</label>
			<input type="tel" name="telp_user" class="form-control form-control-sm">
		  </div>
		</div>
		<div class="form-group">
		  <label>Level</label>
		  <select name="id_level" class="form-control form-control-sm" required>
			<option value="1">Admin</option>
			<option value="2">Teknisi</option>
		  </select>
		</div>
	  </div>
      <div class="modal-footer">
		<img src="<?= base_url('assets/'); ?>dist/img/AdminLTELogo__.png" class="mr-auto" width="115">
        <button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm btn-form">Update</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<div class="modal fade" id="import_user" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Import Data User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
	  <form action="<?= base_url('user/import'); ?>" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="form-group">
		  <label>Choose Excel File</label>
		  <input type="file" name="excel_file" class="form-control form-control-sm" required>
		</div>
	  </div>
      <div class="modal-footer">
		<img src="<?= base_url('assets/'); ?>dist/img/AdminLTELogo__.png" class="mr-auto" width="115">
        <button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm btn-form">Process</button>
      </div>
	  </form>
    </div>
  </div>
</div>