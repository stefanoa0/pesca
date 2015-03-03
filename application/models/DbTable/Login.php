<?php

/** 
 * Model DbTable Login
 * 
 * @package Pesca
 * @subpackage Models/DbTable
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */

class Application_Model_DbTable_Login extends Zend_Db_Table_Abstract
{

    protected $_name = 't_login';
    protected $_primary = 'tl_id';
    
}

