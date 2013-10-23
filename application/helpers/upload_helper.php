<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * Upload de arquivos
 *
 * @access	public
 * @param	array		$config
 * @param	integer		local do upload do arquivo 1:image 2:arquivo
 * #return	array 		
 */
if ( ! function_exists('upload'))
{
	function upload( $config = FALSE, $type = 1, $rotulo = '')
	{
		$CI =& get_instance();
		//extensão do arquivo
		if ( !isset($config['allowed_types']) or $config['allowed_types'] == '' )
		{
				$config['allowed_types'] = 'jpg|png|gif';
		}
		//Diretório: 1-images | 2-arquivos
		if ( $type == 1 )
		{
				$config['upload_path'] = $CI->config->item('img_directory');
		}
		elseif($type == 2)
		{
				$config['upload_path'] = $CI->config->item('file_directory');
		}
		//tamanho máximo do arquivo
		if ( !isset($config['max_size']) or $config['max_size'] == '' )
		{
				$config['max_size'] = 60000;
		}

		//Se não for passado o rótulo no parâmetro recebe um código md5 para o seu nome
		$rotulo = $rotulo ? $rotulo : md5(date('Y,m,a')).md5(time()) ;

		//Pega informações do arquivo upado
		$ext = pathinfo($_FILES[(isset($config['name']) ? $config['name'] : 'userfile')]['name']);

		//Gerar nome para o arquivo
		$cond = FALSE;
		while($cond != TRUE)
		{
				$codigo = gera_codigo();
				$file_original_name = $rotulo.'_'.$codigo.'.'.$ext['extension'];
				if(verifica_nome_imagem($file_original_name) == TRUE)
				{
						$cond = TRUE;
						$config['file_name'] = $rotulo.'_'.$codigo;
				}
		}
		$CI->load->library('upload', $config);

		//Se não está setado o índice description na variável insere vazio
		if (!isset($config['description']))
		{
				$config['description'] = '';
		}


		$CI->upload->initialize($config);

		//Se não estiver setado o id insere NULL
		if (!isset($config['id']) or (isset($config['id']) and is_array($config['id']) and sizeof($config['id']) == 0))
		{
				$config['id'] = '';
		}

		if(!isset($config['tipo']))
		{
				$config['tipo'] = 3;
		}

		//carrega arquivo
		if (!$CI->upload->do_upload(isset($config['name']) ? $config['name'] : 'userfile' ))
		{
				//se a descrição e o id estão setados e type = 1 insere uma imagem
				if (isset($config['description']) and $config['id'] and $type == 1)
				{
						return image_insert(FALSE, $config['description'], $config['id'], $config['tipo'], $rotulo);
				}//se a descrição e o id estão setados e type = 2 insere um arquivo
				else
				{
						$CI->lang->load('upload', 'pt_BR');
						$data['file_error'] = $CI->upload->display_errors('', '');
						return $data;
				}
		}
		else
		{
				//retorna id do arquivo
				return ($type == 1) ? image_insert($CI->upload->data(), $config['description'], $config['id'], $config['tipo']) : arquivo_insert($CI->upload->data(), $config['description'], $config['id']) ;
		}
	}
}

/**
 * Redimensiona a imagem e insere no banco
 *
 * @access	public
 * @param	object		$file
 * @param	string		$image_descricao descrição da imagem
 * @param 	integer		$tipo da imagem
 * @return	integer		$id da imagem
 */
if ( ! function_exists('image_insert'))
{
	function image_insert( $file = FALSE, $image_descricao = FALSE, $id = FALSE, $tipo = FALSE)
	{
		$i = new Imagem();
		$i->where('id', $id)->get();
		if($tipo == FALSE)
		{
				$tipo = 3;
		}
		if (!$file)
		{
				//Se já existe uma imagem retorna o id da mesma e altera sua descrição
				if ($i->exists())
				{
						$i->alt = $image_descricao;
						$i->save();
						return $i->id;
				}
				else
				{
						return FALSE;
				}
		}

		//Se não existir a imagem, instancia novamente o objeto
		if (!$i->exists()) {
				unset($i);
				$i = new Imagem();
		}

		$CI =& get_instance();
		
		//Verifica se é realmente uma imagem
		if ( ! $file['is_image'])
		{
				return FALSE;
		}


		$image_original_name = $file['raw_name'].$file['file_ext'];
		$i->src = $image_original_name;
		$i->alt = $image_descricao;
		$i->prefeitura_id = $CI->session->userdata('prefeitura_id');
		//$i->tipo = $tipo;
		return ($i->save()) ? $i->src : FALSE ;
	}
}

/**
*
* Exclui uma imagem do banco e do diretório através da id da imagem
*
* @author Aléx de Oliveira
* @param	integer $id da imagem
* @return	boolean true ou false
*
**/
if ( ! function_exists('image_delete'))
{
	function image_delete($id = FALSE)
	{
		$i = new Imagem();
		$i->where('id', $id)->get();
		if ($i->exists())
		{
			$CI =& get_instance();
			$path = getcwd().'/'.$CI->config->item('img_directory');
			unlink ($path.$i->thumb);
			unlink ($path.$i->pequena);
			unlink ($path.$i->normal);
			unlink ($path.$i->big);
			if (ENVIRONMENT == 'development')
			{
				unlink ($path.$i->original);
			}


			$i->delete();
		}
		return;
	}
}

