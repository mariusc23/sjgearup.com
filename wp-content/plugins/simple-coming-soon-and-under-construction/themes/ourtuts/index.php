<?php global $scs_theme; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $scs_theme['page_title']; ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo SCS_PLUGIN_URL; ?>/themes/ourtuts/style.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<?php
	if ( $scs_theme['expiry_date'] ):
		list( $date,$time ) = explode( '|', $scs_theme['expiry_date'] );
		list( $month, $day, $year ) = explode( '.', $date );
		list( $hours, $minutes, $seconds ) = explode ( ':', $time );
		$month--;
?>
<!-- jquery countdown-->
<script type="text/javascript" src="<?php echo SCS_PLUGIN_URL; ?>/themes/ourtuts/js/jquery.countdown.js"></script>
<script type="text/javascript">
$(function () {
var austDay = new Date(<?php echo "$year, $month, $day, $hours, $minutes, $seconds, 0"; ?>);
	$('#defaultCountdown').countdown({until: austDay, layout: '{dn} {dl}, {hn} {hl}, {mn} {ml}, and {sn} {sl}'});
	$('#year').text(austDay.getFullYear());
});
</script>
<?php endif; ?>

<?php if ( $scs_theme['body_bg'] || $scs_theme['body_bg_color'] ): ?><style type="text/css">
	body { background: <?php echo $scs_theme['body_bg_color']; ?> <?php if ( $scs_theme['body_bg'] ) echo "url({$scs_theme['body_bg']}) repeat-x scroll 0 0"; ?>; }
</style><?php endif; ?>

<!--script for IE6-image transparency recover-->
<!--[if IE 6]>
<script type="text/javascript" src="<?php echo SCS_PLUGIN_URL; ?>/themes/ourtuts/js/DD_belatedPNG_0.0.7a-min.js"></script>
<script>
  DD_belatedPNG.fix('#logo img,#main,.counter,.twitter,.flickr,.facebook,.youtube,#submit_button,.prev img,.next img,#email_input');
</script>
<![endif]--> 
</head>
<body>
<div class="container">

	<div id="header">
	
		<div id="logo">
			<a href="<?php bloginfo('home'); ?>"><img src="<?php if ( $scs_theme['logo'] ) { echo $scs_theme['logo']; } else { echo SCS_PLUGIN_URL.'/themes/ourtuts/images/logo.png'; } ?>" alt="logo"/></a>
		</div><!--end logo-->

		<div id="contact_details">
			<?php if ( $scs_theme['email'] ): ?><p><a href="mailto: <?php echo $scs_theme['email']; ?>"><?php echo $scs_theme['email']; ?></a></p><?php endif; ?>
			<?php if ( $scs_theme['tel'] ): ?><p><a href="#">phone: <?php echo $scs_theme['tel']; ?></a></p><?php endif; ?>
		</div><!--end contact details-->     

	</div><!--end header-->
	<div style="clear:both"></div> 

	<div id="main">

		 <div id="content">

			  <div class="text">
			  <h2><?php echo $scs_theme['heading']; ?></h2>
			  </div><!--end text-->

			
			<?php if ( $scs_theme['expiry_date'] ): ?>
				<div class="counter">
				<h3><?php echo $scs_theme['time_text']; ?></h3>
				<div id="defaultCountdown"></div>
				</div><!--end counter-->
			<?php else: ?>
				<p class="description"><?php echo stripslashes($scs_theme['expiry_text']); ?></p>
			<?php endif; ?>
				

		<div class="details">
		<?php if ( $scs_theme['twitter'] || $scs_theme['facebook'] || $scs_theme['youtube'] || $scs_theme['flickr'] ): ?>
			<h3><?php echo $scs_theme['social_heading']; ?></h3>
			<div class="social">
				<?php if ( $scs_theme['twitter'] ): ?><a target="_blank" href="<?php echo $scs_theme['twitter']; ?>" class="twitter">Follow us on twitter</a><?php endif; ?>
				<?php if ( $scs_theme['flickr'] ): ?><a target="_blank" href="<?php echo $scs_theme['flickr']; ?>" class="flickr">Find us on Flickr</a><?php endif; ?>
				<?php if ( $scs_theme['facebook'] ): ?><a target="_blank" href="<?php echo $scs_theme['facebook']; ?>" class="facebook">Become our fan on Facebook</a><?php endif; ?>
				<?php if ( $scs_theme['youtube'] ): ?><a target="_blank" href="<?php echo $scs_theme['youtube']; ?>" class="youtube">Watch our videos on Youtube</a><?php endif; ?>
			</div>
		<?php endif; ?>
		</div><!--end details-->
		
	</div><!--end content-->

</div><!--end main-->
</div><!--end class container-->
</body>
</html>