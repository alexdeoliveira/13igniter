<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Template de controller
 */
class Remove_img_sem_uso extends CI_Controller {

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
			return call_user_func_array(array($this, 'p_index'), $params);
		}
	}

	/*
	| Função para remover as imagens que não estão em uso
	| Verifica se os arquivos da pasta img ($this->config->item('img_directory'))
	| Pesquisa no banco de se as imagens estão cadastradas
	| Caso não estão deleta a imagem da pasta
	*/

	function p_index()
	{
		// Para funcionar é necessário comentar a linha abaixo (redirect())
		redirect();

		$pasta = $this->config->item('img_directory');

		if(is_dir($pasta)) {
			$diretorio = dir($pasta);
			while($arquivo = $diretorio->read()) {
				if ($arquivo != '.' && $arquivo != '..') {
					$i = new Imagem();
					$i->where('src', $arquivo)->get();

					if (!$i->id) {
						unlink ($pasta.$arquivo);
					}
				}
			}
			$diretorio->close();
		}
		else {
			echo 'A pasta não existe.';
		}
	}
}