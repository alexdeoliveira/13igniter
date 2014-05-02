<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Extensão DataMapper para regras de validação personalizadas.
 */
class DMZ_Custom_Rules {

	function __construct()
    {
        $CI =& get_instance();
        $CI->lang->load('custom_rules', 'pt_BR');
    }

	/**
	 * Validação do rótulo que será gerado a partir do valor passado no campo
	 *
	 * O parâmetro $param não é utilizado nesta função, foi deixado
	 * apenas para referência da estrutura da função.
	 *
	 * @param object $object Objeto que está sendo validado
	 * @param string $field Campo que está sendo validado
	 * @param string $param Parâmetro na chamada da validação
	 * @return bool FALSE caso a validação falhar
	 */
	function rule_valid_rotulo($object = '', $field = '', $param = '')
	{
		if (empty($object) OR empty($field))
		{
			return FALSE;
		}

		$rotulo = rotulo($object->{$field});

		$object_aux = new $object;
		$object_aux->get_by_rotulo($rotulo);

		if ($object_aux->exists())
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function rule_valid_cpf($object = '', $field = '')
	{
		$cpf = $object->{$field};

		if (strlen($cpf) !== 14)
		{
			return FALSE;
		}
		


		// Mantém somente números na variável $cpf
		$cpf = preg_replace('/[^0-9]/s', '', $cpf);

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
		if ($cpf[9] == $digito_verif_1 AND $cpf[10] == $digito_verif_2)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

}

// End of file
