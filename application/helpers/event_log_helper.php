<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Registra um evento no log de eventos.
 * 
 * @author Heini
 * @version 15/09/2009 22:00 Heini
 * @param string $name Nome do tipo de evento
 * @param string $user_id ID do usuário relacionado ao evento
 * @return bool TRUE em caso de sucesso
 */
if ( ! function_exists('event_log'))
{
	function event_log($name, $user_id = FALSE)
	{
		if ($name == FALSE)
		{
			return FALSE;
		}
		
		$CI =& get_instance();
		$CI->load->model('Event_log_model', 'event_log');
		$id = $CI->event_log->insert($name, $user_id);
		if ($id == FALSE)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}

/* End of file event_log_helper.php */
/* Location: ./system/application/helpers/event_log_helper.php */