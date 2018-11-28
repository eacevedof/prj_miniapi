<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Models\TitleModel 
 * @observations
 */
namespace App\Models;

use App\Models\AppModel;

class TitleModel extends AppModel
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    // carga combo
    public function get_picklist()
    {
        $sSQL = "
        /*DepartmentModel.get_picklist*/
        SELECT dept_no,dept_name
        FROM departments
        ORDER BY 2
        ";
        $arRows = $this->oDb->query($sSQL);
        return $arRows;
    }//get_picklist
    
}//TitleModel
