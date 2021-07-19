</head>
<body>
<div class="uk-width-large-1-5 uk-align-center uk-margin" style="margin-top: 20px">
<form id="vue-app" method="POST" action="<?php echo url_action("user", "auth", ""); ?>">
<div class="uk-panel uk-panel-box">
	<h3>PPM WebAdmin</h3>
	<input type="password" name="passwd" value="" class="jp-textbox" PlaceHolder="Password" /> 
	<p>
		<input type="submit" name="act" value="Login" class="uk-button uk-button-primary" />
	</p>
	<?php if ($msg != "") { ?><div class="uk-text-warning"><?php echo $msg; ?></div><?php } ?>
</div>
</form>
</div>

