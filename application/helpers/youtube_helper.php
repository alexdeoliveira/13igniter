<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('youtube_embed')) {
	function youtube_embed($url, $w = 560, $h = 315)
	{
		if ( ! $id = youtube_id($url)) {
			return false;
		}

		$embed = '<iframe width="'.$w.'" height="'.$h.'" src="//www.youtube.com/embed/'.$id.'?rel=0" frameborder="0" allowfullscreen></iframe>';
		return $embed;
	}
}

if ( ! function_exists('youtube_id')) {
	function youtube_id($url)
	{
		parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		if (isset($my_array_of_vars['v']) AND !empty($my_array_of_vars['v'])) {
			return $my_array_of_vars['v'];
		}

		return false;
	}
}

if ( ! function_exists('youtube_thumbs')) {
	
	function youtube_thumbs($url, $thumb = '0')
	{
		if ( ! $id = youtube_id($url)) {
			return false;
		}

		$result = array(
			'0' => 'http://img.youtube.com/vi/'.$id.'/0.jpg',
			'1' => 'http://img.youtube.com/vi/'.$id.'/1.jpg',
			'2' => 'http://img.youtube.com/vi/'.$id.'/2.jpg',
			'3' => 'http://img.youtube.com/vi/'.$id.'/3.jpg',
			'4' => 'http://i1.ytimg.com/vi/'.$id.'/maxresdefault.jpg',
			'5' => 'http://i1.ytimg.com/vi/'.$id.'/mqdefault.jpg'
		);

		return $result[$thumb];

	}
}