<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name App\Models\EmployeeModel 
 * @file EmployeeModel.php v2.0.0
 * @date 29-11-2018 19:00 SPAIN
 * @observations
 */
namespace App\Models;

use App\Models\AppModel;
use TheFramework\Components\Db\ComponentCrud;

class EmployeeModel extends AppModel
{
    private $iPerPage;
    private $iPage;

    private $arQueries;

    public function __construct() 
    {
        $this->arQueries = [];
        $this->sTable = "employees";
        $this->iPage = 1;
        $this->iPerPage = 50;
        parent::__construct();
        $this->load_pk_fields();
        $this->load_fileds();
        $this->load_queries();
        
        //$this->get_list_obj();
    }
    
    //hace un mapeo de los campos que vienen del formulario y los campos reales en bd
    private function load_fileds()
    {
        $arTmp = [
            ["db"=>"emp_no","ui"=>"empno"],
            ["db"=>"first_name","ui"=>"firstname"],
            ["db"=>"last_name","ui"=>"lastname"],
            ["db"=>"birth_date","ui"=>"birthdate"],
            ["db"=>"hire_date","ui"=>"hiredate"],
            ["db"=>"gender","ui"=>"gender"]
        ];
        $this->arFields = $arTmp;
    }

    private function load_pk_fields()
    {
        $this->arPks = ["emp_no"];
    }//load_pk_fields  
    
    private function get_list_obj()
    {
        $oCrud = new ComponentCrud();
        $oCrud->set_comment("list");
        $oCrud->set_table("$this->sTable e");
        $oCrud->add_getfield("e.`emp_no` AS id");
        $oCrud->add_getfield("e.`first_name` AS nombre");
        $oCrud->add_getfield("e.`last_name` AS apellidos");
        $oCrud->add_getfield("e.`hire_date` AS fecha_contratacion");
        $oCrud->add_getfield("t.`title` AS cargo");
        $oCrud->add_getfield("s.`salary` AS salario");
        $oCrud->add_getfield("d.`dept_name` AS departamento");
        $oCrud->add_join("
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
        ON dept.dept_no = d.`dept_no`");
        $oCrud->add_orderby("e.`hire_date`");
        $oCrud->add_end("LIMIT 0,50");
        $oCrud->get_selectfrom();
        return $oCrud;
    }//get_list
    
    public function load_queries()
    {
     
        $this->arQueries["get_list"] ="        
        /*EmployeeModel.get_list*/
        SELECT e.`emp_no` AS id
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
        ";  
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
        $this->arQueries["get_profile"] = "
        /*EmployeeModel.get_profile*/
        SELECT e.`emp_no` AS id
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
                AND emp_no={id}
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
                AND emp_no={id}                    
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
                AND emp_no={id}                    
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
                AND emp_no={id}                    
                GROUP BY emp_no
            )tgroup
            ON e.emp_no = tgroup.emp_no
            AND e.from_date = tgroup.from_date

        ) AS dept
        ON e.`emp_no` = dept.emp_no
        INNER JOIN departments d
        ON dept.dept_no = d.`dept_no`
        ";

    }//load_queries

    public function get_new_empno()
    {
        $sSQL = "
        /*EmployeeModel.get_maxcode*/
        SELECT MAX(emp_no)+1 AS empno FROM employees";
        $arRow = $this->oDb->query($sSQL);
        return $arRow[0]["empno"];
    }//get_newcode
    
    public function get_total_regs()
    {
        $sSQL = $this->arQueries["get_list"];
        $arRows = $this->oDb->query($sSQL);
        return count($arRows);
    }//get_total_regs

    // listado
    public function get_list()
    {
        $iPage = ($this->iPage-1);
        $iFrom = $iPage*$this->iPerPage;
        
        $sSQL = $this->arQueries["get_list"];
        $sSQL .= "
        ORDER BY e.`hire_date` ASC
        LIMIT $iFrom,$this->iPerPage
        ";
        $this->log($sSQL,"-- EmployeeModel.get_list");
        $arRows = $this->oDb->query($sSQL);
        return $arRows;
    }//get_list
    
    // detalle / ficha del empleado
    public function get_profile($id)
    {
        if(is_numeric($id))
        {
            $sSQL = $this->arQueries["get_profile"];
            $sSQL = str_replace("{id}",$id,$sSQL);
            $this->log($sSQL,"EmployeeModel.get_profile");
            $arRows = $this->oDb->query($sSQL);
            return $arRows;
        }
        return [];
    }//get_profile
   
    public function get_pagination()
    {
        $iPerPage = $this->iPerPage;
        $iTotRegs = $this->get_total_regs();
        //las paginas completas, es decir con 50 regs
        $iFullPages = ceil($iTotRegs/$iPerPage)-1;
        $iRegsRemained = $iTotRegs%$iPerPage;
        if($iRegsRemained>0) $iFullPages++;

        $arPages["currpage"] = $this->iPage;
        $arPages["totpages"] = (int)$iFullPages;
        //$arPages["halfpages"] = $iRegsRemained;
        $arPages["totregs"] = $iTotRegs;
        $arPages["perpage"] = $iPerPage;
        
        return $arPages;
    }//get_pagination

    public function get_gender()
    {
        $oCrud = new \TheFramework\Components\Db\ComponentCrud($this->oDb);
        $oCrud->set_comment("EmployeeModel.get_gender");
        $oCrud->set_table($this->sTable);
        $oCrud->is_distinct();
        $oCrud->add_getfield("gender");
        $oCrud->add_numeric("1");
        $oCrud->add_pk_fv("1","1");// where 1=1
        $oCrud->add_ands("gender","''","!="); //and gender!=''
        $oCrud->add_orderby("gender"); //order by gender asc
        $arRows = $oCrud->get_selectfrom();
        $this->log($oCrud->get_sql());
        return $arRows;
    }
    
    public function set_perpage($iValue){$this->iPerPage = ($iValue===0)?1:$iValue;}
    public function set_page($iValue){$this->iPage = $iValue;}

}//EmployeeModel

/*
+-----------+------------+------+-----------+----------+
| tablename | fieldname  | ispk | fieldtype | fieldlen |
+-----------+------------+------+-----------+----------+
| employees | emp_no     | Y    | int       | \N       |
| employees | birth_date |      | date      | \N       |
| employees | first_name |      | varchar   | 14       |
| employees | last_name  |      | varchar   | 16       |
| employees | gender     |      | enum      | 1        |
| employees | hire_date  |      | date      | \N       |
+-----------+------------+------+-----------+----------+
*/