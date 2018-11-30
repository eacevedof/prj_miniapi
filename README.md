# Mini API REST

> Repo: https://github.com/eacevedof/prj_miniapi

> [Especificaciones](https://docs.google.com/document/d/1OjpH4HSNwnkJvEKZUx7cf5dCJuQZ15a1gqYmf9lYEq4/edit?usp=sharing)

## Backend:

- Lanzar la API con el siguiente comando
```
Esto sirve la api
php -S localhost:3000 -t backend/public

Esto sirve bootstrap
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
- http://telecoming.eduardoaf.com/picklists/departments
- http://telecoming.eduardoaf.com/picklists/titles

<hr/>

## Frontend:

- En este fichero `prj_miniapi\frontend\static\config.json` se configura el dominio de la API. 

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

