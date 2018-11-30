<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Models\AppModel 
 * @file AppModel.php 1.0.1
 * @date 29-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Models;

use TheFramework\Components\Db\ComponentMysql;
use TheFramework\Components\Db\ComponentCrud;
use TheFramework\Components\ComponentLog;

class AppModel 
{
    protected $oDb;
    protected $sTable;
    protected $arFields;
    
    protected $arErrors = [];
    protected $isError = FALSE;
    
    public function __construct() 
    {
        $arConfig = $this->get_config("db");
        $oDb = new ComponentMysql();
        $oDb->add_conn("server",$arConfig["server"]);
        $oDb->add_conn("database",$arConfig["database"]);
        $oDb->add_conn("user",$arConfig["user"]);
        $oDb->add_conn("password",$arConfig["password"]);
        $this->oDb = $oDb;
    }
    
    public function get_lastinsert_id()
    {
        $sSQL = "SELECT LAST_INSERT_ID()";
        return $this->oDb->query($sSQL);
    }

    protected function get_config($sKey)
    {
        $arConfig = realpath(__DIR__."/../config/config.php");
        $arConfig = include($arConfig);
        return $arConfig[$sKey];        
    }
    
    //$arPost = $_POST
    //busca los campos de form en el post y guarda sus valores
    //en los campos de bd
    protected function get_keyvals($arPost)
    {
        $arFieldsUi = array_keys($arPost);
        $arReturn = [];
        foreach($this->arFields as $arMap)
        {
            $sFieldDb = $arMap["db"];
            $sFieldUi = $arMap["ui"];
            if(in_array($sFieldUi,$arFieldsUi))
                $arReturn[$sFieldDb] = $arPost[$sFieldUi];
        }
        return $arReturn;
    }
    
    //hace un insert automatico a partir de lo que viene en $_POST
    public function insert($arPost)
    {
        $arData = $this->get_keyvals($arPost);
        if($arData)
        {
            //helper generador de consulta. 
            //se le inyecta el objeto de bd para que la ejecute directamente
            $oCrud = new ComponentCrud($this->oDb);
            $oCrud->set_table($this->sTable);
            foreach($arData as $sFieldName=>$sValue)
                $oCrud->add_insert_fv($sFieldName,$sValue);
            $oCrud->autoinsert();
            $this->log($oCrud->get_sql());
            if($oCrud->is_error())
                $this->add_error("An error occurred while trying to save");
        }
    }//insert    

    public function update($id,$arPost)
    {
        //TODO
    }//update
    
    public function delete($id)
    {
        //TODO
    }//delete
    
    public function log($mxVar,$sTitle=NULL)
    {
        $oLog = new ComponentLog("sql",__DIR__."/../logs");
        $oLog->save($mxVar,$sTitle);
    }
    
    private function add_error($sMessage){$this->isError = TRUE;$this->arErrors[]=$sMessage;}
    public function is_error(){return $this->isError;}
    public function get_errors($inJson=0){if($inJson) return json_encode($this->arErrors); return $this->arErrors;}
    public function get_error($i=0){isset($this->arErrors[$i])?$this->arErrors[$i]:NULL;}
    public function show_errors(){echo "<pre>".var_export($this->arErrors,1);}  
    
}//AppModel
