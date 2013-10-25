<ul class="breadcrumb">
	<li><?php echo anchor('auth/', '<i class="icon-home"></i>', 'title="Início"') ?></li>
	<?php if (isset($breadcrumb)): ?>
		<?php $count = 1; foreach ($breadcrumb as $row): ?>
			<li <?php echo $count == count($breadcrumb) ? 'class="active"' : NULL ; ?>><?php echo $row; ?></li>
		<?php $count ++; endforeach ?>
	<?php endif ?>
</ul>
