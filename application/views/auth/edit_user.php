<div class="row">
	  <h1 class="col-lg-8"><?php echo $title; ?></h1>
	  <div class="col-lg-4">
			<div class="btn-group pull-right">
				  <?php echo anchor('auth/index', 'Voltar', 'class="btn btn-default"') ?>
			</div>
	  </div>
</div>
<?php $this->load->view('admin/breadcrumb'); ?>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(current_url(), array('class'=>'form-horizontal', 'role' => 'form'));?>

	   <div class="form-group">
			<label for="first_name" class="col-lg-2">Primeiro nome</label>
			<div class="col-lg-10">
				  <?php echo form_input($first_name);?>
			</div>
	  </div>

	  <div class="form-group">
			<label for="last_name" class="col-lg-2">Último nome</label>
			<div class="col-lg-10">
				  <?php echo form_input($last_name);?>
			</div>
	  </div>

	  <div class="form-group">
			<label for="phone" class="col-lg-2">Telefone</label>
			<div class="col-lg-10">
				  <?php echo form_input($phone);?>
			</div>
	  </div>
	  <div class="form-group">
			<label for="senha" class="col-lg-2">Senha</label>
			<div class="col-lg-10">
				  <?php echo form_input($password);?>
			</div>
	  </div>

	  <div class="form-group">
			<label for="senha" class="col-lg-2">Confirmação da senha</label>
			<div class="col-lg-10">
				  <?php echo form_input($password_confirm);?>
			</div>
	  </div>


	  <?php echo form_hidden('id', $user->id);?>
	  <?php echo form_hidden($csrf); ?>

	  <div class="form-group">
	  		<div class="col-lg-10 col-lg-offset-2">
	  			<?php echo form_submit('submit', 'Salvar', 'class="btn btn-primary"');?>
	  		</div>
	  </div>

<?php echo form_close();?>