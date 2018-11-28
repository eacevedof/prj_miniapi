<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Controllers\PicklistController 
 * @file component_mysql.php v1.0.0
 * @date 19-09-2017 04:56 SPAIN
 * @observations
 */
namespace App\Controllers;

use App\Controllers\AppController;
use App\Models\DepartmentModel;
use App\Models\TitleModel;

class PicklistController extends AppController
{
    public function titles()
    {
        $oModel = new TitleModel();
        $this->show_json($oModel->get_picklist());
    }

    public function departments()
    {
        $oModel = new DepartmentModel();
        $this->show_json($oModel->get_picklist());
    }
}//PicklistController
