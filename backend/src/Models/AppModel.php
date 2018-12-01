<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Models\AppModel 
 * @file AppModel.php 2.0.0
 * @date 01-12-2018 00:00 SPAIN
 * @observations
 */
namespace App\Models;

use TheFramework\Components\Db\ComponentMysql;
use TheFramework\Components\Db\ComponentCrud;

use App\Traits\AppErrorTrait;
use App\Traits\AppLogTrait;

class AppModel 
{
    use AppErrorTrait;
    use AppLogTrait;
    
    protected $oDb;
    protected $sTable;
    protected $arFields;
    protected $arPks;
    
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
        //config db
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
            $this->log($oCrud->get_sql(),($oCrud->is_error()?"ERROR":NULL));
        }
    }//insert    

    private function get_pks($arData)
    {
        $arPks = [];
        foreach($arData as $sFieldName=>$sValue)
            if(in_array($sFieldName,$this->arPks))
                $arPks[$sFieldName] = $sValue;
        return $arPks;
    }
    
    private function get_no_pks($arData)
    {
        $arPks = [];
        foreach($arData as $sFieldName=>$sValue)
            if(!in_array($sFieldName,$this->arPks))
                $arPks[$sFieldName] = $sValue;
        return $arPks;
    }    
    
    public function update($arPost)
    {
        $arData = $this->get_keyvals($arPost);
        
        $arNoPks = $this->get_no_pks($arData);
        $arPks = $this->get_pks($arData);
        
        if($arData)
        {
            //habría que comprobar count(arPks)==count($this->arPks)
            $oCrud = new ComponentCrud($this->oDb);
            $oCrud->set_table($this->sTable);
            
            //valores del "SET"
            foreach($arNoPks as $sFieldName=>$sValue)
                $oCrud->add_update_fv($sFieldName,$sValue);
            
            //valores del WHERE 
            foreach($arPks as $sFieldName=>$sValue)
                $oCrud->add_pk_fv($sFieldName,$sValue);
            
            $oCrud->autoupdate();           
            if($oCrud->is_error())
                $this->add_error("An error occurred while trying to delete");  
            
            $this->log($oCrud->get_sql(),($oCrud->is_error()?"ERROR":NULL));
        }
    }//update
    
    public function delete($arPost)
    {
        $arData = $this->get_keyvals($arPost);
        $arPks = $this->get_pks($arData);
        if($arPks)
        {
            $oCrud = new ComponentCrud($this->oDb);
            $oCrud->set_table($this->sTable);
            foreach($arPks as $sFieldName=>$sValue)
                $oCrud->add_pk_fv($sFieldName,$sValue);
            $oCrud->autodelete();
            
            if($oCrud->is_error())
                $this->add_error("An error occurred while trying to delete");  
            
            $this->log($oCrud->get_sql(),($oCrud->is_error()?"ERROR":NULL));
        }
    }//delete
    
    /**
     * Se usa antes de borrar o actualizar
     * Se pasa el post y comprueba que existan todos los campos clave
     * @param array $arPost ["uifield"=>"value" ...]
     * @return boolean
     */
    public function is_pks_ok($arPost)
    {
        $arData = $this->get_keyvals($arPost);
        $arPks = $this->get_no_pks($arData);
        return (count($arPks)===count($this->arPks));
    }
        
}//AppModel
