<div class="container-fluid mt-1">
  <div class="row">
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-cog"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">P2TL - Visited</span>
		  <a href="<?= base_url('target/export_visited'); ?>" style="float:right; margin-top:-20px"><i class="fa fa-file-download"></i></a>
          <span class="info-box-number" style="font-size:20px"><?= $visited; ?></span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-warning elevation-1"><i class="fab fa-creative-commons-nc"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">P2TL - Not Paid</span>
		  <a href="<?= base_url('target/export_not_paid'); ?>" style="float:right; margin-top:-20px"><i class="fa fa-file-download"></i></a>
          <span class="info-box-number" style="font-size:20px"><?= $not_paid; ?></span>
        </div>
      </div>
    </div>
    
    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-thumbs-up"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">P2TL - Paid</span>
		  <a href="<?= base_url('target/export_paid'); ?>" style="float:right; margin-top:-20px"><i class="fa fa-file-download"></i></a>
          <span class="info-box-number" style="font-size:20px"><?= $paid; ?></span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-ban"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">P2TL - Blocked</span>
		  <a href="<?= base_url('target/export_blocked'); ?>" style="float:right; margin-top:-20px"><i class="fa fa-file-download"></i></a>
          <span class="info-box-number" style="font-size:20px"><?= $blocked; ?></span>
        </div>
      </div>
    </div>
  </div>
   
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">P2TL Recap Report</h5>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
            <div class="btn-group">
              <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
				<i class="fas fa-chart-bar"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right" role="menu">
                <a href="<?= base_url('admin/dashboard/2019'); ?>" class="dropdown-item">2019</a>
                <a href="<?= base_url('admin/dashboard/2020'); ?>" class="dropdown-item">2020</a>
              </div>
            </div>
          </div>
        </div>
        
		<div class="card-body">
          <div class="row">
            <div class="col-md-7">
              <div class="chart">
                <canvas id="targetChart" height="300" style="height:300px"></canvas>
              </div>
            </div>
            <div class="col-md-5">
			  <div class="row">
			    <div class="col-md-12">
                  <p class="text-center">
                    <strong>Table Information</strong>
                  </p>

                  <div class="progress-group">
                   Total User
                    <span class="float-right"><b><?= $user; ?></b></span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-primary" style="width: <?= $user; ?>%"></div>
                    </div>
                  </div>
              
                  <div class="progress-group">
                    Total Customer
                    <span class="float-right"><b><?= $pelanggan; ?></b></span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-danger" style="width: <?= $pelanggan; ?>%"></div>
                    </div>
                  </div>

                  <div class="progress-group">
                    Total P2TL
                    <span class="float-right"><b><?= $target; ?></b></span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-success" style="width: <?= $target; ?>%"></div>
                    </div>
			      </div>
			    </div>
			  </div>
			  
			  <div class="row mt-3">
			    <div class="col-md-12">
                  <p class="text-center">
                    <strong>Average Harmet Target</strong>
                  </p>

				  <div class="row">
				    <div class="col-md-4">
                      <div class="small-box bg-success">
					    <div class="inner">
						  <h3><?= $harmet_tahun; ?><sup style="font-size: 20px">%</sup></h3>

						  <div style="font-size:12px">Realized<br>
						    <span><b><?= $harmet_tahun_terealisasi; ?></b> / <?= $harmet_target->tahun_harmet_target; ?></span>
						  </div>
					    </div>
					    <a href="javascript:void(0)" class="small-box-footer">Yearly</a>
					  </div>
					</div>
					
					<div class="col-md-4">
                      <div class="small-box bg-info">
					    <div class="inner">
						  <h3><?= $harmet_bulan; ?><sup style="font-size: 20px">%</sup></h3>

						  <div style="font-size:12px">Average Realized<br>
						    <span><b><?= $harmet_bulan_terealisasi; ?></b> / <?= $harmet_target->bulan_harmet_target; ?></span>
						  </div>
					    </div>
					    <a href="javascript:void(0)" class="small-box-footer">Monthly</a>
					  </div>
					</div>
					
					<div class="col-md-4">
                      <div class="small-box bg-warning">
					    <div class="inner">
						  <h3><?= $harmet_hari; ?><sup style="font-size: 20px">%</sup></h3>

						  <div style="font-size:12px">Average Realized<br>
						    <span><b><?= $harmet_hari_terealisasi; ?></b> / <?= $harmet_target->hari_harmet_target; ?></span>
						  </div>
					    </div>
					    <a href="javascript:void(0)" class="small-box-footer">Daily</a>
					  </div>
					</div>
			    </div>
			  </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>