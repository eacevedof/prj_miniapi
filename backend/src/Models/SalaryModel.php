<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Models\SalaryModel 
 * @file SalaryModel.php v1.0.0
 * @date 29-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Models;

use App\Models\AppModel;

class SalaryModel extends AppModel
{
    public function __construct() 
    {
        $this->sTable = "salaries";
        parent::__construct();
        $this->load_pk_fields();
        $this->load_fileds();
    }
        
    private function load_fileds()
    {
        $arTmp = [
            ["db"=>"emp_no","ui"=>"empno"],
            ["db"=>"salary","ui"=>"salary"],
            ["db"=>"from_date","ui"=>"fromdate"],
            ["db"=>"to_date","ui"=>"todate"]
        ];
        $this->arFields = $arTmp;
    }
    
    private function load_pk_fields()
    {
        $this->arPks = ["emp_no","from_date"];
    }//load_pk_fields
       
    // carga combo
    public function get_picklist()
    {
        $sSQL = "
        /*SalaryModel.get_picklist*/
        SELECT DISTINCT title,title
        FROM titles
        ORDER BY 2
        ";
        $arRows = $this->oDb->query($sSQL);
        return $arRows;
    }//get_picklist
    
}//SalaryModel
