<script>
var app;
$(document).ready(function () {	
	 
	$("#jp-submit").click(function(){
		UIkit.modal.confirm("Are you sure to submit?", function(){
			$("#vue-app").submit();
		});
	});
  
}); 
</script>
</head>
<body>
<div class="jp-container jp-form">
	<div ><img src="<?php html_img("logo.jpg"); ?>" alt="LOGO" /></div>
	<div class="uk-padding uk-margin jp-text">Thank you for attending Juniper Channel Partner Solution Update Seminar 2019. Please take few minutes to complete the feedback form. Your responses will help us to continue offering events that are informative and relevant.</div>
	
	<?php 
		if (!isNULLorEmpty($error)) { 
			echo '<p class="uk-text-danger	">'.$error.'</p>';
		}
	?>
	
	<form id="vue-app" method="POST" action="<?php echo url_action("feedback", "submit", ""); ?>">
	<div class="uk-grid uk-grid-collapse jp-padding-row">	
		<div class="uk-width-large-2-3 uk-text-large">Please put &radic;:</div><div class="uk-width-large-1-3 uk-text-large"> Excellent => Poor</div>		
		
		<div class="uk-width-large-2-3 ">Rating on Session One: Opening note and Juniper Direction - by Thomas Chan</div>
		<div class="uk-width-large-1-3"><?php form_radio_group("rate_1", $user->rating[1], array(5 => "5", 4 => "4", 3 => "3", 2 => "2", 1 => "1")); ?></div>
		<div class="jp-hr"></div>
		
		<div class="uk-width-large-2-3">Rating on Session Two: Build a Cloud Ready Data Center – by Charles Cheang </div>
		<div class="uk-width-large-1-3"><?php form_radio_group("rate_2", $user->rating[2], array(5 => "5", 4 => "4", 3 => "3", 2 => "2", 1 => "1")); ?> </div>
		<div class="jp-hr"></div>
		
		<div class="uk-width-large-2-3">Rating on Session Three: Introducing Contrail Enterprise Multicloud – by Eric Ng </div>
		<div class="uk-width-large-1-3"><?php form_radio_group("rate_3", $user->rating[3], array(5 => "5", 4 => "4", 3 => "3", 2 => "2", 1 => "1")); ?> </div>
		<div class="jp-hr"></div>
		
		<div class="uk-width-large-2-3">Rating on Session Four: Unified CyberSecurity powered by SDSN – by Carson Chung</div>
		<div class="uk-width-large-1-3"><?php form_radio_group("rate_4", $user->rating[4], array(5 => "5", 4 => "4", 3 => "3", 2 => "2", 1 => "1")); ?> </div>
		<div class="jp-hr"></div>
		
		<div class="uk-width-large-2-3">Rating on Session Five: SD-WAN for Enterprise – by Andy Wong</div>
		<div class="uk-width-large-1-3"><?php form_radio_group("rate_5", $user->rating[5], array(5 => "5", 4 => "4", 3 => "3", 2 => "2", 1 => "1")); ?> </div>
		<div class="jp-hr"></div>
		
		<div class="uk-width-large-2-3">Did the booths provide quality information to you?</div>
		<div class="uk-width-large-1-3"><?php form_radio_group("rate_6", $user->rating[6], array(5 => "5", 4 => "4", 3 => "3", 2 => "2", 1 => "1")); ?> </div>
		<div class="jp-hr"></div>
		
		<div class="uk-width-large-2-3">Was the overall seminar information useful?</div>
		<div class="uk-width-large-1-3"><?php form_radio_group("rate_7", $user->rating[7], array(5 => "5", 4 => "4", 3 => "3", 2 => "2", 1 => "1")); ?> </div>
		<div class="jp-hr"></div>
	</div>
	
	<div class="uk-width-1-1 uk-margin jp-padding-row">	
		<div>1. Which solutions your customers are most interested in coming 18 months (up to 3) ? </div>
		<div class="jp-margin-left">
			<div><?php form_checkbox('interest[]', "1", $user->interest); ?> Cloud Migration (Hybrid/private cloud) </div>
			<div><?php form_checkbox('interest[]', "2", $user->interest); ?> Software Defined Network (SDN) </div>
			<div><?php form_checkbox('interest[]', "3", $user->interest); ?> Data Center automation </div>
			<div><?php form_checkbox('interest[]', "4", $user->interest); ?> Campus Networking Solution </div>
			<div><?php form_checkbox('interest[]', "5", $user->interest); ?> SD-WAN </div>
			<div><?php form_checkbox('interest[]', "6", $user->interest); ?> Security in Virtualized environment </div>
			<div><?php form_checkbox('interest[]', "7", $user->interest); ?> Security – Application control </div>
			<div><?php form_checkbox('interest[]', "8", $user->interest); ?> Security – APT protection </div>
		</div>
	</div>
	
	<div class="uk-width-1-1 uk-margin jp-padding-row">	
		<div>2. Which Juniper multicloud product, solution or technology are you interested to know more?</div>
		<div class="jp-margin-left">
			<div><?php form_checkbox('solutions[]', "1", $user->solutions); ?> Modern Data Center switch, QFX switches </div>
			<div><?php form_checkbox('solutions[]', "2", $user->solutions); ?> EVPN/ VxLAN technology </div>
			<div><?php form_checkbox('solutions[]', "3", $user->solutions); ?> Contrail Enterprise Multicloud (CEM) </div>
			<div><?php form_checkbox('solutions[]', "4", $user->solutions); ?> Afformix </div>
			<div><?php form_checkbox('solutions[]', "5", $user->solutions); ?> JATP </div>
			<div><?php form_checkbox('solutions[]', "6", $user->solutions); ?> Others, please specify: <?php form_textbox('solu_other', $user->solu_other); ?></div>
		</div>
	</div>
	
	<div class="uk-width-1-1 uk-margin jp-padding-row">	
		<div>3. Which Juniper certified training you would like to join? (You can select more than one)</div>
		<div class="jp-margin-left">
			<div><?php form_checkbox('training[]', "1", $user->training); ?> Introduction to the Junos Operating System (IJOS)</div>
			<div><?php form_checkbox('training[]', "2", $user->training); ?> Junos Intermediate Routing (JIR) and Enterprise Switching (JEX)</div>
			<div><?php form_checkbox('training[]', "3", $user->training); ?> Junos Security (JSEC) </div>
			<div><?php form_checkbox('training[]', "4", $user->training); ?> Junos Service Provider Switching (JSPX)  and Routing (AJSPR) </div>
			<div><?php form_checkbox('training[]', "5", $user->training); ?> Junos Troubleshooting in the NOC (JTNOC) </div>
			<div><?php form_checkbox('training[]', "6", $user->training); ?> Advanced Data Center Switching (ADCX) </div>
			<div><?php form_checkbox('training[]', "7", $user->training); ?> Advanced Junos Platform Automation and DevOps (AJAUT) </div>
			<div><?php form_checkbox('training[]', "8", $user->training); ?> Juniper Cloud Fundamentals (JCF) </div>	
		</div>
	</div>
	
	<div class="uk-width-1-1 uk-margin jp-padding-row">	
		<div>4.	Would you like to attend our “Security101 Bootcamp” which will be held on 26 Apr (1 day)? </div>
		<div class="jp-margin-left"><?php form_radio_group("joincamp", $user->joincamp, array(1 => "Yes", 2 => "No")); ?></div>
 	
	</div>
	
	<div class="uk-width-1-1 uk-margin ">	
		<div>5. Would you like us to:</div>
		<div class="uk-grid uk-grid-collapse jp-padding-row">
			<div class="uk-width-large-1-3 jp-margin-left"><?php form_checkbox('likeus[]', "1", $user->likeus); ?> Set up a meeting at around: </div><div class="uk-width-large-1-2"><input type="textbox" name="meeting" value="<?php echo $user->meeting; ?>" class="jp-textbox" /></div>
			<div class="uk-width-large-1-3 jp-margin-left"><?php form_checkbox('likeus[]', "2", $user->likeus); ?> Others, please specify: </div><div class="uk-width-large-1-2"><input type="textbox" name="likeother" value="<?php echo $user->likeother; ?>" class="jp-textbox" /></div> 	
		</div>
	</div>
	
	<div class="jp-hr"></div>
	<div class="uk-width-1-1 uk-margin">	
		<div><?php form_checkbox('promote', "1",  $user->promote); ?> I agree to receive communications from Juniper Networks, Inc. via email. </div>
		<div><?php form_checkbox('phonecall', "1",  $user->phonecall); ?> I agree to receive communications from Juniper Networks, Inc. via phone call. </div>	
	</div>
	
	<div class="jp-text jp-text-litc uk-margin">
		Please check the above box(es) below if Juniper Networks, Inc. (“Juniper”) may email and call you with information regarding Juniper’s products and services, as well as event invitations or other tailored information. You can withdraw your consent at any time, by using the opt-out link at the bottom of our respective marketing emails. For more information on how Juniper Networks, Inc. uses your information please see our privacy policy on Juniper.net (<a href="https://www.juniper.net/us/en/privacy-policy/">https://www.juniper.net/us/en/privacy-policy/</a>).	
	</div> 
	
	<div>
		<h2>Contact Details</h2>
	</div>
	
	<div class="uk-grid uk-grid-collapse uk-margin jp-form-input">			 
		<div class="uk-width-large-1-4"> Company:</div><div class="uk-width-large-3-4"><input type="textbox" name="company" value="<?php echo $user->company; ?>" class="jp-textbox" /></div> 
	    <div class="uk-width-large-1-4"> Name:</div><div class="uk-width-large-1-4"><input type="textbox" name="name" value="<?php echo $user->fname; ?>" class="jp-textbox" /></div> 	 
		<div class="uk-width-large-1-4"> Job Title:</div><div class="uk-width-large-1-4"><input type="textbox" name="title" value="<?php echo $user->title; ?>" class="jp-textbox" /></div> 	 
		<div class="uk-width-large-1-4"> Email:</div><div class="uk-width-large-1-4"><input type="textbox" name="email" value="<?php echo $user->email; ?>" class="jp-textbox" /></div>  
		<div class="uk-width-large-1-4"> Tel:</div><div class="uk-width-large-1-4"><input type="textbox" name="tel" value="<?php echo $user->tel; ?>" class="jp-textbox" /></div> 
	</div>
	
	<div>
		<input id="jp-submit" type="button" name="act" value="Submit" class="uk-button uk-button-primary"/>    
	</div>
	</form>	
</div>