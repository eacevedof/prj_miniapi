<?php
// en: /<project>/backend 
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests/DeleteTest.php --color=auto
// ./vendor/bin/phpunit --bootstrap ./vendor/theframework/bootstrap.php ./src/tests
use PHPUnit\Framework\TestCase;
use App\Traits\AppLogTrait;
use App\Models\DepartmentModel;
use App\Models\DeptEmpModel;
use App\Models\EmployeeModel;
use App\Models\SalaryModel;
use App\Models\TitleModel;


class DeleteTest extends TestCase
{    
    use AppLogTrait;
      
}//DeleteTest