<?php
	if( ! isset($save_button))
	{
		$save_button = 'Salvar';
	}
	if( ! isset($reset_button))
	{
		$reset_button = FALSE;
	}
	else
	{
		if($reset_button === TRUE)
		{
			$reset_button = 'Limpar';
		}
	}
?>
<?php if( ! empty($object->error->all)): ?>
<div>
	<p>Houve erro ao salvar os registros</p>
	<ul class="unstyled"><?php foreach($object->error->all as $k => $err): ?>
		<li><?php echo $err; ?></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>

<form action="<?php echo $this->config->site_url($url); ?>" method="post" class="form-horizontal" role="form">
	<?php echo $rows; ?>
	<div class="form-group">
		<div class="col-lg-10 col-lg-offset-2">
			<input type="submit" class="btn btn-primary" value="<?php echo $save_button; ?>" />
			<?php
				if($reset_button !== FALSE)
				{
					?> <input type="reset" class="btn btn-default" value="<?php echo $reset_button; ?>" /><?php
				}
			?>
		</div>
	</div>
</form>