/**
 * Faz o upload de um arquivo
 *
 * @access	public
 * @param	object		$file
 * @param	string		$arquivo_descricao descrição do arquivo
 * @return	integer		$id do arquivo
 */
if ( ! function_exists('arquivo_insert'))
{
	function arquivo_insert( $file = FALSE, $arquivo_descricao = FALSE, $id = FALSE )
	{
		$i = new Arquivo();
		
		$i->where('id', $id)->get();
		if (!$file)
		{
			//Se já existe um arquivo retorna o id da mesma e altera sua descrição
			if ($i->exists())
			{
				$i->arquivo_descricao = $arquivo_descricao;
				$i->save();
				return $i->id;
			}
			else
			{
				return FALSE;
			}
		}

		$CI =& get_instance();

		$i->arquivo = $file['file_name'];
		$i->ext = $file['file_ext'];
		$i->size = $file['file_size'];
		$i->tipo = 1;
		$i->usuario_id = $CI->session->userdata('usuario_id'); 
		$i->arquivo_descricao = $arquivo_descricao;
		return ($i->save()) ? $i->id : FALSE ;
	}
}

/**
 *
 * Exclui um arquivo do banco e do diretório através do id do arquivo
 *
 * @author Aléx de Oliveira
 * @param	integer $id do arquivo
 * @return	boolean true ou false
 *
 **/
if ( ! function_exists('arquivo_delete'))
{
	function arquivo_delete($id = FALSE)
	{
		$i = new Arquivo();
		$i->where('id', $id)->get();
		if ($i->exists())
		{
			$CI =& get_instance();
			$path = getcwd().'/'.$CI->config->item('file_directory');
			unlink ($path.$i->arquivo);
			$i->delete();
		}
		return;
	}
}

/**
 *
 * Verifica se existe uma imagem com o mesmo nome cadastrado
 *
 * @author Alex Golle
 * @param	string $nome  nome do imagem
 *
 **/
if( ! function_exists('verifica_nome_imagem'))
{
	function verifica_nome_imagem($nome = FALSE)
	{
		$i = new Imagem();
		$i->where('src', $nome)->get();
		if ($i->exists())
		{
			return FALSE;
		}
		return TRUE;
	}
}

/**
 *
 * Gera um codigo rand com letras e numero com tamaho de 5 digitos
 * @author Alex Golle
 **/
if( ! function_exists('gera_codigo'))
{
	function gera_codigo()
	{
		$rand = '';
		$chars = 'bcdfghjklmnprstvwxzaeiou';
		for ($i=0; $i<5; $i++)
		{
			$rand .= ($i%2) ? mt_rand(1, 9) : $chars[mt_rand(0, 23)];
		}
		return $rand;
	}
}

/**
 * Valida as dimensões dos tamanhos de uma imagem
 * @param	array
 * @return	boolean
 */
if( ! function_exists('valida_dimensoes'))
{
	function valida_dimensoes($config)
	{
		if (!isset($config['name'])) {
			return false;
		}

		$name = $config['name'];
		$w_max = isset($config['w_max']) ? $config['w_max'] : '100000'; //Largura máximo da imagem
		$w_min = isset($config['w_min']) ? $config['w_min'] : 0; //Largura mínimo da imagem
		$h_max = isset($config['h_max']) ? $config['h_max'] : 100000; //Altura máximo da imagem
		$h_min = isset($config['h_min']) ? $config['h_min'] : 0; //Altura mínimo da imagem

		list($width, $height, $type, $attr) = getimagesize($_FILES[$name]['tmp_name']);

		if(($width >= $w_min and $width <= $w_max) and ($height >= $h_min and $height <= $h_max))
		{
			return TRUE;
		}
		return false;

	}
}

/**
 * Recorta uma imagem através da id
 * @param	integer id
 * @return	boolean
 */
