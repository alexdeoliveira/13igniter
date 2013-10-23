<div class="row">
	<h1 class="col-lg-8 col-sm-6"><?php echo $title; ?></h1>
	<div class="col-lg-4 col-sm-6">
		<div class="btn-group pull-right">
			<a href="<?php echo site_url('auth/create_user');?>" class="btn btn-default">Novo usuário</a>
			<a href="<?php echo site_url('auth/create_group');?>" class="btn btn-default">Novo grupo</a>
		</div>
	</div>
</div>
<?php $this->load->view('admin/breadcrumb'); ?>

<div id="infoMessage"><?php echo $message;?></div>

<div class="table-responsive">
	<table class="table normal table-striped table-bordered table-hover" >
		<thead>
			<tr>
				<th>Primeiro nome</th>
				<th>Último nome</th>
				<th>Email</th>
				<th>Grupos</th>
				<th>Status</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($users as $user):?>
				<tr>
					<td><?php echo $user->first_name;?></td>
					<td><?php echo $user->last_name;?></td>
					<td><?php echo $user->email;?></td>
					<td>
						<?php foreach ($user->groups as $group):?>
							<?php echo anchor("auth/edit_group/".$group->id, $group->name) ;?><br />
		                <?php endforeach?>
					</td>
					<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, 'Ativo') : anchor("auth/activate/". $user->id, 'Inativo');?></td>
					<td><?php echo anchor("auth/edit_user/".$user->id, 'Editar') ;?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
		<tfoot>
			<tr>
				<th>Primeiro nome</th>
				<th>Último nome</th>
				<th>Email</th>
				<th>Grupos</th>
				<th>Status</th>
				<th>Ações</th>
			</tr>
		</tfoot>
	</table>
</div>