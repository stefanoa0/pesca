<?php

/** 
 * Model DbTable Endereco
 * 
 * @package Pesca
 * @subpackage Models
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */

class Application_Model_DbTable_Endereco extends Zend_Db_Table_Abstract
{

    protected $_name = 't_endereco';
    protected $_primary = 'te_id';

}

