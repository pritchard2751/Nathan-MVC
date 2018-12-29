
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $viewModel->__get('pageTitle'); ?></title>
    <link rel="stylesheet" href="public/css/style.css"/>
</head>
<body>
    <?php require 'header.php';?>
    <div class="content">
	<?php require $this->viewFile;?>
    </div>
    <?php require "footer.php";?>
</body>
</html>