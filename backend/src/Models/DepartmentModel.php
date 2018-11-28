<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Models\DepartmentModel 
 * @observations
 */
namespace App\Models;

use App\Models\AppModel;

class DepartmentModel extends AppModel
{   
    public function __construct() 
    {
        parent::__construct();
    }   

    // listado
    public function get_picklist()
    {
        $sSQL = "
        /*DepartmentModel.get_picklist*/
        SELECT dept_no,dept_name
        FROM departments
        ORDER BY 2,1
        ";
        $arRows = $this->oDb->query($sSQL);
        return $arRows;
    }//get_picklist
    
}//DepartmentModel
