<div class="container-fluid mt-1">
  <div class="row">
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box">
        <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-file"></i></span>

        <div class="info-box-content">
          <span class="info-box-text"><b>Total Penawaran / Tahun</b></span>
          <a href="javascript:void(0)" style="float:right; margin-top:-20px"></a>
          <span class="info-box-number" style="float:right; font-size:25px">
            <span class="text-primary h6"><i>Rp</i></span> <?= number_format($quotation->quotation_total); ?>
          </span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-file-invoice-dollar"></i></span>

        <div class="info-box-content">
          <span class="info-box-text"><b>Total Penjualan / Tahun</b></span>
          <a href="javascript:void(0)" style="float:right; margin-top:-20px"></a>
          <span class="info-box-number" style="float:right; font-size:25px">
            <span class="text-primary h6"><i>Rp</i></span> <?= number_format($invoice->invoice_total); ?>
          </span>
        </div>
      </div>
    </div>

    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-info elevation-1"><i class="fa fa-shopping-cart"></i></span>

        <div class="info-box-content">
          <span class="info-box-text"><b>Total Pembelian / Tahun</b></span>
          <a href="javascript:void(0)" style="float:right; margin-top:-20px"></a>
          <span class="info-box-number" style="float:right; font-size:25px">
            <span class="text-primary h6"><i>Rp</i></span> <?= number_format($purchase->purchase_total); ?>
          </span>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3">
        <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-cubes"></i></span>

        <div class="info-box-content">
          <span class="info-box-text"><b>Jumlah Produk</b></span>
          <a href="javascript:void(0)" style="float:right; margin-top:-20px"></a>
          <span class="info-box-number" style="float:right; font-size:25px"><?= $item; ?></span>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Rekap Transaksi Tahun <?php echo date('Y') ?></h5>

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
            <div class="col-md-12">
              <div class="chart">
                <canvas id="transactionChart" height="315"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-5">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Transaksi Penjualan Terbaru</h5>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <table class="table" width="100%">
                <thead class="bg-light">
                  <th></th>
                  <th class="w-50">Invoice</th>
                  <th class="w-25">Total</th>
                  <th class="w-25">Profit</th>
                </thead>
                <tbody>
                  <?php foreach ($recent_invoice as $row) { ?>
                    <tr>
                      <td class="text-info" style="font-size:35px; padding:0px 10px"><i class="fa fa-file-invoice"></i></td>
                      <td>
                        <a href="invoice/prints/<?php echo $row->invoice_id ?>" target="_blank">
                          <?php echo $row->invoice_number ?>
                        </a>
                        <span class="form-text text-muted mt-0"><i><?php echo $row->customer_desc ?></i></span>
                      </td>
                      <td align="right" style="vertical-align:top; font-size:15px">
                        <b><?php echo number_format($row->invoice_total) ?></b>
                      </td>
                      <td align="right" <?php if (($row->invoice_total - $row->invoice_profit) < 0) { ?> class="text-danger" <?php } else { ?> class="text-success" <?php } ?> style="vertical-align:top; font-size:15px">
                        <b><?php echo number_format($row->invoice_total - $row->invoice_profit) ?></b>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Stok Barang Kurang Dari Minimal Stok</h5>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <table class="table" width="100%">
                <thead class="bg-light">
                  <th></th>
                  <th class="w-75">Deskripsi Produk</th>
                  <th class="w-25">Sisa Stok</th>
                </thead>
                <tbody>
                  <?php foreach ($stock_exist as $row) { ?>
                    <tr>
                      <td class="text-danger" style="font-size:35px; padding:0px 10px"><i class="fa fa-cube"></i></td>
                      <td>
                        <a href="stock">
                          <?php echo $row->item_desc ?>
                        </a>
                        <span class="form-text text-muted mt-0"><i><?php echo 'Rp ' . number_format($row->item_buy) ?></i></span>
                      </td>
                      <td align="center" class="text-danger">
                        <b><?php echo number_format($row->stock_exist) . ' ' . $row->item_unit ?></b>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="card">
        <div class="row">
          <div class="col-md-4 col-6">
            <div class="description-block border-right">
              <?php if ($invoice_per_day->invoice_total > $invoice_yesterday->invoice_total) { ?>
                <span class="description-percentage text-success">
                  <i class="fas fa-caret-up"></i>
                <?php } else { ?>
                  <span class="description-percentage text-danger">
                    <i class="fas fa-caret-down"></i>
                  <?php } ?>

                  <?php
                  if (isset($invoice_per_day->invoice_total) && $invoice_yesterday->invoice_total > 0) {
                    echo round((($invoice_per_day->invoice_total - $invoice_yesterday->invoice_total) / $invoice_yesterday->invoice_total) * 100, 2);
                  }
                  ?> %
                  </span>
                  <h5 class="description-header">Rp <?php echo number_format($invoice_per_day->invoice_total) ?></h5>
                  <span class="description-text">TOTAL PENJUALAN HARI INI</span>
            </div>
          </div>
          <div class="col-md-4 col-6">
            <div class="description-block border-right">
              <span class="description-percentage">&nbsp;</span>
              <h5 class="description-header">Rp <?php echo number_format($purchase_per_day->purchase_total) ?></h5>
              <span class="description-text">TOTAL PEMBELIAN HARI INI</span>
            </div>
          </div>
          <div class="col-md-4 col-6">
            <div class="description-block border-right">
              <?php if (($invoice_per_day->invoice_total - $profit_per_day->invoice_profit) > ($invoice_yesterday->invoice_total - $profit_yesterday->invoice_profit)) { ?>
                <span class="description-percentage text-success">
                  <i class="fas fa-caret-up"></i>
                <?php } else { ?>
                  <span class="description-percentage text-danger">
                    <i class="fas fa-caret-down"></i>
                  <?php } ?>

                  <?php
                  if (isset($invoice_per_day->invoice_total) && $invoice_yesterday->invoice_total > 0) {

                    echo round((($invoice_per_day->invoice_total - $profit_per_day->invoice_profit) - ($invoice_yesterday->invoice_total - $profit_yesterday->invoice_profit)) / ($invoice_yesterday->invoice_total - $profit_yesterday->invoice_profit) * 100, 2);
                  }
                  ?> %
                  </span>
                  <h5 class="description-header">Rp <?php echo number_format($invoice_per_day->invoice_total - $profit_per_day->invoice_profit) ?></h5>
                  <span class="description-text">TOTAL PROFIT HARI INI</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {

    'use strict'

    // Get context with jQuery - using jQuery's .get() method.
    var transactionChartCanvas = $('#transactionChart').get(0).getContext('2d')

    var transactionChartData = {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        lineTension: 0,
        backgroundColor: 'rgba(60,141,188,0.9)',
        borderColor: 'rgba(60,141,188,0.8)',
        data: [<?= $jan; ?>, <?= $feb; ?>, <?= $mar; ?>, <?= $apr; ?>, <?= $may; ?>, <?= $jun; ?>, <?= $jul; ?>, <?= $aug; ?>, <?= $sep; ?>, <?= $oct; ?>, <?= $nov; ?>, <?= $dec; ?>]
      }, ]
    }

    var transactionChartOptions = {
      maintainAspectRatio: false,
      responsive: true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines: {
            display: false,
          }
        }],
        yAxes: [{
          gridLines: {
            display: false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var transactionChart = new Chart(transactionChartCanvas, {
      type: 'line',
      data: transactionChartData,
      options: transactionChartOptions
    })
  })
</script>