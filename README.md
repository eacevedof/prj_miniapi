# Mini API REST
>> Repo:

## Backend:

- Lanzar la API con el siguiente comando
```
php -S localhost:3000 -t backend/public
```

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
- http://telecoming.eduardoaf.com/employees/profile?id={emp_no}
- http://telecoming.eduardoaf.com/picklists/departments
- http://telecoming.eduardoaf.com/picklists/titles

<hr/>

## Frontend:
- `/`: listado de empleados
- `/employee/profile/{emp_no}`: Perfil del empleado
- `/employee/insert`: Crear un empleado

### Live examples
- http://front.eduardoaf.com/
- http://front.eduardoaf.com/employees
- http://front.eduardoaf.com/employee/profile/{emp_no}
- http://front.eduardoaf.com/employee/insert
