<html>
<body>
	<h1>Redefinição de senha para <?php echo $identity;?></h1>
	<p>Por favor, clique neste link para <?php echo anchor('auth/reset_password/'. $forgotten_password_code, 'Redefinir sua senha');?>.</p>
	<p>
		Atenciosamente, <br>
		<?php echo $this->config->item('entidade_nome_breve') ?>
	</p>
	<hr>
	<p>
		Esta mensagem foi enviada automaticamente pela <?php echo $this->config->item('entidade_nome_breve') ?>, por favor não responda.<br>
		<a href="<?php echo base_url() ?>"><?php echo base_url() ?></a>
	</p>
</body>
</html>