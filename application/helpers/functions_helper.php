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

/**
 * Envia email
 * @param string $to
 * @param string $subject
 * @param string $message
 * @param string $reply
 * @param string $cc
 * @return boolean 
 */
if ( ! function_exists('send_email')) 
{
	function send_email($to, $subject, $message, $reply='', $cc='') 
	{
		if (empty($to) AND empty($subject) AND empty($message)) {
			return false;
		}

		$CI =& get_instance();
		$CI->load->config('email');

		$from = $CI->config->item('entidade_email_contato');
		$entidade_nome_breve = $CI->config->item('entidade_nome_breve');
		//titulo default
		$title = "<h3><strong>".$subject."</strong></h3>";
		//assinatura default
		$subscription = "
			<br /><br />---<br />
			Atenciosamente,<br />
			<a href=\"".base_url()."\">".base_url()."</a>
		";

		$CI->load->library('email');
		//monta email
		$CI->email->from($from, 'Site '.$entidade_nome_breve);
		$CI->email->to($to);
		if (!empty($reply)) {
			$CI->email->reply_to($reply, 'Site '.$entidade_nome_breve);
		}
		if (!empty($cc)) {
			$CI->email->cc($cc);
		}
		$CI->email->subject($subject);
		$CI->email->message($title.$message.$subscription);
		//envia email
		if ($CI->email->send()) {
			return true;
		}
		
		return false;
	}
}