# Mini API REST
>> Repo:

## Backend:

- Lanzar la API con el siguiente comando
```
php -S localhost:3000 -t backend/public
```

### Endpoints

- `/`: Links con endpoints
- `/empleados` | `/empleados/`: Listado de empleados
- `/empleados/profile` | `/empleados/profile/`: Perfil empleado
- `/empleados/insert` | `/empleados/insert/`: Crear empleado
- `/picklists/departments` : Datos código/descripción de departamentos. Para llenar elementos `<select>`
- `/picklists/titles` : Datos código/descripción de cargos. Para llenar elementos `<select>`

### Live examples
- http://telecoming.eduardoaf.com/
- http://telecoming.eduardoaf.com/empleados
- http://telecoming.eduardoaf.com/empleados/profile?id={emp_no}
- http://telecoming.eduardoaf.com/picklists/departments
- http://telecoming.eduardoaf.com/picklists/titles

<hr/>

## Frontend:
- `/`: listado de empleados
- `/employee/profile/{emp_no}`: Perfil del empleado
- `/employee/insert`: Crear un empleado

### Live examples
- http://front.eduardoaf.com/
- http://front.eduardoaf.com/empleados
- http://front.eduardoaf.com/employee/profile/{emp_no}
- http://front.eduardoaf.com/employee/insert
