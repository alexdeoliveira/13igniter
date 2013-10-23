<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Imagem extends DataMapper {

		var $model = 'imagem';
		var $table = 'imagem';

		var $has_many = array();
		var $has_one = array();

		var $validation = array(
				'src' => array(
						'rules' => array('required'),
				)
		);

		/**
		 * Constructor: calls parent constructor
		 */
	function __construct($id = NULL)
		{
				parent::__construct($id);
	}

	var $default_order_by = array('id' => 'desc');

	function __toString()
		{
				return empty($this->src) ? $this->localize_label('id') : $this->src;
		}

}

/* End of file Imagem.php */
/* Location: ./application/models/imagem.php */