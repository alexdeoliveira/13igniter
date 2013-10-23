<div class="container">

	<div class="row row-offcanvas row-offcanvas-right">
		<div class="col-xs-12 col-sm-9">
			<p class="pull-right visible-xs">
				<button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
			</p>
			<div class="row">
				<?php $this->load->view($page); ?>
			</div><!--/row-->
		</div><!--/span-->

		<?php $this->load->view('admin/sidebar'); ?>
	</div><!--/row-->

	<hr>

	<?php $this->load->view('admin/footer'); ?>
</div><!--/.container-->
