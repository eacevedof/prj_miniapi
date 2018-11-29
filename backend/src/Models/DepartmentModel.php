<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Models\DepartmentModel 
 * @file DepartmentModel.php v1.0.0
 * @date 29-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Models;

use App\Models\AppModel;

class DepartmentModel extends AppModel
{   
    public function __construct() 
    {
        $this->sTable = "departments";
        parent::__construct();
        $this->load_fileds();
    }
    
    //hace un mapeo de los campos que vienen del formulario y los campos reales en bd
    public function load_fileds()
    {
        $arTmp = [
            ["db"=>"first_name","ui"=>"firstname"],
            ["db"=>"last_name","ui"=>"lastname"],
            ["db"=>"birth_name","ui"=>"birthname"],
            ["db"=>"gender","ui"=>"gender"]
        ];
        $this->arFields = $arTmp;
    }
    // listado
    public function get_picklist()
    {
        $sSQL = "
        /*DepartmentModel.get_picklist*/
        SELECT dept_no deptno,dept_name deptname
        FROM departments
        ORDER BY 2,1
        ";
        $arRows = $this->oDb->query($sSQL);
        return $arRows;
    }//get_picklist
    
}//DepartmentModel
