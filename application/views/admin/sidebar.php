<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
	<div class="well sidebar-nav">
		<?php if (acesso('root')): ?>
			<ul class="nav">
				<li>Usuários</li>
				<?php echo (acesso('root'))? '<li '.( (isset($linkactive) AND $linkactive == 'groups') ? 'class="active"' : '').'>'.anchor('auth/groups', '<i class="icon-users"></i> Grupos').'</li>' : NULL ; ?>
				<?php echo (acesso('root'))? '<li '.( (isset($linkactive) AND $linkactive == 'users') ? 'class="active"' : '').'>'.anchor('auth', '<i class="icon-user"></i> Usuários').'</li>' : NULL ; ?>
			</ul>
		<?php endif ?>
	</div><!--/.well -->
</div><!--/span-->