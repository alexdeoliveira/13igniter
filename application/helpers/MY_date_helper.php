<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Retorna hora e data no formato mais utilizado e com fuso-horário ajustado.
 * 
 * Exemplos dos formatos:
 * standard: 23/02/2009
 * short: 14:30, 23 fev, ou 23/02/2009
 * long: 23 de fevereiro de 2009 14:30
 * time: 08:50
 * full: 23/02/2009 14:30
 * txt: 30/04/2012 8h50
 *
 * @param string $datetime Data e hora, no formato MySQL (yyyy-mm-dd hh:mm:ss) ou PHP (UNIX Timestamp)
 * @param string $format Formato (standard, short, long, hmm)
 * @param bool $fuso Se true converte para o fuso local senão exibe conforme está a data
 * @return string Data e hora no formato desejado
 */
if( ! function_exists('datetime'))
{
	function datetime($datetime, $format = 'standard', $fuso = true)
	{
		$timezone = 'America/Sao_Paulo';

		$newDate = new DateTime($datetime . ' GMT');
		if ($fuso) {
			$newDate->setTimeZone(new DateTimeZone($timezone));	
		}

		// Formato normal
		if($format == 'standard')
		{

			$datetime = $newDate->format('d/m/Y H:i');
		}
		// Formato somente horario
		elseif($format == 'time')
		{
			$datetime = $newDate->format('H:i');
		}
		// Formato somente horario formato 10h08
		elseif($format == 'time2')
		{
			$datetime = $newDate->format('H\hi');
		}
		// Formato completo
		elseif($format == 'full')
		{
			$datetime = $newDate->format('d/m/Y H:i');
		}
		// Formato de data e hora para ser usado em textos
		elseif($format == 'txt')
		{
			$datetime = $newDate->format('d/m/Y G\hi');
		}
		// Retorna somente o ano
		elseif($format == 'year')
		{
			$datetime = $newDate->format('Y');
		}
		// Formato somente data
		elseif($format == 'date')
		{
			$datetime = $newDate->format('d/m/Y');
		}
		// Formato curto sem hora
		else if($format == 'short_not_hm')
		{
			$now_datetime = gmt_to_local(time(), $timezone);
			if($newDate->format('Y') === date('Y', $now_datetime)) //datetime pertence ao ano corrente
			{
				if($newDate->format('m') === date('m', $now_datetime)) //datetime pertence ao mês corrente
				{
					if($newDate->format('d') === date('d', $now_datetime)) //datetime pertence ao dia corrente
					{
						$datetime = 'Hoje';
					}
					else //datetime não pertence ao dia corrente
					{
						switch($newDate->format('n'))
						{
							case 1:
								$month = 'jan';
								break;
							case 2:
								$month = 'fev';
								break;
							case 3:
								$month = 'mar';
								break;
							case 4:
								$month = 'abr';
								break;
							case 5:
								$month = 'mai';
								break;
							case 6:
								$month = 'jun';
								break;
							case 7:
								$month = 'jul';
								break;
							case 8:
								$month = 'ago';
								break;
							case 9:
								$month = 'set';
								break;
							case 10:
								$month = 'out';
								break;
							case 11:
								$month = 'nov';
								break;
							case 12:
								$month = 'dez';
								break;
						}
						$datetime = $newDate->format('j').' de '.$month;
					}
				}
				else //datetime não pertence ao mês corrente
				{
					switch($newDate->format('n'))
					{
						case 1:
							$month = 'jan';
							break;
						case 2:
							$month = 'fev';
							break;
						case 3:
							$month = 'mar';
							break;
						case 4:
							$month = 'abr';
							break;
						case 5:
							$month = 'mai';
							break;
						case 6:
							$month = 'jun';
							break;
						case 7:
							$month = 'jul';
							break;
						case 8:
							$month = 'ago';
							break;
						case 9:
							$month = 'set';
							break;
						case 10:
							$month = 'out';
							break;
						case 11:
							$month = 'nov';
							break;
						case 12:
							$month = 'dez';
							break;
					}
					$datetime = $newDate->format('j').' de '.$month;
				}
			}
			else //datetime não pertence ao ano corrente
			{
				$datetime = $newDate->format('d/m/Y');
			}
		}
		// Formato curto
		else if($format == 'short')
		{
			$now_datetime = gmt_to_local(time(), $timezone);
			if($newDate->format('Y') === date('Y', $now_datetime)) //datetime pertence ao ano corrente
			{
				if($newDate->format('m') === date('m', $now_datetime)) //datetime pertence ao mês corrente
				{
					if($newDate->format('d') === date('d', $now_datetime)) //datetime pertence ao dia corrente
					{
						$prep = ($newDate->format('H') > 1) ? 'às' : 'à';
						$datetime = 'Hoje '.$prep.' '.$newDate->format('H:i');
					}
					else //datetime não pertence ao dia corrente
					{
						switch($newDate->format('n'))
						{
							case 1:
								$month = 'jan';
								break;
							case 2:
								$month = 'fev';
								break;
							case 3:
								$month = 'mar';
								break;
							case 4:
								$month = 'abr';
								break;
							case 5:
								$month = 'mai';
								break;
							case 6:
								$month = 'jun';
								break;
							case 7:
								$month = 'jul';
								break;
							case 8:
								$month = 'ago';
								break;
							case 9:
								$month = 'set';
								break;
							case 10:
								$month = 'out';
								break;
							case 11:
								$month = 'nov';
								break;
							case 12:
								$month = 'dez';
								break;
						}
						$datetime = $newDate->format('j').' de '.$month;
					}
				}
				else //datetime não pertence ao mês corrente
				{
					switch($newDate->format('n'))
					{
						case 1:
							$month = 'jan';
							break;
						case 2:
							$month = 'fev';
							break;
						case 3:
							$month = 'mar';
							break;
						case 4:
							$month = 'abr';
							break;
						case 5:
							$month = 'mai';
							break;
						case 6:
							$month = 'jun';
							break;
						case 7:
							$month = 'jul';
							break;
						case 8:
							$month = 'ago';
							break;
						case 9:
							$month = 'set';
							break;
						case 10:
							$month = 'out';
							break;
						case 11:
							$month = 'nov';
							break;
						case 12:
							$month = 'dez';
							break;
					}
					$datetime = $newDate->format('j').' de '.$month;
				}
			}
			else //datetime não pertence ao ano corrente
			{
				$datetime = $newDate->format('d/m/Y H:i');
			}
		}

		// Formato longo
		else if($format == 'long')
		{
			switch($newDate->format('n'))
			{
				case 1:
					$month = 'janeiro';
					break;
				case 2:
					$month = 'fevereiro';
					break;
				case 3:
					$month = 'março';
					break;
				case 4:
					$month = 'abril';
					break;
				case 5:
					$month = 'maio';
					break;
				case 6:
					$month = 'junho';
					break;
				case 7:
					$month = 'julho';
					break;
				case 8:
					$month = 'agosto';
					break;
				case 9:
					$month = 'setembro';
					break;
				case 10:
					$month = 'outubro';
					break;
				case 11:
					$month = 'novembro';
					break;
				case 12:
					$month = 'dezembro';
					break;
			}
			$datetime = $newDate->format('j').' de '.$month.' de '.$newDate->format('Y - H:i').' horas';
		}

		return $datetime;
	}
}

