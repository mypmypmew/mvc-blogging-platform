<?php
use \app\core\Application;
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="canonical" href="https://getbootstrap.com/docs/3.4/examples/starter-template/">

	<!-- Bootstrap core CSS from CDN -->
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<link href="https://getbootstrap.com/docs/3.4/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

	<!-- Custom styles for this template (optional) -->

	<script src="https://getbootstrap.com/docs/3.4/assets/js/ie-emulation-modes-warning.js"></script>
	<style>
		.reg-butt{
			margin-left: 400px;
		}
	</style>
	<title><?php echo $this->title ?></title>
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Project name</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li class="active"><a href="/www/blogging_platform/public/">Home</a></li>
				<li><a href="/www/blogging_platform/public/about">About</a></li>
				<li><a href="/www/blogging_platform/public/contact">Contact</a></li>
			</ul>
			<?php if (Application::isGuest()): ?>
			<ul class="nav navbar-nav reg-butt">
				<li><a href="/www/blogging_platform/public/login">Login</a></li>
				<li><a href="/www/blogging_platform/public/register">Register</a></li>

			</ul>
			<?php else: ?>
				<ul class="nav navbar-nav reg-butt">
					<li><a href="/www/blogging_platform
/public/profile">Profile</a></li>
					<li><a href="/www/blogging_platform
/public/logout">Welcome <?php echo Application::$app->user->getDisplayName()?>
							(Logout)
						</a></li>
				</ul>
			<?php endif; ?>
		</div><!--/.nav-collapse -->
	</div>
</nav>

<!-- Add padding-top to container to avoid overlap with navbar -->
<div class="container" style="padding-top: 60px;">
	<?php if(Application::$app->session->getFlash('success')): ?>
	<div class="alert alert-success">
		<?php
			echo Application::$app->session->getFlash('success');
		?>
	</div>
	<?php endif; ?>
	{{content}}

</div><!-- /.container -->

<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="https://code.jquery.com/jquery-1.12.4.min.js"><\/script>')</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://getbootstrap.com/docs/3.4/assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
