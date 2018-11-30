<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheApplication\Components\ComponentLog 
 * @file ComponentLog.php 1.1.0
 * @date 30-11-2017 19:26 SPAIN
 * @observations
 */
namespace TheFramework\Components;

class ComponentLog 
{
    const DS = DIRECTORY_SEPARATOR;
    
    private $sPathFolder;
    private $sSubfType;
    private $sFileName;
        
    public function __construct($sSubfType="",$sPathFolder="") 
    {
        $this->sSubfType = $sSubfType;        
        $this->sPathFolder = $sPathFolder;        
        $this->sFileName = "app_".date("Ymd").".log";
        if(!$sPathFolder) $this->sPathFolder = __DIR__;
        if(!$sSubfType) $this->sSubfType = "debug";
        $this->fix_folder();
    }
    
    private function fix_folder()
    {
        $sLogFolder = $this->sPathFolder.self::DS
                        .$this->sSubfType.self::DS;
        if(!is_dir($sLogFolder)) @mkdir($sLogFolder);
    }
    
    private function merge($sContent,$sTitle)
    {
        $sReturn = "-- [".date("Ymd-His")."]\n";
        if($sTitle) $sReturn .= $sTitle.":\n";
        if($sContent) $sReturn .= $sContent."\n\n";
        return $sReturn;
    }
    
    public function save($sContent,$sTitle=NULL)
    {
        $sPathFile = $this->sPathFolder.self::DS
                        .$this->sSubfType.self::DS
                        .$this->sFileName;
        
        if(is_file($sPathFile))
            $oCursor = fopen($sPathFile,"a");
        else
            $oCursor = fopen($sPathFile,"x");

        if($oCursor !== FALSE)
        {
            $sToSave = $this->merge($sContent,$sTitle);
            fwrite($oCursor,""); //Grabo el caracter vacio
            if(!empty($sToSave)) fwrite($oCursor,$sToSave);
            fclose($oCursor); //cierro el archivo.
        }
        else
        {
            return FALSE;
        }
        return TRUE;        
    }//save

    public function set_filename($sValue){$this->sFileName="$sValue.log";}
    public function set_subfolder($sValue){$this->sSubfType="$sValue";}
    
}//ComponentLog