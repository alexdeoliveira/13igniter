<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Template de controller
 */
class Example extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		log_message('debug', 'Class '.__CLASS__.' initialized.');
		$this->data['controller'] = $this->controller = strtolower(__CLASS__);
	}

	/**
	 * Remap
	 *
	 * Recebe todas as chamadas de funções deste controller e procede conforme
	 * o seguinte:
	 * - Se não for passada nenhuma função, chama p_index.
	 * - Se for passada alguma função que existe nesta classe, chama ela e
	 * repassa os parâmetros originais.
	 * - Se for passado qualquer outro valor, chama p_exibir passando
	 * o valor como parâmetro.
	 */
	function _remap($method = FALSE, $params = array())
	{
		if (method_exists($this, 'p_'.$method))
		{
			return call_user_func_array(array($this, 'p_'.$method), $params);
		}
		else
		{
			array_unshift_assoc($params, NULL, $method);
			return call_user_func_array(array($this, 'p_exibir'), $params);
		}
	}

	/**
	 * Exibe os registros na interface pública
	 */
	function p_index()
	{
		$this->p_list();
	}


	/**
	 * Exibe um registro na interface pública
	 */
	function p_exibir($label = '')
	{
		echo $label;
	}

	/**
	 * Prepara uma view genérica para exibir os registros em forma de tabela
	 */
	function p_listar()
	{
		acesso('root', 1);
		$this->data['list_fields'] = array(
			'created' 	=> 'Data Cadastro',
			'updated' 	=> 'Data Edição',
			'nome'		=> 'Nome',
		);
		$this->data['title'] = 'Título';
		$this->data['page'] = 'admin/lista';

		$dados = new Model();
		$this->data['dados'] = $dados->get();

		$this->data['btn_group'] = array(anchor($this->control.'/cadastrar', 'Novo registro', 'class="btn brn-default"'));

		$this->data['breadcrumb'] = array(
			$this->data['title'],
		);

		$this->load->view('admin/index', $this->data);
	}

	/**
	 * Chama a função de edição, sem parâmetros
	 */
	function p_cadastrar()
	{
		$this->p_editar();
	}

	/**
	 * Cadastrar ou editar um registro
	 *
	 * @param string $rotulo
	 */
	function p_editar($rotulo = '')
	{
		acesso('root', 1);

		$d = new Model();
		$this->data['data'] = $d->where('rotulo', $rotulo)->get();
		$this->data['page'] = 'admin/cadastro';

		if ($d->exists())
		{
			$this->data['title'] = 'Alterar: '.$d->nome;
			$this->data['url'] = $this->controller.'/editar/'.$rotulo;
		}
		else
		{
			$this->data['title'] = 'Cadastrar';
			$this->data['url'] = $this->controller.'/cadastrar';
		}

		$this->data['breadcrumb'] = array(
			anchor($this->controller.'/listar', 'Título'),
			$this->data['title'],
		);

		if ($_POST)
		{
			$this->lang->load('form_validation', 'pt_BR');

			$_POST['rotulo'] = label_generator($_POST['nome'], 'Model.rotulo', $d->id);

			$info = $d->from_array($_POST, array(
				'name',
				'description',
				'rotulo',
			));
			if ($d->save($info))
			{
				$this->session->set_flashdata('success', 'Registro efetuado com sucesso!');
				redirect($this->controller.'/editar/'.$d->rotulo);
			}
		}

		$d->load_extension('htmlform');
		$this->data['form_fields'] = array(
			'name' => array('class' => 'form-control'),
			'description' => array('class' => 'form-control'),
		);

		$this->data['btn_group'] = array(
			anchor($this->controller.'/listar', 'Voltar', 'class="btn btn-default"'), 
			anchor($this->controller.'/cadastrar', 'Novo registro', 'class="btn btn-default"')
		);

		$this->load->view('admin/index', $this->data);
	}

	/**
	 * Excluir um registro
	 *
	 * @param string $rotulo
	 */
	function p_excluir($rotulo = '')
	{
		acesso('root', 1);
		if ( ! empty($rotulo))
		{
			$d = new Model();
			$d->where('rotulo', $rotulo)->get();
			if ($d->delete())
			{
				$this->session->set_flashdata('success', 'Registro excluído com sucesso.');
			}
			else
			{
				$this->session->set_flashdata('fail', 'Ocorreu um erro ao excluir o registro. Por favor tente novamente ou contate o administrador do sistema.');
			}
		}

		redirect($this->controller.'/listar');
	}

	/**
	 * Anexos
	 * @param string $rotulo
	 */
	public function p_anexos($rotulo = '')
	{
		acesso('root', 1);

		$c = new Model();
		$this->data['data'] = $c->where(array('rotulo' => $rotulo))->get();

		if (!$c->exists()) {
			redirect($this->controller.'/listar');
		}

		$a = new Arquivo();
		//$a = new Imagem();
		if ($this->input->post('descricao')) {
			if ($a->where('id', $this->input->post('id'))->update('descricao', $this->input->post('descricao'))) {
				$this->session->set_flashdata('success', 'Descrição foi salva!');
				redirect($this->controller.'/anexos/'.$rotulo);
			}
			$a->clear();
		}

		$this->data['arquivos'] = $a->where_related($c)->get();

		$this->data['title'] = 'Anexos';
		$this->data['page'] = 'admin/plupload';
		$this->data['controller'] = $this->controller;

		$this->data['btn_group'] = array(anchor($this->controller.'/listar', 'Voltar', 'class="btn"'));

		$this->data['breadcrumb'] = array(
			anchor($this->controller.'/listar', 'Título'),
			anchor($this->controller.'/editar/'.$rotulo, $c->name),
			'Anexos',
		);

		$this->load->view('admin/index', $this->data);
	}

	/**
	 * Upload de arquivos
	 * @param string $rotulo
	 * @return mixed
	 */
	public function p_upload($rotulo = '')
	{
		if (acesso('root')) {
			$c = new Model();
			$c->where(array('rotulo' => $rotulo))->get();
			if ($c->exists()) {
				$config = array('allowed_types' => 'zip|pdf|doc|docx|jpg|gif|png|rar', 
					'max_size' => 20000, 'name' => 'arquivo', 'description' => isset($_FILES['arquivo']) ? $_FILES['arquivo']['name'] : '',
				);
				$this->load->helper('Upload');
				$arquivo = upload($config, 2, $c->rotulo);
				if(!isset($arquivo['file_error'])) {
					$a = new Arquivo();
					//$a = new Imagem();
					$a->where('id', $arquivo)->get();
					$c->save($a);
					$this->session->set_flashdata('success', 'Registro efetuado com sucesso');
					return true;
				}
				$this->session->set_flashdata('fail', $arquivo['file_error']);
			}
		}
		return FALSE;
	}

	/**
	 * Excluir anexo
	 * @param string $rotulo
	 * @param integer id do arquivo
	 */
	public function p_excluir_anexo($rotulo = '', $id = '')
	{
		acesso('root', 1);
		$a = new Arquivo();
		$a->where(array('id' => $id))
			->where_related('controller', 'rotulo', $rotulo)->get();
		if ($a->exists()) {
			if ($a->delete()) {
				$this->session->set_flashdata('success', 'Anexo foi excluído');
				redirect($this->controller.'/anexos/'.$rotulo);
			}
		}
		$this->session->set_flashdata('fail', 'Não foi possível excluir anexo');
		redirect($this->controller.'/anexos/'.$rotulo);
	}

}

// End of file