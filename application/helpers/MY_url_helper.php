<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * URL Base dos Assets
 *
 * Retorna a URL base dos assets, levando em conta as configurações
 * assets_directory e assets_version.
 *
 * A principal utilidade disso é poder utilizar "pseudo-versões" no
 * diretório de assets, para invalidar os arquivos que ficaram em caches,
 * quando necessário.
 *
 * Os assets devem ser referenciados da seguinte forma, por exemplo:
 * assets_url('css/arquivo123.css')
 *
 * @params string $uri Caminho do arquivo dentro do diretório de assets
 * @return string URL do arquivo de asset
 */
if ( ! function_exists('assets_url'))
{
	function assets_url($uri = '')
	{
		$CI =& get_instance();
		$CI->load->helper('url');
		return base_url(
			(rtrim($CI->config->item('assets_directory'), '/'))
			.'/'.$CI->config->item('assets_version')
			.'/'.$uri
		);
	}
}

/**
 * Cria rótulo a partir de um título, nome etc.
 *
 * @param string $str String a ser transformada em rótulo
 * @return string Rótulo
 */
if ( ! function_exists('rotulo'))
{
	function rotulo($str)
	{
		$CI =& get_instance();
		$CI->load->helper('url');
		$CI->load->helper('text');
		return substr(strtolower(url_title(convert_accented_characters(character_limiter($str, 60, NULL)), '_')), 0, 255);
	}

}

/*
 * Retorna a URL base das imagens, levando em conta as configurações de img_directory
 * @params string $uri Caminho da imagem dentro do diretório de imagens, string $tam tamanho da imagem default caso não tever passado o uri
 * @return string URL da imagem
*/
if ( ! function_exists('imagens_url'))
{
	function imagens_url($uri = '', $tam = 'default_thumb')
	{
		$CI =& get_instance();
		if(empty($uri))
		{
			return base_url($CI->config->item($tam));
		}
		return base_url(
			(rtrim($CI->config->item('img_directory'), '/'))
			.'/'.$uri
		);
	}
}

/**
 * Cria rótulo a partir de um título, nome verificando se já não existe um igual no banco.
 *
 * @param string $str String a ser transformada em rótulo
 * @param string $field nome do model e nome do campo separado por ponto
 * @param integer id do item
 * @return string Rótulo
 */
if ( ! function_exists('label_generator'))
{
	function label_generator($str, $field, $id = FALSE)
	{
		$CI =& get_instance();

		list($model, $field)=explode('.', $field);
		$ok = FALSE;
		$char = 1;
		$label = $str = rotulo($str);
		while ($ok != TRUE) 
		{
			$c = new $model;
			$c->where($field, $label);
			if ($id) 
			{
				$c->where_not_in('id', $id);
			}
			$c->get();
			if (!$c->exists()) 
			{
				$ok = TRUE;
			}
			else
			{
				$label = rotulo($char.'_'.$str);
				$char ++;
			}
		}
		return $label;
	}
}

/**
 * Static Base URL
 * 
 * Retorna o base_url para conteudos estaticos, no padrao
 * http://static.dominio, ou https://static.dominio, sendo a string "static."
 * definida por $config['static_url_prefix'].
 *
 * @params string $uri Caminho relativo, opcional
 * @return string Caminho completo usando dominio de conteudos estaticos
 */
if ( ! function_exists('static_base_url'))
{
	function static_base_url($uri = '')
	{
		$CI =& get_instance();
		$url = $CI->config->base_url($uri);
		if ($CI->config->item('static_url_prefix'))
		{
			$url = str_replace('www.', '', $url);
			$url = str_replace('://', '://'.$CI->config->item('static_url_prefix'), $url);
		}
		return $url;
	}
}


/**
 * Retorna o caminho da pasta do site 
 */

if (!function_exists('url_redactor')) {
	function url_redactor()
	{
		if (ENVIRONMENT == 'production') {
			return;
		}

		$url = explode('http://'.$_SERVER["SERVER_NAME"], base_url());

		return $url[1];
	}
}

// End of file