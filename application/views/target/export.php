<?php
  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=Target_Export_Data.xls");
?>

<html>
<head>
  <style type="text/css">
    table.gridtable {
	  font-family: serif;
    }
    table.gridtable th {
	  font-size: 15px;
	  padding: 20px;
	  font-family: "Times New Roman";
	  background-color: #28A745;
    }
    table.gridtable td {
	  font-size: 15px;
	  padding: 8px;
	  font-family: "Times New Roman";
	  background-color: #FFFFFF;
	  width: auto;
    }
  </style>
</head>

<body>
  <center><h4><u>Export from Data Target</u></h4></center>
  <table border="1" class="gridtable">
    <thead>
      <tr style="height:50px">
        <th class="col-md-2">NO.</th>
        <th class="col-md-2">IDPEL</th>
        <th class="col-md-2">NAMA</th>
        <th class="col-md-2">ALAMAT</th>
        <th class="col-md-2">TARIF</th>
        <th class="col-md-2">DAYA</th>
        <th class="col-md-2">GOL. PELANGGARAN</th>
        <th class="col-md-2">DESKRIPSI</th>
        <th class="col-md-2">NO. BA</th>
        <th class="col-md-2">TANGGAL BA</th>
        <th class="col-md-2">PETUGAS</th>
      </tr>
    </thead>
    <tbody>
      <?php
		$a = 1;
        foreach($target as $t) { ?>
        <tr>
          <td><?= $a++; ?></td>
          <td><?= $t['noreg_pelanggan']; ?></td>
		  <td><?= $t['nama_pelanggan']; ?></td>
          <td><?= $t['alamat_pelanggan']; ?></td>
          <td><?= $t['tarif']; ?></td>
          <td><?= $t['daya']; ?></td>
          <td><?= $t['golongan_pelanggaran']; ?></td>
          <td><?= $t['ket_target']; ?></td>
		  <td><?= $t['noba_target']; ?></td>
          <?php if($t['tgl_ba'] == '0000-00-00 00:00:00') : ?>
			<td></td>
		  <?php else : ?>
			<td><?= date('d-m-Y H:i:s', strtotime($t['tgl_ba'])); ?></td>
		  <?php endif; ?>
		  <td><?= $t['nama_user']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>