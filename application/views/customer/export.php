<?php
  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=Customer_Export_Data.xls");
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
	  background-color: #80CCFF;
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
  <center><h4><u>Export from Data Customer</u></h4></center>
  <table border="1" class="gridtable">
    <thead>
      <tr>
		<th class="col-md-1">#</th>
        <th class="col-md-2">Reg. Number</th>
        <th class="col-md-3">Customer Name</th>
        <th class="col-md-4">Customer Address</th>
        <th class="col-md-1">Capacity</th>
        <th class="col-md-1">Rates</th>
        <th class="col-md-1">Latitude</th>
        <th class="col-md-1">Longitude</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $a = 1;
        foreach($customer as $c) { ?>
        <tr>
          <th scope="row"><?= $a++; ?></th>
          <td><?= $c['noreg_pelanggan']; ?></td>
          <td><?= $c['nama_pelanggan']; ?></td>
          <td><?= $c['alamat_pelanggan']; ?></td>
          <td><?= $c['daya']; ?></td>
          <td><?= $c['tarif']; ?></td>
          <td><?= $c['lat']; ?></td>
          <td><?= $c['lang']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>