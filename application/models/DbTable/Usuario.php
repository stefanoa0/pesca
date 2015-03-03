<?php

/** 
 * Model DbTable Usuario
 * 
 * @package Pesca
 * @subpackage Models/DbTable
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */

class Application_Model_DbTable_Usuario extends Zend_Db_Table_Abstract
{

    protected $_name = 't_usuario';    
    protected $_primary = 'tu_id';

}

