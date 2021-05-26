<div class="container-fluid mt-1">
  <div class="row">
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-file"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Penawaran</span>
		  <a href="<?= base_url('transaction/export_visited'); ?>" style="float:right; margin-top:-20px"><i class="fa fa-file-download"></i></a>
          <span class="info-box-number" style="font-size:20px"><?= $quotation; ?></span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-file-invoice-dollar"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Penjualan</span>
		  <a href="<?= base_url('transaction/export_not_paid'); ?>" style="float:right; margin-top:-20px"><i class="fa fa-file-download"></i></a>
          <span class="info-box-number" style="font-size:20px"><?= $invoice; ?></span>
        </div>
      </div>
    </div>
    
    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-info elevation-1"><i class="fa fa-shopping-cart"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Pembelian</span>
		  <a href="<?= base_url('transaction/export_paid'); ?>" style="float:right; margin-top:-20px"><i class="fa fa-file-download"></i></a>
          <span class="info-box-number" style="font-size:20px"><?= $purchase; ?></span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-copy"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Semua Transaksi</span>
		  <a href="<?= base_url('transaction/export_blocked'); ?>" style="float:right; margin-top:-20px"><i class="fa fa-file-download"></i></a>
          <span class="info-box-number" style="font-size:20px"><?= $quotation + $invoice + $purchase; ?></span>
        </div>
      </div>
    </div>
  </div>
   
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Grafik Transaksi Tahun <?php echo date('Y') ?></h5>

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
                <canvas id="transactionChart" height="300" style="height:300px"></canvas>
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
                    <span class="float-right"><b><?= $quotation; ?></b></span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-primary" style="width: <?= $quotation; ?>%"></div>
                    </div>
                  </div>
              
                  <div class="progress-group">
                    Total Customer
                    <span class="float-right"><b><?= $invoice; ?></b></span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-danger" style="width: <?= $invoice; ?>%"></div>
                    </div>
                  </div>

                  <div class="progress-group">
                    Total P2TL
                    <span class="float-right"><b><?= $purchase; ?></b></span>
                    <div class="progress progress-sm">
                      <div class="progress-bar bg-success" style="width: <?= $purchase; ?>%"></div>
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

<script>
  $(function(){

    'use strict'

    // Get context with jQuery - using jQuery's .get() method.
    var transactionChartCanvas = $('#transactionChart').get(0).getContext('2d')

    var transactionChartData = {
      labels  : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [
        {
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          data                : [<?= $jan; ?>, <?= $feb; ?>, <?= $mar; ?>, <?= $apr; ?>, <?= $may; ?>, <?= $jun; ?>, <?= $jul; ?>, <?= $aug; ?>, <?= $sep; ?>, <?= $oct; ?>, <?= $nov; ?>, <?= $dec; ?>]
        },
      ]
    }

    var transactionChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var transactionChart = new Chart(transactionChartCanvas, { 
        type: 'line', 
        data: transactionChartData, 
        options: transactionChartOptions
      }
    )
  })
</script>
