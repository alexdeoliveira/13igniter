<div class="row">
	<h1 class="col-lg-8"><?php echo isset($title) ? $title : '' ; ?></h1>
	<div class="col-lg-4">
		<div class="btn-group pull-right">
			<?php if (isset($btn_group)): foreach($btn_group as $row): ?>
				<?php echo $row; ?>
			<?php endforeach; endif ?>
		</div>
	</div>
</div>

<?php $this->load->view('admin/breadcrumb'); ?>