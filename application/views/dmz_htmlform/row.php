<?php
	if(!isset($row_id))
	{
		if( ! empty($id))
		{
			$row_id = ' id="row_' . $id . '"';
		}
		else
		{
			$row_id = '';
		}
	}
	else
	{
		$row_id = ' id="' . $row_id .'"';
	}

	if(!isset($label_for))
	{
		if( ! empty($id))
		{
			$label_for = ' for="' . $id . '"';
		}
		else
		{
			$label_for = '';
		}
	}
	else
	{
		$label_for = ' for="' . $label_for .'"';
	}

	if( ! empty($row_class))
	{
		$row_class = ' ' . $row_class;
	}
	else
	{
		$row_class = '';
	}

	if( ! empty($error))
	{
		$row_class .= ' error';
	}

	if($required)
	{
		$row_class .= ' required';
	}

?>

	<div class="form-group<?php echo $row_class; ?>"<?php echo $row_id; ?>>
		<label class="col-lg-2" <?php echo $label_for; ?>><?php echo $label; ?></label>
		<div class="col-lg-10">
			<?php echo $content; ?>
			<?php /** if( ! empty($error)): ?>
				<?php echo $error; ?>
			<?php endif; **/ ?>

		</div>
	</div>
