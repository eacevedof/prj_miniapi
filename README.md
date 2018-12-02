# Mini API REST

> Repo: https://github.com/eacevedof/prj_miniapi

> [Especificaciones](https://docs.google.com/document/d/1OjpH4HSNwnkJvEKZUx7cf5dCJuQZ15a1gqYmf9lYEq4/edit?usp=sharing)

<hr/>

## Frontend:

- En este fichero `<project>\frontend\static\config.js` se configura el **endpoint** raíz de la API. 

- `/`: listado de empleados
- `/employee/profile/{emp_no}`: Perfil del empleado
- `/employee/insert`: Crear un empleado

### Live examples
- http://employees.eduardoaf.com/
- http://employees.eduardoaf.com/employee/profile/{emp_no}

### Vue.js
- La aplicación en Vue se encuentra en este repositorio:
    **https://github.com/eacevedof/prj_vue2_rimor1/tree/master/vuecli-router**
    Originalmente esta aplicación fue un tutorial de Vue que lo he reciclado para el 
    frontend de este proyecto.
    
- En la carpeta frontend dejaré solo el compilado de producción de Vue.
- He utilizado composer para apoyarme en su autoload
- Dentro de vendor vereis una carpeta llamada `theframework`. Esta aloja clases creadas por mi y no es un framework como tal.

<hr/>

## Backend:

- Lanzar la API con el siguiente comando
```
Esto sirve la api
php -S localhost:3000 -t backend/public

Esto sirve bootstrap (con vue.js)
php -S localhost:9000 -t frontend
```

- En este fichero `prj_miniapi\backend\src\config\config.php` se configura la base de datos.

### Endpoints

- `/`: Links con endpoints
- `/employees` | `/employees/`: Listado de empleados
- `/employees/profile` | `/employees/profile/`: Perfil empleado
- `/employees/insert` | `/employees/insert/`: Crear empleado
- `/picklists/departments` : Datos código/descripción de departamentos. Para llenar elementos `<select>`
- `/picklists/titles` : Datos código/descripción de cargos. Para llenar elementos `<select>`

### Live examples
- http://telecoming.eduardoaf.com/
- http://telecoming.eduardoaf.com/employees
- http://telecoming.eduardoaf.com/employees?page={npage}
    - http://telecoming.eduardoaf.com/employees?page=5
    - <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5c00dcb10fef127436125407/b8322df5b69d543942c49c9da2b11c86/image.png" 
         width="300" height="150">
- http://telecoming.eduardoaf.com/employees/insert
    - <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5c00dcb10fef127436125407/bf573d001978cfcff12dcd65c3297aef/image.png" 
         width="300" height="150">

- http://telecoming.eduardoaf.com/employees/profile?id={emp_no}
    - http://telecoming.eduardoaf.com/employees/profile?id=10253
    - <img src="https://trello-attachments.s3.amazonaws.com/5b014dcaf4507eacfc1b4540/5c00dcb10fef127436125407/5df221f5c8222743c993ac4be5c42fcd/image.png" 
         width="300" height="150">

- http://telecoming.eduardoaf.com/picklists/departments
- http://telecoming.eduardoaf.com/picklists/titles

<hr/>

### Consultas

#### Listado con posibilidad de filtrado

```sql
SELECT e.`emp_no` AS id,
e.`first_name` AS nombre,
e.`last_name` AS apellidos,
e.`hire_date` AS fecha_contratacion,
t.`title` AS cargo,
s.`salary` AS salario,
d.`dept_name` AS departamento 
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
WHERE 
(
    -- filtro
    e.emp_no LIKE '%develo%' OR
    e.first_name LIKE '%develo%' OR
    e.last_name LIKE '%develo%' OR
    e.hire_date LIKE '%develo%' OR
    t.title LIKE '%develo%' OR
    s.salary LIKE '%develo%' OR
    d.dept_name LIKE '%develo%'
) 
ORDER BY e.`hire_date` ASC 
LIMIT 2,50
```

#### Consulta del detalle del empleado

```sql
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
```