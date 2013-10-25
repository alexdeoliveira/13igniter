<div class="row">
	<h1 class="col-lg-8 col-sm-6"><?php echo $title; ?></h1>
	<div class="col-lg-4 col-sm-6">
		<div class=" pull-right">
			<a href="<?php echo site_url('auth/create_user');?>" class="btn btn-default">Novo usuário</a>
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
					<td>
						<div class="btn-group">
							<?php echo anchor("auth/edit_user/".$user->id, '<span class="icon-pencil"></span>','title="Editar" class="btn btn-default"' ) ;?>
							<a href="#deleteModal" title="Excluir" data-url="<?php echo base_url('auth/delete_user/'.$user->id); ?>" class="btn btn-default delete" data-toggle="modal"><span class="icon-trash-1"></span></a>
						</div>
					</td>
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
<?php $this->load->view('admin/modal_delete');?>
