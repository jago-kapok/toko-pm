<?php
  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=User_Export_Data.xls");
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
  <center><h4><u>Export from Data User</u></h4></center>
  <table border="1" class="gridtable">
    <thead>
      <tr>
		<th class="col-md-1">#</th>
        <th class="col-md-3">Full Name</th>
        <th class="col-md-2">Username</th>
        <th class="col-md-2">Password</th>
        <th class="col-md-2">Email</th>
        <th class="col-md-1">Level</th>
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
			<td>User</td>
		  <?php endif; ?>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>