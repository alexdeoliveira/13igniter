<?php $this->load->view('head'); ?>
<?php if ($this->ion_auth->logged_in()): ?>
	<?php $this->load->view('admin/header'); ?>
	<div id="main">
		<?php $this->load->view('admin/content'); ?>
	</div>
<?php else: ?>
	<?php $this->load->view($page); ?>
<?php endif ?>
<?php $this->load->view('foot'); ?>
