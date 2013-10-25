	<?php $this->load->view('admin/head_section'); ?>
	<?php
	/**
	* View genérica para listar registros na interface administrativa.
	*
	* As colunas exibidas no datatable são determinadas pelo array $list_fields.
	* Os dados vêm no array de objetos $data.
	*/
	?>
	<table cellpadding="0" cellspacing="0" border="0" class="table normal table-striped table-bordered table-hover">
	<thead>
		<tr>
				<?php foreach ($list_fields as $row) : ?>
						<th><?php echo $row; ?></th>
				<?php endforeach; ?>
				<th>Cadastro</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($dados as $row) : ?>
				<tr>
						<?php foreach ($list_fields as $field => $value) : ?>
								<td>
										<?php if ( ! empty($row->$field) AND ($field === 'created' OR $field === 'updated')) : ?>
												<div style="display: none;"><?php echo $row->$field; ?></div>
												<?php echo '<div title="'.datetime($row->$field, 'txt').'">'.datetime($row->$field).'</div>'; ?>
										<?php elseif ($field === 'situacao') : ?>
												<?php echo $row->$field === '1' ? 'Ativo' : 'Inativo'; ?>
										<?php elseif ($field === 'destaque') : ?>
												<?php echo $row->$field === '1' ? 'Sim' : 'Não'; ?>
										<?php elseif ( ! empty($row->$field) AND $field === 'html') : ?>
												<?php echo $value; ?>
										<?php elseif ( ! empty($row->$field) AND $field === 'valor') : ?>
												<?php echo number_format($row->$field, 2, ',', '.'); ?>
										<?php elseif ( $field === 'arquivo_count') : ?>
												<?php echo anchor($controller.'/anexos/'.($row->rotulo ? $row->rotulo : $row->id), 'Anexos ('.$row->$field.')', 'class="btn"'); ?>
										<?php elseif ( $field === 'imagem_count') : ?>
												<?php echo anchor($controller.'/imagens/'.($row->rotulo ? $row->rotulo : $row->id), 'Imagens ('.$row->$field.')', 'class="btn"'); ?>
										<?php elseif ( ! empty($row->$field) AND $field === 'ordem') : ?>
											<div class="hide"><?php echo $row->$field; ?></div>
											<div class="btn-group">
												<a href="<?php echo base_url($controller.'/alterar_ordem/'.$row->rotulo.'/aumentar'); ?>" class="btn btn-mini" title="Pra cima"><i class="icon-up-open"></i></a>
												<a href="<?php echo base_url($controller.'/alterar_ordem/'.$row->rotulo.'/diminuir'); ?>" class="btn btn-mini" title="Pra baixo"><i class="icon-down-open"></i></a>
											</div>
										<?php else : ?>
												<?php echo $row->$field; ?>
										<?php endif; ?>
								</td>
						<?php endforeach; ?>
						<td>
								<div class="btn-group">
										<?php echo anchor($controller.'/'.(isset($link_editar) ? $link_editar : 'editar').'/'.( $row->rotulo ? $row->rotulo : $row->id), '<span class="icon-pencil"></span>', 'title="Editar" class="btn btn-default"'); ?>
										<a href="#deleteModal" title="Excluir" data-url="<?php echo base_url($controller.'/'.(isset($link_excluir) ? $link_excluir : 'excluir').'/'.( ($row->rotulo) ? $row->rotulo : $row->id ) ); ?>" class="btn btn-default delete" data-toggle="modal"><span class="icon-trash-1"></span></a>
								</div>
						</td>
				</tr>
		<?php endforeach; ?>
	</tbody>
	</table>
	<?php $this->load->view('admin/modal_delete');?>
