#RENQO MICROSERVICE


Renqo Microservice es una herramienta que tiene los metodos necesarios para la comunicación entre microservicios.
Se complementa perfectamente con RENQO ACL SERVER el cual se encargará de la gestion de usuarios y privilegios como si
fuera un microservicio más.

Renqo Microservice se conectará por medio de peticiones HTTP a los diferentes microservicios, asi también cuando estos
microservicios quieran solicitar peticiones, renqo microservice validará y en caso de éxito concedera el acceso al uso
del recurso dentro del micro servicio.

## Instalación
Puede instalarlo a traves de composer de la siguiente manera:
```cmd
composer require adolfocuadros/renqo-microservice
```
