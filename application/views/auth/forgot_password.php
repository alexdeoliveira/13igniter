<div class="container">

	<?php echo form_open('auth/forgot_password', array('class'=>'form-signin')); ?>
		<h2 class="form-signin-heading"><?php echo $title; ?></h2>
		<p>Por favor, digite seu endereço de e-mail para que possamos lhe enviar um e-mail para redefinir sua senha.</p>
		<?php echo validation_errors() ?>
		<div id="infoMessage"><?php echo $message;?></div>
		<input type="text" class="form-control" placeholder="Endereço de email" autofocus>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Enviar</button>
		<?php echo anchor('auth/auth', 'Voltar para o login') ?>
	<?php echo form_close(); ?>
</div> <!-- /container -->