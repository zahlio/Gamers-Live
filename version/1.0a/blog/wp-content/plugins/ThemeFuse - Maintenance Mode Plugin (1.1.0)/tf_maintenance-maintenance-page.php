<?php
    global $TF_maintenance;
    if ( isset($_POST['tf_maintenance_email']) ) $TF_maintenance->add_email( $_POST['tf_maintenance_email'] );
	$location_folder = $TF_maintenance->location_folder;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?php bloginfo('name'); ?>
</title>
<script type="text/javascript" src="<?php echo $location_folder ; ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $location_folder; ?>/js/jquery.cycle.all.min.js"></script>
<script type="text/javascript" src="<?php echo $location_folder; ?>/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo $location_folder; ?>/js/jquery.countdown.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $location_folder; ?>/css/style.css" />
<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo $location_folder; ?>/css/ie7.css" />
	<![endif]-->
<script type="text/javascript" src="<?php echo $location_folder; ?>/js/jquery-ui.js"></script>
<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs();
	});
	</script>
</head>
<body background="<?php echo $TF_maintenance->get_option('tf_maintenance_bg'); ?>">
<?php
    $username = $TF_maintenance->get_option('tf_maintenance_twitter_url');
?>
<div class="container">
  <div id="tf_maintenance-timer"></div>
  <div class="middle">
    <div class="container-progress-bar">
      <div class="logo">
        <?php if ( $TF_maintenance->get_option('tf_maintenance_logo') ) { ?>
        <img src="<?php echo $TF_maintenance->get_option('tf_maintenance_logo'); ?>" id="logo"/>
        <?php } else { ?>
        <img src="<?php echo $location_folder; ?>/images/logo.png" id="logo"/>
        <?php } ?>
      </div>
      <p> <?php echo $TF_maintenance->get_option('tf_maintenance_complete_text'); ?> </p>
      <div id="tf_maintenance-progress-bar" class="clearfix">
        <div id="tf_maintenance-bar"></div>
        <div id="tf_maintenance-piece"></div>
        <span id="percent_text"><?php echo intval($TF_maintenance->get_option('tf_maintenance_complete_percent')); ?>%</span>
        <div id="tf_maintenance-overlay"></div>
      </div>
    </div>
  </div>
  <div class="OverTabs">
    <div id="tabs">
      <div class="tabs-shadow" >
        <div class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" id="tabs-1">
          <h1>WE'll notify you When the site is live: </h1>
          <form method="post" id="searchform" action="#">
            <input type="text" value="<?php _e('Enter your email adress') ?>" onfocus="if (this.value == '<?php _e('Enter your email adress') ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Enter your email adress') ?>" name="tf_maintenance_email" id="searchinput" />
            <input type="submit" value="Submit" id="searchsubmit" class="buttons"/>
          </form>
        </div>
        <div class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" id="tabs-2">
          <div id="last_tweet">Loading last tweet ...</div>
          <script>
					function twitter_callback_function( tweet ) {
						var name = tweet[0].user.name.split(' ', 1);
						$('#last_tweet').html(
							'<img src="' + tweet[0].user.profile_image_url +
							'" /><div><strong>@' +
							 name[0] + '</strong><p>' +
							tweet[0].text + '</p></div><div class="follow"><p><a target="_blank" href="http://twitter.com/' +
										tweet[0].user.screen_name + '" class="buttons">Follow</a></p></div>' +
							' '
						);
						$('#last_tweet').addClass('last_tweet_box');
					}
					</script>
          <script src="http://twitter.com/statuses/user_timeline/<?php echo $username; ?>.json?callback=twitter_callback_function&count=1"></script>
        </div>
        <div class="ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-3"> <?php echo $TF_maintenance->get_option('tf_maintenance_content');?> </div>
      </div>
      <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
        <li class="ui-state-default ui-corner-top"><a href="#tabs-1" class="mail">&nbsp;</a></li>
        <li class="ui-state-default ui-corner-top"><a href="#tabs-2" class="release">&nbsp;</a></li>
        <li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="#tabs-3" class="message">&nbsp;</a></li>
      </ul>
    </div>
  </div>
</div>
<script type="text/javascript">
	//<![CDATA[
		et_subscribe_bar();

		var MaintenanceDay = new Date();
		MaintenanceDay = new Date('<?php echo($TF_maintenance->get_option('tf_maintenance_date')=='')?'11/12/2012 10:10':$TF_maintenance->get_option('tf_maintenance_date'); ?>');
		jQuery('#tf_maintenance-timer').countdown({until: MaintenanceDay,layout: '<span class="timer"><strong>{dn}</strong> {dl}</span><span class="timer"><strong>{hn}</strong> {hl}</span><span class="timer"><strong>{mn}</strong> {ml}</span>'});

		function et_subscribe_bar(){
			var $searchform = jQuery('#tf_maintenance-subscribe'),
				$searchinput = $searchform.find("input#searchinput"),
				searchvalue = $searchinput.val();

			$searchinput.focus(function(){
				if (jQuery(this).val() === searchvalue) jQuery(this).val("");
			}).blur(function(){
				if (jQuery(this).val() === "") jQuery(this).val(searchvalue);
			});
		};

		var $progress_bar = jQuery('#tf_maintenance-bar'),
		$progress_torn_piece = jQuery('#tf_maintenance-piece'),
		et_multiply = 4,
		et_percent = <?php echo intval($TF_maintenance->get_option('tf_maintenance_complete_percent')); ?>,
		et_percent_width = et_multiply*et_percent;

		if ( et_percent === 100 ) et_percent_width = 367;

		$progress_bar.animate({ width: ( et_percent_width - 20 ) }, 2000, function(){
			jQuery(this).animate({ width: ( et_percent_width ) }, 200);
			jQuery('#percent_text').animate({'opacity': 'toggle'}, 300);
			if ( et_percent != 100 )
				$progress_torn_piece.css({left: (et_percent_width-2), 'display': 'block'});
		});
	//]]>
	</script>
</body>
</html>