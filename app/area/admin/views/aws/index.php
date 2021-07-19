</head>
<body>
<div class="">
<div class="uk-padding">
	<ul class="uk-subnav uk-subnav-pill">
		<li class="uk-active"><a href="<?php echo url_action("aws", "index"); ?>">Home</a> </li>
		<li ><a href="<?php echo url_action("user", "logout"); ?>">Logout</a> </li>
	</ul>
</div>
 
<h3>AWS Console</h3> 
	
<table width="100%" cellpadding="5" cellspacing="0" class="uk-table uk-table-striped" style="font-size: 14px;">
<thead>
<tr>
<th>#</th>
<?php
	$headers = array("Device", "Track Id", "Code", "DateTime"); 
	
	foreach ($headers as $val) {
		echo "<th>".$val."</th>";	
	}
?>
</tr>
</thead>
<tbody>
<?php 
foreach ($dataset as $key => $val) {	
	echo "<tr>";	
	echo "<td>".$key.'</td>';
	
	echo "<td>".$val['device']."</td>";
	echo "<td>".$val['trackid']."</td>";
	echo "<td>".$val['code']."</td>";
	echo "<td>".$val['createdate']."</td>";	 
	 
	echo "</tr>";
}

?>
</tbody>
</table>
</div>