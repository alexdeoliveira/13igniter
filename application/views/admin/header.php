<header>
	<div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php echo anchor(base_url(), $this->config->item('entidade_nome_breve'), 'class="navbar-brand"'); ?>
			</div>
			<div class="collapse navbar-collapse pull-right">
				<ul class="nav navbar-nav">
					<li><?php echo anchor('auth', 'Painel de controle') ?></li>
					<li>
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<?php echo $this->session->userdata('first_name') ?> <span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
							<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url('auth/my') ?>">Meus dados</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url('auth/change_password') ?>">Alterar senha</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url('auth/logout') ?>">Sair</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.nav-collapse -->
		</div><!-- /.container -->
	</div><!-- /.navbar -->
</header>