<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css(array('lib/bootstrap.min', 'custom'));
		echo $this->fetch('meta');
		echo $this->fetch('css');
	?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<?php echo $this->Html->script('lib/bootstrap.bundle.min'); ?>
</head>
<body>
	<div id="container" class="container">
        <div class="row my-2">
            <div id="header" class="col-md-12 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="h3">Message List</h3>
                    <button type="button" id="user-dropdown" class="btn btn-primary rounded-circle" data-toggle="dropdown">
                    <i class="bi bi-person-circle align-middle"></i></button>
                    <div class="dropdown-menu dropdown-menu-right mt-2">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="#">Logout</a>
                    </div>
                    <!-- <button type="button" id="logout" class="btn btn-light rounded-pill p-2 fs-2">
                    <i class="bi bi-box-arrow-right align-middle mr-2"></i>Logout
                    </button> -->
                </div>
            </div>
            <div id="content" class="col-md-12 my-2">
                <?php echo $this->Flash->render(); ?>
                <?php echo $this->fetch('content'); ?>
            </div>
            <div id="footer" class="fixed-bottom">
                <div class="text-center pb-2">2023 &copy; <a href="#" class="text-decoration-none">Sample Website</a></div>
            </div>
        </div>
	</div>
	<?php
	?>
	<?php echo $this->Html->script('ajaxSetup'); ?>
    <?php echo $this->Html->script('utilities'); ?>
</body>
</html>
