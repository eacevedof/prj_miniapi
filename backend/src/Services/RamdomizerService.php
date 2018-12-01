<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Services\RamdomizerService 
 * @file RamdomizerService.php 1.0.0
 * @date 29-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Services;

use App\Services\AppService;
use App\Models\DeptEmpModel;
use App\Models\TitleModel;
use App\Models\EmployeeModel;
use App\Models\SalaryModel;

class RamdomizerService extends AppService
{

    public function get_int($iMin=0,$iMax=1000){return rand($iMin,$iMax);}

    public function get_string()
    {
        //hasta 8 párrafos
        $iParas = $this->get_int(1,8);
        $sUrlWs = "https://baconipsum.com/api/?type=all-meat&paras=$iParas";
        $sContent = file_get_contents($sUrlWs);
        $sContent = json_decode($sContent);
        $sContent = isset($sContent[0])?$sContent[0]:NULL;
        return $sContent;
    }
    
    public function get_substring_len($iLen=NULL,$iStart=NULL)
    {
        if(!$iStart) $iStart = $this->get_int(1,25);
        $sString = $this->get_string();
        $sString = substr($sString,$iStart);
        if($iLen) $sString = substr($sString,$iLen);
        return $sString;
    }
    
    public function get_substring_start($iStart)
    {
        $sString = $this->get_string();
        $sString = substr($sString,$iStart);
        return $sString;        
    }
    
    
    public function get_float()
    {
        
    }
    
    public function get_date()
    {}
    
    public function get_hour()
    {}
    
    
}//RamdomizerService
