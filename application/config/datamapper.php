<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Data Mapper Configuration
 *
 * Global configuration settings that apply to all DataMapped models.
 */

$config['prefix'] = '';
$config['join_prefix'] = '';
$config['error_prefix'] = '<div class="alert alert-danger" role="alert">';
$config['error_suffix'] = '<button type="button" class="close" data-dismiss="alert">
  <span aria-hidden="true">&times;</span>
  <span class="sr-only">Close</span>
</button></div>';
$config['created_field'] = 'data_cadastro';
$config['updated_field'] = 'data_edicao';
$config['local_time'] = FALSE;
$config['unix_timestamp'] = FALSE;
$config['cascade_delete'] = FALSE;
$config['timestamp_format'] = 'Y-m-d H:i:s';
$config['lang_file_format'] = 'model_${model}';
$config['field_label_lang_format'] = '${model}_${field}';
$config['auto_transaction'] = TRUE;
$config['auto_populate_has_many'] = TRUE;
$config['auto_populate_has_one'] = TRUE;
$config['all_array_uses_ids'] = FALSE;
// set to FALSE to use the same DB instance across the board (breaks subqueries)
// Set to any acceptable parameters to $CI->database() to override the default.
$config['db_params'] = '';
// Uncomment to enable the production cache
// $config['production_cache'] = 'datamapper/cache';
$config['extensions_path'] = 'datamapper';
$config['extensions'] = array('array', 'htmlform', 'custom_rules');

/* End of file datamapper.php */
/* Location: ./application/config/datamapper.php */
