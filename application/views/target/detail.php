<div class="container-fluid">
  <div class="row mb-2">
	<div class="col-sm-6">
      <span class="btn"><strong>Reg. Number : <i><?= $target->noreg_pelanggan; ?></i></strong></span>
    </div>
    <div class="col-sm-6">
      <a href="<?= base_url('mobile'); ?>/PdfUploadFolder/<?= $target->pdfURL; ?>" class="btn btn-primary btn-sm float-right ml-2">
	    <i class="fa fa-file-download"></i>&nbsp;&nbsp;Download BA
	  </a>
	  <a href="javascript:void(0)" class="btn btn-success btn-sm float-right ml-2" data-toggle="modal" data-target="#modal-view-document">
	    <i class="fa fa-file-image"></i>&nbsp;&nbsp;View Photos
	  </a>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
			  <?php if($target->id_status == 1) : ?>
				<span class="badge badge-info">VISITED</span>
			  <?php elseif($target->id_status == 7) : ?>
				<span class="badge badge-success">PAID</span>
			  <?php elseif($target->id_status == 8) : ?>
				<span class="badge badge-danger">BLOCKED</span>
			  <?php else : ?>
				<span class="badge badge-warning">NOT PAID</span>
			  <?php endif; ?>
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
				  <th class="col-md-3">Customer Name</th>
				  <td class="col-md-9">: <?= $target->nama_pelanggan; ?></td>
				</tr>
				<tr class="d-flex">
				  <th class="col-md-3">Created Date</th>
				  <td class="col-md-9">: <?= $target->tgl_create; ?></td>
				</tr>
				<tr class="d-flex">
				  <th class="col-md-3">BA Number</th>
				  <td class="col-md-9">: <?= $target->noba_target; ?></td>
				</tr>
				<tr class="d-flex">
				  <th class="col-md-3">BA Created Date</th>
				  <td class="col-md-9">: <?= $target->tgl_ba; ?></td>
				</tr>
				<tr class="d-flex">
				  <th class="col-md-3" style="vertical-align:middle">Description</th>
				  <td class="col-md-9">: <?= $target->ket_target; ?></td>
				</tr>
				<tr class="d-flex">
				  <th class="col-md-3" style="vertical-align:middle">Action</th>
				  <td class="col-md-9">: <?= $target->tindakan; ?></td>
				</tr>
				<tr class="d-flex">
				  <th class="col-md-3">Infraction</th>
				  <td class="col-md-9">: <?= $target->golongan_pelanggaran; ?></td>
				</tr>
				<tr class="d-flex">
				  <th class="col-md-3">Technician</th>
				  <td class="col-md-9">: <?= $target->nama_user; ?></td>
				</tr>
				<tr class="d-flex">
				  <th class="col-md-3">Latitude</th>
				  <td class="col-md-9">: <?= $target->lat_target; ?></td>
				</tr>
				<tr class="d-flex">
				  <th class="col-md-3">Longitude</th>
				  <td class="col-md-9">: <?= $target->lang_target; ?></td>
				</tr>
			  </tbody>
			</table>
          </div>
        </div>
      </div>
	  
	  <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">
			  <i class="fa fa-map-marker-alt"></i>&nbsp;&nbsp;Target Location
			</h5>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i></button>
            </div>
          </div>
          <div class="card-body p-1">
            <!--<center><img src="https://dpmptsp.sulselprov.go.id/assets/file/blank.png" width="500"></center>-->
			<div id="map" style="position:relative; top:0; bottom:0; width:100%; height:430px"></div>
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
			  <center><img src="<?= empty($target->dok_target) ? 'https://dpmptsp.sulselprov.go.id/assets/file/blank.png' : '../../mobile/document/'.$target->dok_target; ?>" style="height:65vh"></center>
			</div>
			<div class="carousel-item">
			  <center><img src="<?= empty($target->dok_target2) ? 'https://dpmptsp.sulselprov.go.id/assets/file/blank.png' : '../../mobile/document/'.$target->dok_target2; ?>" style="height:65vh"></center>
			</div>
		  </div>

		  <a class="carousel-control-prev" href="#carousel-example-generic" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true" style="background-color:grey"></span>
			<span class="sr-only">Previous</span>
		  </a>
		  <a class="carousel-control-next" href="#carousel-example-generic" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true" style="background-color:grey"></span>
			<span class="sr-only">Next</span>
		  </a>
		</div>
	  </div>
	</div>
  </div>
</div>