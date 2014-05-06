<?php $this->load->view('admin/head_section'); ?>

<form method="post" enctype="multipart/form-data" class="plupload23">
	<div id="uploader">
		<p>Seu navegador não possui suporte a Flash, Silverlight, Gears, BrowserPlus ou HTML5.</p>
	</div>
</form>
<br>
<table class="table table-striped table-bordered normal">
	<thead>
		<tr>
			<?php if ($this->uri->segment(3) == 'imagem'): ?>
				<th>Imagem</th>
			<?php else: ?>
				<th>Cadastro</th>
			<?php endif ?>
			<th>Descrição</th>
			<?php if ($this->uri->segment(3) == 'imagem'): ?>
				<th>Destaque</th>
			<?php endif ?>
			<th>Anexo</th>
			<th>Excluir</th>
		</tr>
	</thead>
	<tbody>
		<?php $tipo = ($this->uri->segment(3) == 'imagem' ? '1' : '2'); ?>
		<?php foreach ($arquivos as $row): ?>
			<tr>
				<?php if ($this->uri->segment(3) == 'imagem'): ?>
					<td><img src="<?php echo base_url('imagens/h130_w130_zc2__'.$row->src); ?>" alt="<?php echo $row->alt; ?>"></td>
				<?php else: ?>
					<td>
						<div style="display: none;"><?php echo $row->created; ?></div>
						<?php echo '<div title="'.datetime($row->created, 'txt').'">'.datetime($row->created).'</div>'; ?>
					</td>
				<?php endif ?>
				<td>
					<form action="<?php echo base_url('d/renomear_anexo/'.$row->id.'/'.$tipo.'/'.$controller.'/'.$rotulo) ?>" method="post" name="nome">
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
							<input type="text" value="<?php echo ($tipo == 1) ? $row->alt : $row->arquivo_descricao; ?>" name="nome" class="form-control" />
						</div>
						<button type="submit" class="btn btn-default btn-sm">Salvar</button>
					</form>
				</td>
				<?php if ($this->uri->segment(3) == 'imagem'): ?>
					<td>
						<?php $v = verifica_destaque($rotulo, $row->id); ?>
						<a href="<?php echo base_url('d/destaque/'.$row->id.'/'.$rotulo); ?>" <?php echo $v ? 'disabled="disabled"' : null; ?> class="btn <?php echo $v ? 'btn-success' : 'btn-default'; ?> btn-sm"><b class="icon-star"></b></a>
					</td>
				<?php endif ?>
				<td><?php echo anchor('d/download/'.($tipo == 1 ? 'imagens/'.$row->src : 'arquivos/'.$row->arquivo), '<i class="icon-download"></i> Baixar anexo', 'class="btn btn-default btn-sm"') ?></td>
				<td>
					<a href="<?php echo base_url('d/excluir_anexo/'.$row->id.'/'.$tipo.'/'.$controller.'/'.$rotulo); ?>" title="Excluir" class="btn btn-default btn-sm"><span class="icon-trash-1"></span></a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
	<tfoot>
		<tr>
			<?php if ($this->uri->segment(3) == 'imagem'): ?>
				<th>Imagem</th>
			<?php else: ?>
				<th>Cadastro</th>
			<?php endif ?>
			<th>Descrição</th>
			<?php if ($this->uri->segment(3) == 'imagem'): ?>
				<th>Destaque</th>
			<?php endif ?>
			<th>Anexo</th>
			<th>Excluir</th>
		</tr>
	</tfoot>
</table>