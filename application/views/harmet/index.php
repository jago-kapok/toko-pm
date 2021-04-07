<div class="container-fluid mt-2">
  <?= $this->session->flashdata('message'); ?>
  <div class="row mb-1">
	<div class="col-md-8">
	  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#create_harmet"><i class="fa fa-plus-square"></i>
	    &nbsp;&nbsp;Insert Harmet
	  </button>
	</div>
	<div class="col-md-4 pull-right">
	  <div class="input-group">
		<input id="searching" class="form-control form-control-sm" placeholder="Search Data ...">
		<span class="input-group-append">
		  <a href="<?= base_url('harmet/export') ?>" class="btn btn-success btn-sm"><i class="fa fa-file-download"></i>
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
        <th>Reg. Number</th>
        <th>Customer Name</th>
        <th>Address</th>
        <th>Last Replaced On</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $a = 1;
        foreach($harmet as $h) { ?>
        <tr>
          <th scope="row"><?= $a++; ?></th>
          <td><?= $h['noreg_pelanggan']; ?></td>
		  <td><?= $h['nama_pelanggan']; ?></td>
		  <td><?= $h['alamat_pelanggan']; ?></td>
          <td><?= $h['tanggal_penggantian_harmet']; ?></td>
          <td>
			<a href="javascript:void(0)" class="badge badge-warning" data-toggle="modal" data-target="#update_harmet"
			    data-id_harmet="<?= $h['id_harmet']; ?>"
			    data-id_pelanggan="<?= $h['id_pelanggan']; ?>"
			    data-merk_harmet="<?= $h['merk_harmet']; ?>"
			    data-no_meter_harmet="<?= $h['no_meter_harmet']; ?>"
			    data-tahun_harmet="<?= $h['tahun_harmet']; ?>"
			    data-stan_harmet="<?= $h['stan_harmet']; ?>"
			    data-no_ba_harmet="<?= $h['no_ba_harmet']; ?>"
			    data-tanggal_ba_harmet="<?= $h['tanggal_ba_harmet']; ?>"
			  >
			  <i class="fas fa-recycle"></i>
			</a>
            <a href="<?= base_url('harmet/detail/').$h['id_harmet']; ?>" class="badge badge-primary p-1" title="View Detail">
			  <i class="fas fa-info-circle"></i>
		    </a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<div class="modal fade" id="create_harmet" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Insert Harmet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
	  <form action="<?= base_url('harmet/create'); ?>" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
		<div class="form-group">
		  <label>Reg. Number</label>
		  <select name="id_pelanggan" class="form-control form-control-sm">
			<option value="New" selected>New Customer</option>
			<?php
			  foreach($customer as $c) { ?>
				<option value="<?= $c['id_pelanggan']; ?>"><?= $c['noreg_pelanggan']; ?> | <?= $c['nama_pelanggan']; ?></option>
			<?php } ?>
		  </select>
		</div>
		<div class="form-group">
		  <label>Customer</label>
		  <input name="nama_pelanggan" class="form-control form-control-sm">
		</div>
		<div class="form-group">
		  <label>Address</label>
		  <input name="alamat_pelanggan" class="form-control form-control-sm">
		</div>
		<div class="form-group">
		  <label>Description</label>
		  <input name="ket_harmet" class="form-control form-control-sm">
		</div>
		<div class="form-group">
		  <label>Technician</label>
		  <input type="hidden" name="id_target" class="form-control form-control-sm">
		  <select name="id_user" class="form-control form-control-sm">
            <option selected disabled>Choose Technician</option>
            <?php
              foreach($user as $u) { ?>
			    <option value="<?= $u['id_user']; ?>"><?= $u['nama_user']; ?></option>
            <?php } ?>
          </select>
		</div>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm btn-form">Save</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<div class="modal fade" id="update_harmet" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Replace Harmet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
	  <form action="<?= base_url('harmet/update'); ?>" method="POST">
      <div class="modal-body">
	    <input type="hidden" name="id_harmet" class="form-control form-control-sm">
		<input type="hidden" name="id_pelanggan" class="form-control form-control-sm">
		<div class="form-group">
		  <label>Merk Harmet</label>
		  <input id="merk_harmet" name="merk_harmet" class="form-control form-control-sm">
		</div>
		<div class="form-group">
		  <label>Meter ID</label>
		  <input id="no_meter_harmet" name="no_meter_harmet" class="form-control form-control-sm">
		</div>
		<div class="form-group">
		  <label>Produced on</label>
		  <input id="tahun_harmet" name="tahun_harmet" class="form-control form-control-sm">
		</div>
		<div class="form-group">
		  <label>Stand Location</label>
		  <input id="stan_harmet" name="stan_harmet" class="form-control form-control-sm">
		</div>
		<div class="form-row">
		  <div class="form-group col-md-6">
			<label>BA Number</label>
			<input id="no_ba_harmet" name="no_ba_harmet" class="form-control form-control-sm">
		  </div>
		  <div class="form-group col-md-6">
			<label>BA Date</label>
			<input id="tanggal_ba_harmet" type="date" name="tanggal_ba_harmet" class="form-control form-control-sm">
		  </div>
		</div>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm btn-form">Create New</button>
        <input type="submit" name="update" class="btn btn-secondary btn-sm btn-form" value="Update">
      </div>
	  </form>
    </div>
  </div>
</div>