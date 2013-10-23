<div class="row-fluid">
	  <h1 class="span8"><?php echo $title; ?></h1>
</div>
<?php $this->load->view('admin/breadcrumb'); ?>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/change_password", array('class'=>'form-horizontal', 'role' => 'form'));?>

	  <div class="form-group">
			<label for="old_password" class="col-lg-2 control-label">Senha antiga</label>
			<div class="col-lg-10">
				  <?php echo form_input($old_password);?>
			</div>
	  </div>

	  <div class="form-group">
			<label for="new_password" class="col-lg-2 control-label">Nova senha</label>
			<div class="col-lg-10">
				  <?php echo form_input($new_password);?>
			</div>
	  </div>

	  <div class="form-group">
			<label for="new_password_confirm" class="col-lg-2 control-label">Confirmar nova senha</label>
			<div class="col-lg-10">
				  <?php echo form_input($new_password_confirm);?>
			</div>
	  </div>

	  <div class="form-group">
	  		<div class="col-lg-offset-2 col-lg-10">
	  			<?php echo form_input($user_id);?>
				<?php echo form_submit('submit', 'Alterar', 'class="btn btn-primary"');?>
	  		</div>
	  </div>
	  
<?php echo form_close();?>
