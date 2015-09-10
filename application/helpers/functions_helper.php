<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Verifica qual imagem está em destaque views/admin/pluplod.php
if ( ! function_exists('verifica_destaque')) {
	function verifica_destaque($rotulo, $id) {
		$g = new Galeria();
		$g->where('rotulo', $rotulo)->get();

		$i = new Imagem();
		$i->where('id', $id)->where('id', $g->imagem_id)->get();

		if ($i->id) {
			return true;
		}
		return false;
	}
}

/**
 * Corta uma string em X caracteres
 * @param string $string
 * @return string 
 */
if (! function_exists('string_limiter')) {
	function string_limiter($string, $lim = 250)
	{
		$string = (strlen($string) > $lim) ? mb_substr($string ,0, $lim).'...' : $string;
		return $string;
	}
}