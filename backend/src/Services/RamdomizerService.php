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
    
    public function get_substring_len($iLen)
    {
        $iStart = $this->get_int(1,25);
        $sString = $this->get_string();
        $sString = substr($sString,$iStart,$iLen);
        return $sString;
    }
    
    public function get_substring_start($iStart)
    {
        $sString = $this->get_string();
        $sString = substr($sString,$iStart);
        return $sString;        
    }
        
    public function get_float($iNint=1,$iNdec=3,$cDecSep=".")
    {
        $arFloat = [];
        for($i=0;$i<$iNint; $i++)
        {
            if($i===0) 
                $arFloat[]= $this->get_int(1,9);
            else
                $arFloat[]= $this->get_int(0,9);
        }
        
        //separador
        $arFloat[] = $cDecSep;
        
        for($i=0;$i<$iNdec; $i++)
            $arFloat[] = $this->get_int(0,9);
        
        $sFloat = implode("",$arFloat);
        return $sFloat;
    }
    
    public function get_date_ymd($cSep="-")
    {
        $arDate["Y"] = $this->get_int(1900,date("Y"));
        $arDate["m"] = sprintf("%02d",$this->get_int(1,12));
        $arDate["d"] = sprintf("%02d",$this->get_int(1,31));
        return implode($cSep,$arDate);
    }
    
    public function get_date_dmy($cSep="-")
    {
        $arDate["d"] = sprintf("%02d",$this->get_int(1,31));
        $arDate["m"] = sprintf("%02d",$this->get_int(1,12));
        $arDate["Y"] = $this->get_int(1900,date("Y"));
        return implode($cSep,$arDate);
    }    
    
    public function get_date_mdy($cSep="-")
    {
        $arDate["m"] = sprintf("%02d",$this->get_int(1,12));
        $arDate["d"] = sprintf("%02d",$this->get_int(1,31));
        $arDate["Y"] = $this->get_int(1900,date("Y"));
        return implode($cSep,$arDate);
    }
    
    public function is_date_ok($sDate,$sFormat="Y-m-d")
    {
        //fuente: https://stackoverflow.com/questions/19271381/correctly-determine-if-date-string-is-a-valid-date-in-that-format
        $oDateTime = DateTime::createFromFormat($sFormat,$sDate);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return (($oDateTime && $oDateTime->format($sFormat)) === $sDate);
    }
    
    public function get_hour($cSep=":")
    {
        $arHour["H"] = sprintf("%02d",$this->get_int(0,23));
        $arHour["i"] = sprintf("%02d",$this->get_int(0,59));
        $arHour["s"] = sprintf("%02d",$this->get_int(0,59));
        return implode($cSep,$arHour);        
    }
    
    public function get_itemkey($arArray){return array_rand($arArray);}
    
    public function get_itemval($arArray){return $arArray[array_rand($arArray)];
    
    }    
}//RamdomizerService
