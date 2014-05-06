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