<?php $this->load->view('admin/head_section'); ?>
<?php
	$template = (!isset($template)) ? NULL : $template ; 
	echo $data->render_form($form_fields, $url, array(), $template);	
?>