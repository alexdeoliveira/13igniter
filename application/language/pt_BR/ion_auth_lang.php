<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - Portuguese
*
* Author: Aléx de Oliveira @alex_web
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  2012/12/01
*
* Description:  Portuguese language file for Ion Auth messages and errors
*
*/

// Account Creation
$lang['account_creation_successful']  		= 'Conta criada com sucesso';
$lang['account_creation_unsuccessful']		= 'Não foi possível criar a conta';
$lang['account_creation_duplicate_email']	= 'Email em uso ou inválido';
$lang['account_creation_duplicate_username']= 'Nome de usuário em uso ou inválido';

// Password
$lang['password_change_successful']			= 'Senha alterada com sucesso';
$lang['password_change_unsuccessful']		= 'Não foi possível alterar a senha';
$lang['forgot_password_successful']			= 'Nova senha enviada por email';
$lang['forgot_password_unsuccessful']		= 'Não foi possível criar uma nova senha';

// Activation
$lang['activate_successful']				= 'Conta ativada';
$lang['activate_unsuccessful']				= 'Não foi possível ativar a conta';
$lang['deactivate_successful']				= 'Conta desativada';
$lang['deactivate_unsuccessful']			= 'Não foi possível desativar a conta';
$lang['activation_email_successful']		= 'Email de ativação enviado com sucesso';
$lang['activation_email_unsuccessful']		= 'Não foi possível enviar o email de ativação';

// Login / Logout
$lang['login_successful']					= 'Sessão iniciada com sucesso';
$lang['login_unsuccessful']					= 'Usuário ou senha inválidos';
$lang['login_unsuccessful_not_active']		= 'A conta está desativada';
$lang['login_timeout']						= 'Conta temporariamente bloqueada. Tente novamente mais tarde';
$lang['logout_successful']					= 'Volte logo!';

// Account Changes
$lang['update_successful']					= 'Informações da conta atualizadas com sucesso';
$lang['update_unsuccessful']				= 'Não foi possível atualizar as informações da conta';
$lang['delete_successful']					= 'Usuário excluído com sucesso';
$lang['delete_unsuccessful']				= 'Não foi possível excluir o usuário';

// Groups
$lang['group_creation_successful']  = 'Grupo criado com sucesso';
$lang['group_already_exists']       = 'Já existe um grupo com esse nome';
$lang['group_update_successful']    = 'Grupo alterado com sucesso';
$lang['group_delete_successful']    = 'Grupo excluído';
$lang['group_delete_unsuccessful'] 	= 'Grupo excluído';

// Email Subjects
$lang['email_forgotten_password_subject']	= 'Esqueci a senha';
$lang['email_new_password_subject']			= 'Nova senha';
$lang['email_activation_subject']			= 'Ativação da conta';