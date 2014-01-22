<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class D extends CI_Controller {

	function __construct() {
		parent::__construct();
		log_message('debug', 'D Controller inicializada.');
		$this->data['controller'] = $this->controller = strtolower(__CLASS__);
	}

	function _remap($method = FALSE, $params = array()) {
		if (method_exists($this, 'p_'.$method)) {
			return call_user_func_array(array($this, 'p_'.$method), $params);
		}
		else {
			array_unshift_assoc($params, NULL, $method);
			return call_user_func_array(array($this, 'p_exibir'), $params);
		}
	}

	function p_exibir() {
		show_404(current_url());
	}

	function p_renomear_anexo($id = FALSE, $tipo = FALSE, $contro = '', $pagina = '') {
		acesso($this->controller, 1);
		if (!$id or !$tipo or !$pagina) {
			show_404(current_url());
		}
		if ($_POST) {
			if ($tipo == 1) {
				$i = new Imagem();
				$i->where('id', $id)->get();
				if (!$i->id) {
					$this->session->set_flashdata('fail', 'Erro ao renomear o registro.');
					redirect($contro.'/anexos/imagem/'.$pagina);
				}
				else {
					$i->alt = $this->input->post('nome');
					$i->where('id', $id)->update('alt', $i->alt);
					$this->session->set_flashdata('success', 'Renomeado com sucesso.');
					redirect($contro.'/anexos/imagem/'.$pagina);
				}
			}
			elseif ($tipo == 2) {
				$a = new Arquivo();
				$a->where('id', $id)->get();
				if (!$a->id) {
					$this->session->set_flashdata('fail', 'Erro ao renomear o registro.');
					redirect($contro.'/anexos/arquivo/'.$pagina);
				}
				else {
					$a->arquivo_descricao = $this->input->post('nome');
					$a->where('id', $id)->update('arquivo_descricao', $a->arquivo_descricao);
					$this->session->set_flashdata('success', 'Renomeado com sucesso.');
					redirect($contro.'/anexos/arquivo/'.$pagina);
				}
			}
		}
	}

	function p_excluir_anexo($id = FALSE, $tipo = FALSE, $contro = '', $pagina = '') {
		acesso($this->controller, 1);
		if (!$id or !$pagina) {
			show_404(current_url());
		}

		if ($tipo == 1) {
			$i = new Imagem();
			$i->where('id', $id)->get();

			unlink($this->config->item('img_directory').$i->src);
			if ($i->delete()) {
				$this->session->set_flashdata('success', 'Excluído com sucesso.');
				redirect($contro.'/anexos/imagem/'.$pagina);
			}
		}
		elseif ($tipo == 2) {
			$i = new Arquivo();
			$i->where('id', $id)->get();

			unlink($this->config->item('file_directory').$i->arquivo);
			if ($i->delete()) {
				$this->session->set_flashdata('success', 'Excluído com sucesso.');
				redirect($contro.'/anexos/arquivo/'.$pagina);
			}
		}
		else {
			show_404(current_url());
		}
	}

	function p_download($tipo = FALSE, $nom_a = '') {
		if ($tipo == FALSE or $nom_a == '') {
			show_404(current_url());
		}
		if ($tipo == 'imagens') {
			$i = new Imagem();
			$i->where('src', $nom_a)->get();
			if (!$i->id) {
				show_404(current_url());
			}
			$ext = pathinfo($this->config->item('img_directory').$i->src, PATHINFO_EXTENSION);
			$nome = $i->alt.'.'.$ext;
			$arquivo_b = $this->config->item('img_directory').$nom_a;
		}
		elseif ($tipo == 'arquivos') {
			$a = new Arquivo;
			$a->where('arquivo', $nom_a)->get();
			if (!$a->id) {
				show_404(current_url());
			}
			if ($a->arquivo_descricao != NULL) {
				$nome = $a->arquivo_descricao.$a->ext;
			}
			$arquivo_b = $this->config->item('file_directory').$nom_a;
		}
		else {
			show_404(current_url());
		}

		header('Content-Description: File Transfer');
		if ($tipo == 'imagens') {
			header('Content-Disposition: attachment; filename="'.$nome.'"');
		}
		header('Content-Type: application/octet-stream');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($arquivo_b));
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Expires: 0');

		readfile($arquivo_b);
	}
}