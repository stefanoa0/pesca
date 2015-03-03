<?php

/** 
 * Model DbTable Especie
 * 
 * @package Pesca
 * @subpackage Models/DbTable
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */

class Application_Model_DbTable_Especie extends Zend_Db_Table_Abstract
{

    protected $_name = 't_especie';
    protected $_primary = 'esp_id';
    
}

