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
			<th>Cadastro</th>
			<th>Descrição</th>
			<th>Anexo</th>
			<th>Excluir</th>
		</tr>
	</thead>
	<tbody>
		<?php $tipo = ($this->uri->segment(3) == 'imagem' ? '1' : '2'); ?>
		<?php foreach ($arquivos as $row): ?>
			<tr>
				<td>
					<div style="display: none;"><?php echo $row->created; ?></div>
					<?php echo '<div title="'.datetime($row->created, 'txt').'">'.datetime($row->created).'</div>'; ?>
				</td>
				<td>
					<form action="<?php echo base_url('d/renomear_anexo/'.$row->id.'/'.$tipo.'/'.$controller.'/'.$rotulo) ?>" method="post" name="nome">
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
							<input type="text" value="<?php echo ($tipo == 1) ? $row->alt : $row->arquivo_descricao; ?>" name="nome" class="form-control" />
						</div>
						<button type="submit" class="btn btn-default btn-sm">Salvar</button>
					</form>
				</td>
				<td><?php echo anchor('d/download/'.($tipo == 1 ? 'imagens/'.$row->src : 'arquivos/'.$row->arquivo), '<i class="icon-download"></i> Baixar anexo', 'class="btn btn-default btn-sm"') ?></td>
				<td>
					<a href="<?php echo base_url('d/excluir_anexo/'.$row->id.'/'.$tipo.'/'.$controller.'/'.$rotulo); ?>" title="Excluir" class="btn btn-default btn-sm"><span class="icon-trash-1"></span></a>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
	<tfoot>
		<tr>
			<th>Cadastro</th>
			<th>Descrição</th>
			<th>Anexo</th>
			<th>Excluir</th>
		</tr>
	</tfoot>
</table>