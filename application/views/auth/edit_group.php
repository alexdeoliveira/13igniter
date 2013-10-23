<div class="row">
	  <h1 class="col-lg-8"><?php echo $title; ?></h1>
	  <div class="col-lg-4">
			<div class="btn-group pull-right">
				  <?php echo anchor('auth/groups', 'Voltar', 'class="btn btn-default"') ?>
			</div>
	  </div>
</div>
<?php $this->load->view('admin/breadcrumb'); ?>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(current_url(), array('class'=>'form-horizontal', 'role' => 'form'));?>

	<div class="form-group">
		<label for="group_name" class="col-lg-2">Nome do grupo:</label>
		<div class="col-lg-10">
			<?php echo form_input($group_name);?>	
		</div>
	</div>

	<div class="form-group">
		<label for="group_description" class="col-lg-2">Descrição:</label>
		<div class="col-lg-10">
			<?php echo form_input($group_description);?>	
		</div>
	</div>

	<div class="form-group">
		<div class="col-lg-10 col-lg-offset-2">
			<?php echo form_submit('submit', 'Alterar grupo', 'class="btn btn-primary"');?>
		</div>
	</div>

<?php echo form_close();?>