<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('lib/bootstrap.min');
		echo $this->fetch('meta');
		echo $this->fetch('css');
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<?php echo $this->Html->script('lib/bootstrap.bundle.min'); ?>
</head>
<body>
	<div id="container" class="container-fluid">
		<div id="content" class="row mt-4">
			<?php echo $this->Flash->render(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer" class="fixed-bottom">
			<div class="text-center pb-2">2023 &copy; <a href="#" class="text-decoration-none">Sample Website</a></div>
		</div>
	</div>
	<script>
		const BASE_URL = '<?php echo Router::url('/',true);?>';
	</script>
	<?php echo $this->Html->script('ajaxSetup'); ?>
	<?php echo $this->Html->script('authValidation'); ?>
</body>
</html>
