<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ci_timthumb {

	private $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function load($src, $params = FALSE)
	{
		//Se não existir parâmetros, pega as dimensoes reais da imagem
		if (!$params) {
			$filename = $this->CI->config->item('img_directory').$src;
			$imginfo = getimagesize($filename);
			list($width, $height, $type, $attr) = getimagesize($filename);
			if ($width) {
				$params['w'] = $width > $this->CI->config->item('up_img_w') ? $this->CI->config->item('up_img_w') : $width ;
			}
			if ($height) {
				$params['h'] = $height > $this->CI->config->item('up_img_w') ? 500 : $height ;
			}
			$params['zc'] = 1;
		}

		$w 		= isset($params['w']) ? $params['w'] : FALSE ;
		$h 		= isset($params['h']) ? $params['h'] : FALSE ;
		$q 		= isset($params['q']) ? $params['q'] : 90 ;
		$a 		= isset($params['a']) ? $params['a'] : FALSE;
		$zc		= isset($params['zc']) ? $params['zc'] : 1;
		$f		= isset($params['f']) ? $params['f'] : FALSE;
		$s		= isset($params['s']) ? $params['s'] : FALSE;
		$cc		= isset($params['cc']) ? $params['cc'] : FALSE;
		$ct		= isset($params['ct']) ? $params['ct'] : FALSE;

		$get = array(
			'src' 	=> 	base_url().$this->CI->config->item('img_directory').$src,
			'w'		=>	$w,
			'h'		=>	$h,
			'q'		=>	$q,
			'a'		=>	$a,
			'zc'	=>	$zc,
			'f'		=>	$f,
			's'		=>	$s,
			'cc'	=>	$cc,
			'ct'	=>	$ct,
		);

		$_GET = $get;

		require_once('timthumb.php');
	}

}

/* End of file ci_timthumb.php */
/* Location: ./application/libraries/ci_timthumb/ci_timthumb.php */