if( ! function_exists('recortar_imagem'))
{
	function recortar_imagem($id = FALSE)
	{
		if (!$id) {
			return false;
		}

		$i = new Imagem();
		$i->where('id', $id)->get();
		if (!$i->exists()) {
			return false;
		}

		//Se não for passado o rótulo no parâmetro recebe um código md5 para o seu nome
		$rotulo = md5(date('Y,m,a')).md5(time());

		//Gerar nome para o arquivo
		$cond = FALSE;
		while($cond != TRUE)
		{
			$image_original_name = $rotulo.'.jpg';
			if(verifica_nome_imagem($image_original_name) == TRUE)
			{
				$cond = TRUE;
				$novo_thumb = $rotulo.'_thumb.jpg';
				$novo_pequena = $rotulo.'_pequena.jpg';
			}
		}

		$CI =& get_instance();
		$CI->load->library('image_lib');

		//Excluir do diretório as imagens de tamanho pequena e thumb
		unlink($CI->config->item('img_directory').$i->pequena);
		unlink($CI->config->item('img_directory').$i->thumb);

		$config['source_image'] = $CI->config->item('img_directory').$i->normal;
		$config['new_image'] = $CI->config->item('img_directory').$novo_pequena;
		$config['maintain_ratio'] = FALSE;
		$config['master_dim'] = 'width';
		$config['width'] = $_POST['width'];
		$config['height'] = $_POST['height'];
		$config['x_axis'] = $_POST['x'];
		$config['y_axis'] = $_POST['y'];
		$CI->image_lib->clear();
		$CI->image_lib->initialize($config);
		$CI->image_lib->crop();

		$config['source_image'] = $CI->config->item('img_directory').$novo_pequena;
		$config['new_image'] = $CI->config->item('img_directory').$novo_pequena;
		$config['maintain_ratio'] = FALSE;
		$config['master_dim'] = 'width';
		$config['width'] = $CI->config->item('img_pequena_size');
		$config['height'] = $CI->config->item('img_pequena_size');
		$CI->image_lib->clear();
		$CI->image_lib->initialize($config);
		$CI->image_lib->resize();

		$config['source_image'] = $CI->config->item('img_directory').$novo_pequena;
		$config['new_image'] = $CI->config->item('img_directory').$novo_thumb;
		$config['maintain_ratio'] = FALSE;
		$config['master_dim'] = 'width';
		$config['width'] = $CI->config->item('img_thumb_size');
		$config['height'] = $CI->config->item('img_thumb_size');
		$CI->image_lib->clear();
		$CI->image_lib->initialize($config);
		$CI->image_lib->resize();

		$novas_imagens = array('thumb' => $novo_thumb, 'pequena' => $novo_pequena );

		if($i->where('id', $id)->update($novas_imagens))
		{
			return $novas_imagens;
		}

		return FALSE;

	}
}

/**
 * Converte as tags de imagens do conteúdo para ser utilizado o timthumb
 * @param string conteúdo
 * @param object para fazer a relação
 * @param string Alt da imagem
 */
if ( ! function_exists('redactor_convert_imagens'))
{
	function redactor_convert_imagens($field, $object, $alt = '')
	{
		$i = new Imagem();
		preg_match_all('/<img[^>]+>/i',$_POST[$field], $imgTags);
		$img1 = '';
		$all_images = '';
		if (isset($imgTags[0]) AND sizeof($imgTags[0]) > 0) {
			$CI =& get_instance();

			foreach ($imgTags[0] as $img) {
				preg_match('/imagens\/([^"]*)/', $img, $matches);

				//print_r($matches);

				if (isset($matches[1])) {
					$new_image = explode('__', $matches[1]);
					$new_image = end($new_image);
					if (empty($img1)) {
						$img1 = $new_image;
					}
					$all_images[] = $new_image;
					$pattern_w = "/width: ([^px]*)/i";
					$pattern_h = "/height: ([^px]*)/i";
					unset($width);
					unset($height);
					preg_match($pattern_w, $img, $width);
					preg_match($pattern_h, $img, $height);
					$style = 'zc1_';
					if (isset($width[1])) {
						$style .= 'w'.$width[1];
					}
					if (isset($height[1])) {
						$style .= (isset($width[1]) ? '_' : '').'h'.$height[1];
					}
					$style = ($style == 'zc1_' ? 'zc1_w700__' : $style.'__');


					preg_match('/style=\"([^\"]*)/', $img, $tag_style);
					$tag_style = !empty($tag_style[1]) ? $tag_style[1] : NULL ;

					preg_match('/alt=\"([^\"]*)/', $img, $alt_novo);
					$alt = !empty($alt_novo[1]) ? $alt_novo[1] : $alt ;

					$_POST[$field] = str_replace($img, '<img alt="'.$alt.'" src="'.static_base_url('imagens/'.$style.$new_image).'" '.( !empty($tag_style) ? 'style="'.$tag_style.'"' : NULL ).' />', $_POST[$field]);

					$i->clear();
					$i->where('src', $new_image)->get();
					if ($i->exists())
					{
						$i->alt = $alt;
						$i->save($object);
					}
				}
			}
		}

		$i->clear();

		//Insere uma imagem em destaque
		if (!empty($img1)) {
			$i->clear();
			$i->where('src', $img1)->get();
			if ($i->exists()) 
			{
				$object->imagem_id = $i->id;
				$object->save();
			}
		}

		$i->clear();
		//Busca as imagens relacionadas com o item que não estão no array
		if (!empty($all_images)) {
			$i->where_related($object)->where_not_in('src', $all_images)->get();	
		}
		else {
			//Busca as imagens relacionadas com o item
			$i->where_related($object)->get();
		}

		if ($i->exists())
		{
			$i->delete_all();
		}
		
		$object->$field = $_POST[$field];
		$object->save();

		return;
	}
}


// ------------------------------------------------------------------------

/* End of file video_helper.php */
/* Location: ./application/helpers/video_helper.php */