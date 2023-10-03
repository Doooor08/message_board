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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
	<?php echo $this->Html->script('lib/bootstrap.bundle.min'); ?>
</head>
<body>
    <?php echo "Session: " . json_encode($user). "<br>" ?>
	<div id="container" class="container">
        <div class="row my-2">
            <div id="header" class="col-md-12 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="h3"><?php echo $pageTitle ?></h3>
                    <div>
                        <span class="mr-2">Hello <?= $user['name'] ?>!</span>
                        <button type="button" id="user-dropdown" class="btn btn-primary rounded-circle" data-toggle="dropdown">
                        <i class="bi bi-person-circle align-middle"></i></button>
                        <div class="dropdown-menu dropdown-menu-right mt-2">
                            <a class="dropdown-item" href="<?php echo Router::url('/user/'. $user['user_id']); ?>">Profile</a>
                            <a class="dropdown-item" href="<?php echo Router::url('/logout'); ?>">Logout</a>
                        </div>
                    </div>
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
	<script>
		const BASE_URL = '<?php echo Router::url('/',true);?>';
	</script>
	<?php echo $this->Html->script(array('ajaxSetup', 'utilities')); ?>
    <?php echo $this->fetch('script'); ?>
</body>
</html>
