<div class="container">
	<div class="row">
		<div class="<?php echo (isset($page) and $page != 'welcome')? 'col-md-9' : 'col-md-12'; ?>"><?php $this->load->view( ( isset( $page ) ) ? $page : 'welcome' ); ?></div>
		<?php (isset($page) and $page != 'welcome')? $this->load->view('sidebar') : '' ; ?>
	</div>
</div>
