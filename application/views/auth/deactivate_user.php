<div class="row">
	  <h1 class="col-lg-8"><?php echo $title; ?></h1>
	  <div class="col-lg-4">
			<div class="btn-group pull-right">
				  <?php echo anchor('auth/index', 'Voltar', 'class="btn btn-default"') ?>
			</div>
	  </div>
</div>
<?php $this->load->view('admin/breadcrumb'); ?>
<p>Você está prestes a desativar o usuário <strong>'<?php echo $user->username; ?>'</strong>.</p>
	
<?php echo form_open("auth/deactivate/".$user->id, array('class' => 'form-horizontal', 'role' => 'form'));?>
	<div class="form-group">
		<label for="confirm" class="col-lg-2">Desativar usuário:</label>
		<div class="col-lg-10">
			<div class="checkbox">
				<label>
					<input type="radio" name="confirm" value="yes" checked="checked" /> Sim
				</label>
				<label>
					<input type="radio" name="confirm" value="no" /> Não
				</label>
			</div>
		</div>
	</div>
  <?php echo form_hidden($csrf); ?>
  <?php echo form_hidden(array('id'=>$user->id)); ?>

	<div class="form-group">
		<div class="col-lg-10 col-lg-offset-2">
			<?php echo form_submit('submit', 'Salvar', 'class="btn btn-primary"');?>	
		</div>
	</div>

<?php echo form_close();?>