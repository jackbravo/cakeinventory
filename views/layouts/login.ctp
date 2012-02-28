<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<meta name="author" content="Pavooou" />

	<?php echo $html->charset(); ?>
	<title>
		<?php echo "$title_for_layout - Sistema de Inventarios "; ?>
	</title>
	<?php
		echo $html->meta('icon');

		echo $html->css('cake.generic');
		echo $html->css('default.axai');
		
		echo $scripts_for_layout;
	?>
</head>

<body>

	<div id="header">
		<div id="header_content">
			<img src="/img/logo.png" class="logo"/>
			<span class="version">v0.1</span>
		</div>
	</div>
	<div id="content_wrapper">
		<div id="pre_content">
			
			
		</div>
		<div id="content" style="width:350px;">
			<?php $session->flash(); ?>

			<?php echo $content_for_layout; ?>
		</div>
		
		
	</div>
</body>
</html>