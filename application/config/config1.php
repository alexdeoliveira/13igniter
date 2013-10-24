<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Nome breve da entidade proprietária do site.
$config['entidade_nome_breve'] = '13igniter';

// Email para o qual enviar mensagens de contato.
$config['entidade_email_contato'] = 'exemplo@site.com';

// Description padrão do site.
$config['site_description'] = 'Desrição do site';

// Keywords padrão do site.
$config['site_keywords'] = '13igniter, php, codeigniter, datamapper';

// Código do Google Analytics para este site.
$config['ga_codigo'] = '';

// Email para acesso à conta do Google Analytics deste site.
//$config['ga_email'] = 'email@exemplo.com';

// Senha para acesso à conta do Google Analytics deste site.
//$config['ga_senha'] = 'teste';

// Report ID para as estatísticas principais deste site no Google Analytics.
//$config['ga_report_id'] = '123456';

//Configurações para o model das imagens
$config['img_directory'] = 'file/imagens/';
$config['img_thumb_size'] = '60';
$config['img_pequena_size'] = '140';
$config['img_normal_size'] = '300';
$config['img_big_size'] = '700';

//Configurações dos demais arquivos
$config['file_directory'] = 'file/arquivos/';

// Diretório onde ficam os arquivos de assets.
// Utilizado pela função assets_url() do MY_url_helper.
$config['assets_directory'] = 'assets';

// Versão dos assets. Deve ser atualizada sempre que for modificado
// qualquer arquivo do diretório de assets.
// Utilizada pela função assets_url() do MY_url_helper.
// Formato: 'yyyymmddxx', sendo xx de 01 a 99.
$config['assets_version'] = '2013102401';

if (ENVIRONMENT === 'development')
{
	$config['assets_version'] = date('mdHis');
}

//Imagem default thumb
//$config['default_thumb'] = 'assets/img/default-thumb.jpg';

//Imagem default pequena
//$config['default_pequena'] = 'assets/img/default-pequena.jpg';

//Imagem default normal
//$config['default_normal'] = 'assets/img/default-pequena.jpg';

//Imagem default big
//$config['default_big'] = 'assets/img/default-pequena.jpg';
// End of file

// Prefixo da URL para conteúdos estáticos, com ponto no final.
// Caso não houver host especial para conteúdos estáticos, deixar em branco.
$config['static_url_prefix'] = '';
