<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$per_name = isset($sessuser[0]['per_name']) ? $sessuser[0]['per_name'] : '';
$per_surname = isset($sessuser[0]['per_surname']) ? $sessuser[0]['per_surname'] : '';
$user_name = isset($sessuser[0]['user_name']) ? $sessuser[0]['user_name'] : '';
$per_picture = isset($sessuser[0]['per_picture']) ? $sessuser[0]['per_picture'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$title?> - WhereverYouGo Backend by WhereverYouGo Co.,Ltd</title>
	<link rel="shortcut icon" href="<?=site_url()?>assets/images/logo_icon_dark.png">

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?=site_url()?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?=site_url()?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?=site_url()?>assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="<?=site_url()?>assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="<?=site_url()?>assets/css/colors.css" rel="stylesheet" type="text/css">
	<link href="<?=site_url()?>assets/css/custom.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="<?=site_url()?>assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?=site_url()?>assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?=site_url()?>assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=site_url()?>assets/js/plugins/loaders/blockui.min.js"></script>
	<script type="text/javascript" src="<?=site_url()?>assets/js/plugins/forms/validation/validate.min.js"></script>
	<script type="text/javascript" src="<?=site_url()?>assets/js/plugins/forms/selects/select2.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS & CSS files -->
	<?php echo $js;?>
	<?php echo $css;?>

	<script type="text/javascript" src="<?=site_url()?>assets/js/core/app.js"></script>
	<!-- /theme JS & CSS files -->

</head>

<body class="navbar-top">

	<!-- Main navbar -->
	<div class="navbar navbar-default navbar-fixed-top header-highlight">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?=site_url()?>"><img src="<?=site_url()?>assets/images/logo_light.png" alt=""></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<?php if($per_picture==''){?>
							<img src="<?=site_url()?>assets/images/placeholder.jpg" alt="">
						<?php }else{?>
							<img src="<?=site_url()?>assets/images/users/<?=$per_picture?>" alt="">
						<?php }?>
						<span><?=$per_name?></span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<li><a href="<?=base_url('systems/profile/show')?>"><i class="icon-user-plus"></i> My Account</a></li>
						<li class="divider"></li>
						<li><a href="<?=base_url('systems/logout')?>"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">