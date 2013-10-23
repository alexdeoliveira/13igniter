<div class="container">

	<?php echo form_open('auth/login', array('class'=>'form-signin')); ?>
		<h2 class="form-signin-heading"><?php echo $title; ?> | <?php echo $this->config->item('entidade_nome_breve') ?></h2>
		<?php echo validation_errors() ?>
		<input type="text" name="identity" class="form-control" placeholder="Endereço de email" autofocus>
		<input type="password" class="form-control" name="password" placeholder="Senha">
		<label class="checkbox">
			<input type="checkbox" name="remember" value="1"> Lembrar-me
		</label>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
		<?php echo anchor('auth/forgot_password', 'Esqueceu a senha?') ?>
	<?php echo form_close(); ?>
</div> <!-- /container -->