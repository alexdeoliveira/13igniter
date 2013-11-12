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
		acesso('admin', 1);
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
		acesso('admin', 1);

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

			//Para fazer upload de anexo
			//$_POST['arquivo'] = $this->_upload($d);

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

		//Para formulários que precisa de anexo
		//$d->load_extension('htmlform', array('form_template' => 'dmz_htmlform/form_multipart'));
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
		acesso('admin', 1);
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
	 * Upload de anexo
	 * @param  object $object
	 * @return integer id do arquivo
	 */
	/*
	function _upload($object)
	{		
		$file = $object->exists() ? $object->arquivo_id : FALSE ;
		if (isset($_FILES['arquivo']) AND $_FILES['arquivo']['size'] > 0) {
			$this->lang->load('upload', 'pt_BR');
			$this->load->helper('Upload');
			$config = array('allowed_types' => 'mp3',
			 	'max_size'	=>	60000, 'name'	=>	'arquivo');
			$file = upload($config, 2);
			if (isset($file['file_error'])) {
				$this->session->set_flashdata('fail', $file['file_error']);
				redirect($this->controller.'/'.( $object->exists() ? 'editar/'.$object->rotulo : 'cadastrar' ));
			}
		}
		return $file;
	}
	*/

	/**
	 * Anexos
	 * @param string $rotulo
	 */
	/*
	public function p_anexos($rotulo = '')
	{
		acesso('admin', 1);

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
	*/

	/**
	 * Upload de arquivos
	 * @param string $rotulo
	 * @return mixed
	 */
	/*
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
	*/

	/**
	 * Excluir anexo
	 * @param string $rotulo
	 * @param integer id do arquivo
	 */
	/*
	public function p_excluir_anexo($rotulo = '', $id = '')
	{
		acesso('admin', 1);
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
	*/

	/**
	 * Alterar ordem da página
	 * @param object
	 */
	/*
	function _alterar_ordem($pagina, $acao = 'aumentar')
	{
		$ordem_antiga = $pagina->ordem;

		$p = new Model();
		if ($acao == 'aumentar') {
			$p->order_by('ordem', 'desc')->where('ordem <', $ordem_antiga);
		}
		else
		{
			$p->order_by('ordem', 'asc')->where('ordem >', $ordem_antiga);
		}
		$p->get(1);
		if ($p->exists()) {
			$ordem_nova = $p->ordem;
			$p->where('id', $p->id)->update('ordem', $ordem_antiga);
			$pagina->where('id', $pagina->id)->update('ordem', $ordem_nova);

		}
		return;
	}
	*/

	/**
	 * Alterar ordem da página
	 * @param string rótulo
	 * @param string ação
	 */
	/*
	public function p_alterar_ordem($rotulo, $acao = 'aumentar')
	{
		acesso('pagina', 1);

		$p = new Model();
		$p->where('rotulo', $rotulo)->get();
		$this->_alterar_ordem($p, $acao);
		redirect($this->controller.'/listar');
	}
	*/




	/*
	Novas funções de upload para arquivos e imagens com plupload

		public function p_upload($rotulo = '', $tipo_up = '')
	{
		acesso($this->controller, 1);
		// Make sure file is not cached (as it happens for example on iOS devices)
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		// 5 minutes execution time
		@set_time_limit(5 * 60);

		// Uncomment this one to fake upload time
		// usleep(5000);

		// Settings
		//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
		if ($tipo_up == 'imagem') {
			$targetDir = 'file/imagens';
		}
		else {
			$targetDir = 'file/arquivos';
		}

		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds


		// Create target dir
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}

		// Get a file name
		if (!empty($_FILES)) {
			$nome = $_FILES["file"]["name"];
			$nome_md = $_REQUEST["name"];
		}

		if (isset($_REQUEST["name"])) {
			$fileName = $_REQUEST["name"];
		} elseif (!empty($_FILES)) {
			$fileName = $_FILES["file"]["name"];
		} else {
			$fileName = uniqid("file_");
		}

		
		$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

		// Chunking might be enabled
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


		// Remove old temp files	
		if ($cleanupTargetDir) {
			if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			}

			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

				// If temp file is current file proceed to the next
				if ($tmpfilePath == "{$filePath}.part") {
					continue;
				}

				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
		}	


		// Open temp file
		if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}

			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		} else {	
			if (!$in = @fopen("php://input", "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		}

		while ($buff = fread($in, 4096)) {
			fwrite($out, $buff);
		}

		@fclose($out);
		@fclose($in);

		// Check if file has been uploaded
		if (!$chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off
			rename("{$filePath}.part", $filePath);
		}
		if (!empty($_FILES)) {
			$p = new Noticia();
			$p->where('rotulo', $rotulo)->get();
			if ($tipo_up == 'imagem') {
				$i = new Imagem();
				$i->src = $nome_md;
				$i->alt = $nome;

				$i->save($p);
			}
			else {
				$a = new Arquivo();
				$a->arquivo = $nome_md;
				$a->tipo = 1;
				$ext = pathinfo('file/arquivos/'.$nome_md, PATHINFO_EXTENSION);
				$a->ext = '.'.$ext;
				$tam = filesize('file/arquivos/'.$nome_md);
				$a->size = $tam;
				$a->save($p);
			}
		}

		// Return Success JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
	}

	public function p_anexos($tipo = '', $rotulo = '')
	{
		acesso('admin', 1);

		$c = new Noticia();
		$this->data['data'] = $c->where(array('rotulo' => $rotulo))->get();

		if (!$c->exists()) {
			redirect($this->controller.'/listar');
		}

		if ($tipo == '' or $rotulo == '') {
			show_404(current_url());
		}

		if ($tipo == 'imagem') {
			$a = new Imagem();
			$this->data['title'] = 'Imagens';
			$filtros = 'filters : [
							{title : "Image files", extensions : "jpg,gif,png"},
						],';
		}
		elseif ($tipo == 'arquivo') {
			$a = new Arquivo();
			$this->data['title'] = 'Arquivos';
			$filtros = false;
		}
		else {
			show_404(current_url());
		}

		$a->where_related($c)->get();

		$this->data['arquivos'] = $a;
		$this->data['page'] = 'admin/plupload';
		$this->data['controller'] = $this->controller;
		$this->data['rotulo'] = $rotulo;
		$this->data['btn_group'] = array(anchor($this->controller.'/listar', 'Voltar', 'class="btn btn-default"'));

		$this->data['breadcrumb'] = array(
			anchor($this->controller.'/listar', 'Notícias cadastradas'),
			anchor($this->controller.'/editar/'.$rotulo, $c->titulo),
			'Anexos',
		);

		$this->data['assets_js'] = array(
			'<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>',
			'<script type="text/javascript" src="'.assets_url('plupload/js/plupload.full.js').'"></script>',
			'<script type="text/javascript" src="'.assets_url('plupload/js/i18n/pt-br.js').'"></script>',
			'<script type="text/javascript" src="'.assets_url('plupload/js/jquery.plupload.queue/jquery.plupload.queue.js').'"></script>',
			'
				<script type="text/javascript">
				$(function() {
					$("#uploader").pluploadQueue({
						runtimes : "gears,html5,html4,silverlight,browserplus,flash",
						url : "'.base_url($this->controller."/upload/".$c->rotulo."/".$tipo).'",
						max_file_size : "10mb",
						unique_names : true,

						preinit: {
							UploadComplete: function(up, file) {
								window.location.reload();
							},
						},
					
						'.$filtros.'

						flash_swf_url : "'.assets_url("plupload/js/Moxie.swf").'",

						silverlight_xap_url : "'.assets_url("plupload/js/Moxie.xap").'"
					});

					$("form.plupload23").submit(function(e) {
						var uploader = $("#uploader").pluploadQueue();

						if (uploader.files.length > 0) {
							uploader.bind("StateChanged", function() {
								if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
									$("form")[0].submit();
								}
							});

							uploader.start();
						} else {
							alert("You must queue at least one file.");
						}
						return false;
					});
				});
				</script>
			'
		);

		$this->data['assets_css'] = array('<link rel="stylesheet" href="'.assets_url('plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css').'">');

		$this->load->view('admin/index', $this->data);
	}



	*/

}

// End of file