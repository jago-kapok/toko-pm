<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
		    <h5 class="card-title">
			  <i class="fa fa-info-circle"></i>&nbsp;&nbsp;User Information
			</h5>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-striped" style="font-size:95%">
			  <tbody>
				<tr class="d-flex">
				  <th class="col-md-2">Reg. Number</th>
				  <td class="col-md-4">: <?= $harmet->noreg_pelanggan; ?></td>
				  <th class="col-md-2" style="vertical-align:middle">Address</th>
				  <td class="col-md-4">: <?= $harmet->alamat_pelanggan; ?></td>
				</tr>
				<tr class="d-flex">
				  <th class="col-md-2">Customer Name</th>
				  <td class="col-md-10">: <?= $harmet->nama_pelanggan; ?></td>
				</tr>
			  </tbody>
			</table>
          </div>
        </div>
      </div>
	  
	  <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
			  <i class="fa fa-recycle"></i>&nbsp;&nbsp;History Harmet
			</h5>
          </div>
          <div class="card-body">
			<table class="table table-striped" style="font-size:95%">
			  <thead class="bg-info">
				<tr>
				  <th>Merk Harmet</th>
				  <th>Meter ID</th>
				  <th>Produced On</th>
				  <th>Stand Location</th>
				  <th>Description</th>
				  <th>BA Number</th>
				  <th>BA Date</th>
				  <th>Technician</th>
				  <th>Replaced On</th>
				  <th>Photo</th>
				</tr>
			  </thead>
			  <tbody>
				<?php
				  foreach($history as $h) { ?>
					<tr>
					  <td><?= $h['merk_harmet']; ?></td>
					  <td><?= $h['no_meter_harmet']; ?></td>
					  <td><?= $h['tahun_harmet']; ?></td>
					  <td><?= $h['stan_harmet']; ?></td>
					  <td><?= $h['ket_harmet']; ?></td>
					  <td><?= $h['no_ba_harmet']; ?></td>
					  <?php if($h['tanggal_ba_harmet'] === NULL) : ?>
						<td></td>
					  <?php else : ?>
						<td><?= date('d-m-Y', strtotime($h['tanggal_ba_harmet'])); ?></td>
					  <?php endif; ?>
					  <td><?= $h['nama_user']; ?></td>
					  <?php if($h['tanggal_penggantian_harmet'] === NULL) : ?>
						<td></td>
					  <?php else : ?>
						<td><?= date('d-m-Y', strtotime($h['tanggal_penggantian_harmet'])); ?></td>
					  <?php endif; ?>
					  <td><a href="./mobile/target/<?= $h['foto_harmet']; ?>" class="btn btn-success btn-xs" target="_blank">View Photos</a></td>
					</tr>
				<?php } ?>
			  </tbody>
			</table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="modal-view-document">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-body">
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="width:auto">
		  <ol class="carousel-indicators">
			<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			<li data-target="#carousel-example-generic" data-slide-to="1"></li>
		  </ol>

		  <div class="carousel-inner">
			<div class="carousel-item active">
			  <center><img src="https://dpmptsp.sulselprov.go.id/assets/file/blank.png" style="height:65vh"></center>
			</div>
		  </div>

		  <a class="carousel-control-prev" href="#carousel-example-generic" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true" style="color:grey"></span>
			<span class="sr-only">Previous</span>
		  </a>
		  <a class="carousel-control-next" href="#carousel-example-generic" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true" style="color:grey"></span>
			<span class="sr-only">Next</span>
		  </a>
		</div>
	  </div>
	</div>
  </div>
</div>