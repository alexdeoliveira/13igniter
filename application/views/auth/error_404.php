<?php $CI =& get_instance(); ?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php echo isset($title) ? $title.' | ' : NULL; ?><?php echo $CI->config->item('site_description')?>">
		<meta name="author" content="13 Bits">
		<link rel="shortcut icon" href="<?php echo assets_url('img/favicon.ico'); ?>">

		<title>Página não encontrada | <?php echo $CI->config->item('entidade_nome_breve'); ?></title>

		<link rel="shortcut icon" href="<?php echo assets_url('img/favicon.ico'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo assets_url('bootstrap/dist/css/bootstrap.min.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo assets_url('css/style.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo assets_url('css/v-1.0.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo assets_url('fontello/css/ignitercms.css'); ?>">
		<!--[if IE 7]><link rel="stylesheet" href="<?php echo assets_url('fontello/css/ignitercms-ie7.css'); ?>"><![endif]-->
		
		<!-- Chosen v1.0.0 -->
		<!-- Custom styles for this template -->
		<link href="<?php echo assets_url('css/offcanvas.css') ?>" rel="stylesheet">

		<?php if (isset($assets_css) AND is_array($assets_css)): ?>
			<?php foreach ($assets_css as $row): ?>
				<?php echo $row; ?>
			<?php endforeach ?>
		<?php endif ?>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="<?php echo assets_url('bootstrap/assets/js/html5shiv.js') ?>"></script>
			<script src="<?php echo assets_url('bootstrap/assets/js/respond.min.js') ?>"></script>
		<![endif]-->

		<?php if(ENVIRONMENT !== 'development'): ?>
			<script type="text/javascript">
				var _gaq = _gaq || [];
				_gaq.push(['_setAccount', '<?php echo $CI->config->item('ga_codigo'); ?>']);
				_gaq.push(['_trackPageview']);
				(function() {
					var ga = document.createElement('script');
					ga.type = 'text/javascript';
					ga.async = true;
					ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
					var s = document.getElementsByTagName('script')[0];
					s.parentNode.insertBefore(ga, s);
				})();
			</script>
		<?php endif; ?>
	</head>

	<body class="">
		<div class="container">
			<div class="thumbnail">
				<div class="well-404 text-center">
					<h1>Oops!</h1>
					<p class="lead">Página não encontrada</p>
					<p>O endereço abaixo não existe <br/> <strong><?php echo current_url(); ?></strong></p>
					<a href="<?php echo base_url(); ?>" class="btn btn-primary">Página inicial</a>
				</div>
			</div>
		</div>
	</body>
</html>