<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Models\EmployeeModel 
 * @observations
 */
namespace App\Models;

use App\Models\AppModel;

class EmployeeModel extends AppModel
{
   
    public function __construct() 
    {
        $this->sTable = "employees";
        parent::__construct();
        $this->load_fileds();
    }
    
    //hace un mapeo de los campos que vienen del formulario y los campos reales en bd
    public function load_fileds()
    {
        $arTmp = [
            ["db"=>"emp_no","ui"=>"empno"],
            ["db"=>"first_name","ui"=>"firstname"],
            ["db"=>"last_name","ui"=>"lastname"],
            ["db"=>"birth_name","ui"=>"birthname"],
            ["db"=>"hire_date","ui"=>"hiredate"],
            ["db"=>"gender","ui"=>"gender"]
        ];
        $this->arFields = $arTmp;
    }
    
    public function get_new_empno()
    {
        $sSQL = "
        /*EmployeeModel.get_maxcode*/
        SELECT MAX(emp_no)+1 AS empno FROM employees";
        $arRow = $this->oDb->query($sSQL);
        return $arRow[0]["empno"];
    }//get_newcode
    
    // listado
    public function get_list()
    {
/*
id (employees.emp_no)
nombre (employees.first_name) 
apellidos (employees.last_name)
fecha_contratacion (employees.hire_date)
cargo (titles.title) 
salario (salaries.salary)
departamento (departments.dept_name)
*/       
        $sSQL = "
        /*EmployeeModel.get_list*/
        SELECT DISTINCT e.`emp_no` AS id
        ,e.`first_name` AS nombre
        ,e.`last_name` AS apellidos
        ,e.`hire_date` AS fecha_contratacion
        ,t.`title` AS cargo
        ,s.`salary` AS salario
        ,d.`dept_name` AS departamento
        FROM employees e
	LEFT JOIN 
        (
            -- cargo empleado por fecha
            SELECT t.emp_no,t.title
            FROM titles t
            INNER JOIN 
            (
                -- fecha más actual por empleado
                SELECT emp_no,MAX(from_date) from_date
                FROM titles 
                GROUP BY emp_no
            ) tgroup
            ON t.emp_no = tgroup.emp_no
            AND t.from_date = tgroup.from_date
        ) t
	ON e.`emp_no` = t.`emp_no`
        LEFT JOIN 
        (
	    -- slario empleado por fecha
            SELECT s.emp_no,s.salary
            FROM salaries s
            INNER JOIN 
            (
                -- fecha más actual por empleado
                SELECT emp_no,MAX(from_date) from_date
                FROM salaries 
                GROUP BY emp_no
            ) tgroup
            ON s.emp_no = tgroup.emp_no
            AND s.from_date = tgroup.from_date        
        ) s
        ON e.`emp_no` = s.`emp_no`
        LEFT JOIN 
        (
            SELECT m.emp_no,m.dept_no
            FROM dept_manager m
            INNER JOIN
            (
                -- los departamentos en caso de ser manager 
                SELECT emp_no,MAX(from_date) from_date
                FROM dept_manager 
                GROUP BY emp_no
            )tgroup
            ON m.emp_no = tgroup.emp_no
            AND m.from_date = tgroup.from_date
            
                UNION 
            -- los departamentos de empleados
            SELECT e.emp_no,e.dept_no
            FROM dept_emp e
            INNER JOIN
            (
                -- los departamentos en caso de ser manager 
                SELECT emp_no,MAX(from_date) from_date
                FROM dept_emp
                GROUP BY emp_no
            )tgroup
            ON e.emp_no = tgroup.emp_no
            AND e.from_date = tgroup.from_date
            
        ) AS dept
        ON e.`emp_no` = dept.emp_no
        INNER JOIN departments d
        ON dept.dept_no = d.`dept_no`
        ORDER BY e.`hire_date` ASC
        LIMIT 50
        ";
        $this->log($sSQL,"EmployeeModel");
        $arRows = $this->oDb->query($sSQL);
        return $arRows;
    }//get_list
    
    // detalle / ficha del empleado
    public function get_profile($id)
    {
/*
id (employees.emp_no)
nombre (employees.first_name) 
apellidos (employees.last_name)
genero (employees.gender)
fecha_contratacion (employees.hire_date)
fecha_nacimiento (employees.birth_date)
departamento (departments.dept_name)
cargo (titles.title) 
salario (salaries.salary)
*/       
        if(is_numeric($id))
        {
            $sSQL = "
            /*EmployeeModel.get_profile*/
            SELECT DISTINCT e.`emp_no` AS id
            ,e.`first_name` AS nombre
            ,e.`last_name` AS apellidos
            ,e.`gender` AS genero
            ,e.`hire_date` AS fecha_contratacion
            ,e.`birth_date` AS fecha_nacimiento
            ,d.`dept_name` AS departamento        
            ,t.`title` AS cargo
            ,s.`salary` AS salario
            FROM employees e
            LEFT JOIN 
            (
                -- cargo empleado por fecha
                SELECT t.emp_no,t.title
                FROM titles t
                INNER JOIN 
                (
                    -- fecha más actual por empleado
                    SELECT emp_no,MAX(from_date) from_date
                    FROM titles
                    WHERE 1
                    AND emp_no=$id
                    GROUP BY emp_no
                ) tgroup
                ON t.emp_no = tgroup.emp_no
                AND t.from_date = tgroup.from_date
            ) t
            ON e.`emp_no` = t.`emp_no`
            LEFT JOIN 
            (
                -- slario empleado por fecha
                SELECT s.emp_no,s.salary
                FROM salaries s
                INNER JOIN 
                (
                    -- fecha más actual por empleado
                    SELECT emp_no,MAX(from_date) from_date
                    FROM salaries 
                    WHERE 1
                    AND emp_no=$id                    
                    GROUP BY emp_no
                ) tgroup
                ON s.emp_no = tgroup.emp_no
                AND s.from_date = tgroup.from_date        
            ) s
            ON e.`emp_no` = s.`emp_no`
            LEFT JOIN 
            (
                SELECT m.emp_no,m.dept_no
                FROM dept_manager m
                INNER JOIN
                (
                    -- los departamentos en caso de ser manager 
                    SELECT emp_no,MAX(from_date) from_date
                    FROM dept_manager 
                    WHERE 1
                    AND emp_no=$id                    
                    GROUP BY emp_no
                )tgroup
                ON m.emp_no = tgroup.emp_no
                AND m.from_date = tgroup.from_date

                    UNION 
                -- los departamentos de empleados
                SELECT e.emp_no,e.dept_no
                FROM dept_emp e
                INNER JOIN
                (
                    -- los departamentos en caso de ser manager 
                    SELECT emp_no,MAX(from_date) from_date
                    FROM dept_emp
                    WHERE 1
                    AND emp_no=$id                    
                    GROUP BY emp_no
                )tgroup
                ON e.emp_no = tgroup.emp_no
                AND e.from_date = tgroup.from_date

            ) AS dept
            ON e.`emp_no` = dept.emp_no
            INNER JOIN departments d
            ON dept.dept_no = d.`dept_no`
            ORDER BY e.`hire_date` ASC
            LIMIT 50
            ";
            $this->log($sSQL,"EmployeeModel");
            $arRows = $this->oDb->query($sSQL);
            return $arRows;
        }
        return [];
    }//get_profile
   

}//EmployeeModel
