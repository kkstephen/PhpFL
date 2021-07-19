</head>
<body>
<div class="">
<div class="uk-padding">
	<ul class="uk-subnav uk-subnav-pill">
		<li class="uk-active"><a href="<?php echo url_action("event", "index"); ?>">Event</a> </li>
		<li ><a href="<?php echo url_action("user", "logout"); ?>">Logout</a> </li>
	</ul>
</div>
 
<div class="uk-padding"><a href="<?php echo url_action("event", "export"); ?>" class="uk-button-small uk-button-success">Export</a></div>
<table width="100%" cellpadding="5" cellspacing="0" class="uk-table uk-table-striped" style="font-size: 14px;">
<thead>
<tr>
<th>#</th>
<?php
	$headers = array("Event", "Prefix", "First Name", "Last Name", "Title", "Company", "Email", "Tel", "Mobile", "Industry", "Staff", "Promote", "Argee", "Unsubscribe", "Date", "IP"); 
	 
	foreach ($headers as $val) {
		echo "<th>".$val."</th>";	
	}
?>
</tr>
</thead>
<tbody>
<?php 
foreach ($users as $key => $val) {	
	echo "<tr>";	
	echo "<td>".$val["id"]."</td>";	
	echo "<td>".$val["event_id"]."</td>";	
	echo "<td>".$val['prefix']."</td>";
	echo "<td>".$val['fname']."</td>";
	echo "<td>".$val['lname']."</td>";
	echo "<td>".$val['title']."</td>";
	echo "<td>".$val['company']."</td>";
	echo "<td>".$val['email']."</td>";
	echo "<td>".$val['tel']."</td>"; 
	echo "<td>".$val['mobile']."</td>"; 	 
	echo "<td>".$val['industry']."</td>";
	echo "<td>".$val['staff']."</td>";
	echo "<td>".$val['promote']."</td>";
	echo "<td>".$val['argee']."</td>";
	echo "<td>".$val['unsubscribe']."</td>";	 
	echo "<td>".$val['create_date']."</td>";
	echo "<td>".$val['ip']."</td>";
	echo "</tr>";
}

?>
</tbody>
</table>
</div>