/**
 * Troca o formato da data de yyyy-mm-dd para dd/mm/yyyy e vice-versa.
 *
 * @author Heini
 * @version 15/11/2009 23:30 Heini
 * @param string $date Data no formato yyyy-mm-dd ou dd/mm/yyyy
 * @return string Data no outro formato
 */
if( ! function_exists('date_format_switch'))
{
	function date_format_switch($date)
	{
		if (empty($date) OR $date == '0000-00-00') {
			return false;
		}
		if (substr_count($date, '-') == 2)
		{
			list($y, $m, $d) = explode('-', $date);
			$date = date('d/m/Y', mktime(0, 0, 0, $m, $d, $y));
		}
		else if (substr_count($date, '/') == 2)
		{
			list($d, $m, $y) = explode('/', $date);
			$date = date('Y-m-d', mktime(0, 0, 0, $m, $d, $y));
		}
		return $date;
	}
}

/**
*
* Mostra as horas e minutos
*
* @author Aléx de Oliveira
* @param        
* @return       
*
**/
if( ! function_exists('time_hm'))
{
	function time_hm($time = FALSE)
	{
		if (!$time)
		{
			return FALSE;
		}
		$t = explode(':', $time);
		if (sizeof($t) < 2)
		{
			return FALSE;
		}
		$time = $t[0].':'.$t[1];
		return $time;
	}
}

/* End of file MY_date_helper.php */
/* Location: ./application/helpers/MY_date_helper.php */