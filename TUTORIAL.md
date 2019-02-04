# codeigniter-datatables

Datatables es un set de codigo javascript que permite dar funcionalidades 
a tablas html como si de formularios se tratase, como buscador dinamico, 
ordenamiento por columnas al click, y data en demanda por ajax..

Este ejemplo emplea datatables con jquery embebido, es decir, en un solo 
archivo javascript [assets/datatables/datatables.js](assets/datatables/datatables.js) 
esta tanto el datatables, como el jquery que permitiran usar data en dinamico.

## Requisitos e inicio

* codeigniter (este repo tien un submodulo de CI2)
* git
* php5 no se recomienda php7
* sqlite o mysql o DBMS alguno

## Preparacion

* descarge CI3 o CI2 y descomprima en `Devel`
* el CI3/CI2 tiene un directorio llamado `system`, y `application`
* descarge `application/controllers/datatables.php` y copielo en el CI en `application/controllers`
* descarge `application/models/datatables_model.php` y copielo en el CI en `application/models`
* descarge `application/views/datatables_views*.php` y copielo en el CI en `application/views`
* configure el acceso a una DBMS en `applications/config/database.php` sqlite no necesita usuario
* una vez configurado inicie un servidor pruebas con `php -S 127.0.0.1:8120 -t Devel`
* abra el navegador y use la direccion `http:127.0.0.1:8120` y vera el directorio de CI
* navege hacia del directorio de el codeigniter que tien el ejemplo de datatables.

## Codeigniter y datatables con ajax

1. El controlador en `index` llama a una vista `datatables_view_index` que 
pinta el formulario, el formulario tiene uan llamada o su destino es 
el controller/metodo `datatables/verdata` que pintara una tabla con los 
datos desde la base de datos. Hast aqui todo normal.

2. 


