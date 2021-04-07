<div class="container-fluid mt-2">
  <?= $this->session->flashdata('message'); ?>
  <div class="row mb-1">
	<div class="col-md-8"></div>
	<div class="col-md-4 pull-right"></div>
  </div>
  <table id="example" class="table table-striped">
	<thead class="bg-info">
      <tr>
        <th>Daily Target</th>
        <th>Monthly Target</th>
        <th>Yearly Target</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach($harmet_target as $h) { ?>
        <tr>
          <td><?= $h['hari_harmet_target']; ?></td>
		  <td><?= $h['bulan_harmet_target']; ?></td>
		  <td><?= $h['tahun_harmet_target']; ?></td>
          <td>
			<a href="javascript:void(0)" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#update_harmet_target"
			    data-id_harmet_target="<?= $h['id_harmet_target']; ?>"
			    data-hari_harmet_target="<?= $h['hari_harmet_target']; ?>"
			    data-bulan_harmet_target="<?= $h['bulan_harmet_target']; ?>"
			    data-tahun_harmet_target="<?= $h['tahun_harmet_target']; ?>"
			  >
			  <i class="fas fa-edit"></i>&nbsp;&nbsp;Set Harmet Target
			</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<div class="modal fade" id="update_harmet_target" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Set Harmet Target</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
	  <form action="<?= base_url('harmet/setting'); ?>" method="POST">
      <div class="modal-body">
	    <input type="hidden" name="id_harmet_target" class="form-control form-control-sm">
		<div class="form-group">
		  <label>Daily Target</label>
		  <input name="hari_harmet_target" class="form-control form-control-sm">
		</div>
		<div class="form-group">
		  <label>Monthly Target</label>
		  <input name="bulan_harmet_target" class="form-control form-control-sm">
		</div>
		<div class="form-group">
		  <label>Yearly Target</label>
		  <input name="tahun_harmet_target" class="form-control form-control-sm">
		</div>
	  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-form" data-dismiss="modal">Close</button>
        <input type="submit" name="save" class="btn btn-primary btn-sm btn-form" value="Save">
      </div>
	  </form>
    </div>
  </div>
</div>