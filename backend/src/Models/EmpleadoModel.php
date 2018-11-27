<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Models\EmpleadoModel 
 * @observations
 */
namespace App\Models;

use TheFramework\Components\Db\ComponentMysql;

class EmpleadoModel 
{
    private $oDb;
    
    public function __construct() 
    {
        $oDb = new ComponentMysql();
        $oDb->add_conn("server","localhost");
        $oDb->add_conn("database","employees");
        $oDb->add_conn("user","root");
        $oDb->add_conn("password","");
        $this->oDb = $oDb;
    }
    
    // listado
    public function get_list()
    {
        $arRows = $this->oDb->query("SELECT * FROM employees");
        return $arRows;
    }
    
    // detalle / ficha del empleado
    public function get_profile()
    {

    }
    
    // insert
    public function insert()
    {

    }

}//EmpleadoModel
