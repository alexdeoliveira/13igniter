		<!-- End body -->
		</div>
		
		<?php if($this->session->flashdata('success')): ?>
			<div class="message-alert alert alert-dismissable alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php echo $this->session->flashdata('success'); ?>
			</div>
		<?php elseif($this->session->flashdata('fail')): ?>
			<div class="message-alert alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php echo $this->session->flashdata('fail'); ?>
			</div>
		<?php endif; ?>

		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="<?php echo assets_url('bootstrap/assets/js/jquery.js') ?>"></script>
		<script src="<?php echo assets_url('bootstrap/dist/js/bootstrap.min.js') ?>"></script>
		<script src="<?php echo assets_url('js/offcanvas.js') ?>"></script>
		<script type="text/javascript" src="<?php echo assets_url('datatables/media/js/jquery.dataTables.min.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo assets_url('datatables/media/js/dataTables.bootstrap.js'); ?>"></script>
		<!-- Chosen v1.0.0 -->
		<script src="<?php echo assets_url('chosen/chosen.jquery.min.js'); ?>" type="text/javascript"></script>

		<script src="<?php echo assets_url('js/main.js'); ?>" type="text/javascript"></script>
	</body>
</html>
