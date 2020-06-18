<?php
header("content-type:application/vnd.ms-excel");
header("content-disposition:attachment; filename=CreditMacchine.xls");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<table border="1">
	
	
	<thead>
		<tr>
			<th>หมายเลขTID</th>
			<th>สาขา</th>
			<th>ธนาคาร</th>
			<th>ยี่ห้อเครื่อง</th>
			<th>รุ่นเครื่อง</th>
			<th>Serial</th>
			<th>Vender</th>
			<th>User</th>
			
		</tr>
	</thead>
	<tbody>
	<?php foreach($result as $r){ 
		
		?>
		<tr>
			<td><?php echo $r["tidcode"];?></td>
			<td><?php echo  '['.$r['branch'].'] '.$r['branchname'];?></td>
			<td><?php echo $r["bankname"];?></td>
			
			<td><?php echo $r["brand"];?></td>
			<td><?php echo $r["generation"];?></td>
			
			<td><?php echo $r["serial"];?></td>
			<td><?php echo $r["vender"];?></td>
			<td><?php echo $r["user"];?></td>



		</tr>
	<?php }?>
	</tbody>
</table>


</body>
</html>
