<!DOCTYPE html>
<html>
<head>
	<?php echo $this->fetch('title'); ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<?php
	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<header>
			<?php echo $this->fetch('header'); ?>
		</header>

		<div id="content">
			<?php echo $this->fetch('content'); ?>
		</div>
			
		<footer>
			<?php echo $this->fetch('footer'); ?>
		</footer>
	</div>
</body>
</html>
