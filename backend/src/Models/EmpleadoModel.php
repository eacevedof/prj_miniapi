<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Models\EmpleadoModel 
 * @observations
 */
namespace App\Models;

use TheFramework\Components\ComponentDebug;
use TheFramework\Components\Db\ComponentMysql;

class EmpleadoModel 
{
    private $oDb;
    
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
    
    private function get_config($sKey)
    {
        $arConfig = realpath(__DIR__."/../config/config.php");
        $arConfig = include($arConfig);
        return $arConfig[$sKey];        
    }
    
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
        /*EmpleadoModel.get_list*/
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
            /*EmpleadoModel.get_profile*/
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
            LEFT JOIN titles t
            ON e.`emp_no` = t.`emp_no`
            LEFT JOIN salaries s
            ON e.`emp_no` = s.`emp_no`
            -- AND t.`from_date` = s.`from_date`
            INNER JOIN 
            (
                -- los departamentos en caso de ser manager 
                SELECT dept_no,emp_no
                FROM dept_manager
                WHERE emp_no=$id
                    UNION 
                -- los departamentos de empleados
                SELECT dept_no,emp_no
                FROM dept_emp
                WHERE emp_no=$id
            ) AS dept
            ON e.`emp_no` = dept.emp_no
            INNER JOIN departments d
            ON dept.dept_no = d.`dept_no`
            WHERE 1
            AND e.emp_no=$id
            ";
            ComponentDebug::log($sSQL);
            $arRows = $this->oDb->query($sSQL);
            return $arRows;
        }
        return [];
    }//get_profile
    
    // insert
    public function insert($arData)
    {
/*
Inserción de un empleado con los siguientes parámetros:
first_name
last_name
birth_name
gender
dept_no
title
salary
*/
        if($arData && is_array($arData))
        {
            $arFields = array_keys($arData);
            $arValues = array_values($arData);
            $sFields = implode(",",$arFields);
            $sValues = implode("','",$arValues);

            $sSQL = "INSERT INTO ($sFields) VALUES ('$sValues')";
            $this->oDb->exec($sSQL);
            if($this->oDb->is_error())
                return FALSE;
            return TRUE;
        }
        return FALSE;
    }//insert

}//EmpleadoModel