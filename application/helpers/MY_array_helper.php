<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Insere um item no começo de um array
 *
 * http://php.net/manual/en/function.array-unshift.php
 *
 * @param array $arr O array
 * @param mixed $key Chave do novo item
 * @param mixed $val Valor do novo item
 * @return int Tamanho do array
 */
if ( ! function_exists('array_unshift_assoc'))
{
	function array_unshift_assoc(&$arr, $key, $val) 
	{ 
		$arr = array_reverse($arr, true); 
		$arr[$key] = $val; 
		$arr = array_reverse($arr, true); 
		return count($arr); 
	}
}

// End of file