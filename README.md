# Mini API REST

> Repo: https://github.com/eacevedof/prj_miniapi

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
    - http://telecoming.eduardoaf.com/employees/profile?id=10253
- http://telecoming.eduardoaf.com/picklists/departments
- http://telecoming.eduardoaf.com/picklists/titles

<hr/>

## Frontend:
- `/`: listado de empleados
- `/employee/profile/{emp_no}`: Perfil del empleado
- `/employee/insert`: Crear un empleado

### Live examples
- http://employees.eduardoaf.com/
- http://employees.eduardoaf.com/employees
- http://employees.eduardoaf.com/employee/profile/{emp_no}
- http://employees.eduardoaf.com/employee/insert

### Vue.js
- La aplicación en Vue se encuentra en este repositorio:
    **https://github.com/eacevedof/prj_vue2_rimor1/tree/master/vuecli-router**
    Originalmente esta aplicación fue un tutorial de Vue que lo he reciclado para el 
    frontend de este proyecto.
    
- En la carpeta frontend dejaré solo el compilado de producción de Vue.


