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
		<?php elseif($this->session->flashdata('error')): ?>
			<div class="message-alert">
				<?php echo $this->session->flashdata('error'); ?>
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

			<script type="text/javascript"> 
				var $buoop = {vs:{i:8,f:15,o:11,s:4,n:9}};
				$buoop.ol = window.onload; 
				window.onload=function(){ 
				 try {if ($buoop.ol) $buoop.ol();}catch (e) {} 
				 var e = document.createElement("script"); 
				 e.setAttribute("type", "text/javascript"); 
				 e.setAttribute("src", "http://browser-update.org/update.js"); 
				 document.body.appendChild(e); 
				} 
			</script>
		
		<?php if (isset($assets_js) AND is_array($assets_js)): ?>
			<?php foreach ($assets_js as $row): ?>
				<?php echo $row; ?>
			<?php endforeach ?>
		<?php endif ?>
	</body>
</html>
