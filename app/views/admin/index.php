</head>
<body style="padding: 5px;">
<a href="/admin/index">Home</a> | <a href="/admin/detail">Export</a> | <a href="/admin/clear">Clear</a>
	
<table border="0" width="100%" align="center" cellpadding="5" cellspacing="0">
<tr><th></th><th>Name</th><th>Company</th><th>Title</th><th>Email</th><th>Tel</th></tr>
<?php 
foreach ($users as $key => $val) {
	
	echo "<tr>";
	
	echo "<td>".$key.'</td>';
	
	echo "<td>".$val->fname."</td>";
	echo "<td>".$val->company."</td>";
	echo "<td>".$val->title."</td>";
	echo "<td>".$val->email."</td>";
	echo "<td>".$val->tel."</td>";
	
	echo "</tr>";
}

?>
</table>