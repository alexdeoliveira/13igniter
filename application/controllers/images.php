<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model das imagens
 */

class Images extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		log_message('debug', 'Class '.__CLASS__.' initialized.');
		$this->controller = strtolower(__CLASS__);
	}

	/**
	 * Método para upload de imagens através do editor redactor
	 */
	public function upload()
	{
		if (isset($_FILES['file']) AND $_FILES['file']['size'] > 0) 
		{
			$config = array('max_size' => 15000, 'name' => 'file');
			$this->lang->load('upload', 'pt_BR');
			$this->load->helper('Upload');
			$image = upload($config);
			$i = new Imagem();
			$i->where(array('src' => $image))->get();
			if ($i->exists())
			{
				log_message('debug', 'Upload da imagem '.$image.' através do redactor.');
				echo json_encode(array('filelink' => static_base_url('imagens/'.$image)));
			}
			else
			{
				log_message('error', 'Falha ao fazer upload da imagem via redactor: '.$image['file_error']);
				echo json_encode(array('error' => $image['file_error']));
			}
		}
		return;
	}

}

/* End of file images.php */
/* Location: ./application/controllers/images.php */