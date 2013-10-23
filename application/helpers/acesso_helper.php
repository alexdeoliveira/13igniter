<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Verifica se tem acesso à página
	 *
	 * @author Alex
	 * @version 22/06/2010 10:48
	 * @param string, integer
	 * @return boolean
	 */
	if ( ! function_exists('acesso'))
	{
		function acesso($pagina = FALSE, $redirect = FALSE)
		{
			if ( $pagina == FALSE )
			{
				show_404();
			}
			$CI =& get_instance();
			if (!$CI->ion_auth->is_admin())
			{
				if(!$CI->ion_auth->in_group($pagina))
				{
					if($redirect == 1)
					{
						if (!$CI->session->userdata('user_id')) {
								$CI->session->set_flashdata('redirect', current_url());
								$CI->session->set_flashdata('warning', 'Por favor, efetue seu login para continuar.');
								$redirect = 'auth/login';
						}
						else {
								$redirect = 'auth/denied';
						}
						redirect($redirect);
					}
					else
					{
						return FALSE;
					}
				}
			}
			return TRUE;
		}
	}


/* End of file acesso_helper.php */
/* Location: ./system/application/helper/acesso_helper.php */
