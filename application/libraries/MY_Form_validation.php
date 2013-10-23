<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class MY_Form_validation extends CI_Form_validation {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Valida o CNPJ
	 *
	 * @access      public
	 * @param       string
	 * @return      bool
	 */
	public function cnpj_valid($cnpj)
	{

		$cnpj = preg_replace( "@[./-]@", "", $cnpj );
		if( strlen( $cnpj ) <> 14 or !is_numeric( $cnpj ) )
		{
			return FALSE;
		}
		$k = 6;
		$soma1 = "";
		$soma2 = "";
		for( $i = 0; $i < 13; $i++ )
		{
			$k = $k == 1 ? 9 : $k;
			$soma2 += ( $cnpj{$i} * $k );
			$k--;
			if($i < 12)
			{
				if($k == 1)
				{
					$k = 9;
					$soma1 += ( $cnpj{$i} * $k );
					$k = 1;
				}
				else
				{
					$soma1 += ( $cnpj{$i} * $k );
				}
			}
		}
		$digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
		$digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;
		return ( $cnpj{12} == $digito1 and $cnpj{13} == $digito2 ) ? $cnpj : FALSE;
	}

	/**
	 * Valida o CPF
	 *
	 * @access      public
	 * @param       string
	 * @return      bool
	 */
	public function cpf_valid($cpf)
	{
			// Mantém somente números na variável $cpf
			$cpf = preg_replace('/[^0-9]/s', '', $cpf);
			
			if (empty($cpf)) {
				return;
			}

			// Verifica se o CPF informado não é uma combinação de digitos iguais
			for ($i = 0; $i <= 9; $i++)
			{
					if ($cpf[0]==$i && $cpf[1]==$i && $cpf[2]==$i && $cpf[3]==$i && $cpf[4]==$i && $cpf[5]==$i && $cpf[6]==$i && $cpf[7]==$i && $cpf[8]==$i)
					{
							return FALSE;
					}
			}

			// Gera primeiro digito verificador
			$soma = 0;
			$resto = 0;

			for ($i = 0, $j = 10; $i <= 8; $i++, $j--)
			{
					$soma += ($j * $cpf[$i]);
			}

			$resto = ($soma % 11);

			if ($resto == 0 OR $resto == 1)
			{
					$digito_verif_1 = 0;
			}
			elseif ($resto > 1 AND $resto < 11)
			{
					$digito_verif_1 = 11 - $resto;
			}
			else
			{
					return FALSE;
			}

			// Gera segundo digito verificador
			$soma = 0;
			$resto = 0;

			for ($i = 0, $j = 11; $i <= 8; $i++, $j--)
			{
					$soma += ($j * $cpf[$i]);
			}

			$soma += (2 * $digito_verif_1);
			

			$resto = ($soma % 11);
			
			if ($resto == 0 OR $resto == 1)
			{
					$digito_verif_2 = 0;
			}
			elseif ($resto > 1 AND $resto < 11)
			{
					$digito_verif_2 = 11 - $resto;
			}
			else
			{
					return FALSE;
			}


			// Compara dígitos verificadores gerados com os informados no CPF
			return ($cpf[9] == $digito_verif_1 AND $cpf[10] == $digito_verif_2) ? TRUE : FALSE ;
	}

	/**
	 * Valida um CNPJ ou CPF
	 * @param string Documento
	 * @return bool
	 */
	public function cnpj_cpf_valid($document = FALSE, $tipo = FALSE)
	{
		$CI =& get_instance();
		if ($CI->input->post($tipo)) {
			if ($CI->input->post($tipo) == 1) {
				if (!$this->cnpj_valid($document)) {
					return false;
				}
			}
			elseif ($CI->input->post($tipo) == 2) {
				if (!$this->cpf_valid($document)) {
					return false;
				}
			}
		}
		else
		{
			if (!$this->cnpj_valid($document)) {
				if (!$this->cpf_valid($document)) {
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Verifica se é uma hora válida
	 * @param string
	 * @return bool
	 */
	public function valid_hour($hour = FALSE)
	{
		if ($hour) {
			$CI =& get_instance();
			$CI->load->helper('Date_helper');
			return time_hm($hour) ? true : false ;
		}
		return;
	}

	/**
	 * Retorna true se a data normal for menor ou igual a data mínima
	 * @param string data normal
	 * @param string data mínima
	 * @return bool
	 */
	public function date_min($date_normal = FALSE, $date_min = FALSE)
	{
		$CI =& get_instance();
		if ($date_normal AND $CI->input->post($date_min)) {
			$CI->load->helper('Date_helper');
			return strtotime($date_normal) <= strtotime(date_format_switch($CI->input->post($date_min))) ? true : false ;
		}
		return;
	}

	/**
	 * Retorna true se a data normal for maior ou igual a data máxima
	 * @param string data normal
	 * @param string data máxima
	 * @return bool
	 */
	public function date_max($date_normal = FALSE, $date_max = FALSE)
	{
		$CI =& get_instance();
		if ($date_normal AND $CI->input->post($date_max)) {
			$CI->load->helper('Date_helper');
			return strtotime($date_normal) >= strtotime(date_format_switch($CI->input->post($date_max))) ? true : false ;
		}
		return;
	}

	/**
	 * Retorna true se o url do vídeo é do youtube
	 * @param string url
	 * @return bool
	 */
	public function youtube_valid($url = FALSE)
	{
		$CI =& get_instance();
		$CI->load->helper('Video_helper');
		return youtube_id($url) ? true : false ;
	}

}
/* End of file Someclass.php */