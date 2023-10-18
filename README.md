# Todo Task List

Agrega, edita, elimina y cambia de estatus tareas!



![image](https://github.com/Oriplus/todo_list/assets/42686893/931515a2-26d7-4b7f-8c79-62767dc6d906)

Componentes Vue se encuentran en /src

[Database dump](https://github.com/Oriplus/todo_list/blob/master/database.sql)

## Como ejecutar el proyecto

#### NOTA: por simplicidad se puede copiar el mismo .env.example, pero las credenciales .env deberian ser privadas .

Crear el archivo /config/.env con los mismos datos de /config/.env.example


### Usando configuración local con xampp:
* Usar xampp con php 7.4 y MySQL 5.7
* Vue 2
* Composer
* Node v 18.x

<details>
  <summary>Con docker localmente</summary>
 En la raiz de proyecto ejecutar
    
```
 docker-compose build
```
```
 docker-compose up  -d
```
</details>

Instalamos dependencias
(si se esta usando Docker ejecutar primero `docker-compose exec web bash`)
```
composer install
```
Copiar Security.salt valor creado en config/app_local.php en la variable de entorno SECURITY_SALT
```
 npm install
```
Ejecutamos migraciones y seeds
```
 bin/cake migrations migrate
```
```
 bin/cake migrations seed
```

Ingresar a localhost

## Test

Ejecutar los test

(si se esta usando Docker ejecutar primero `docker-compose exec web bash`)
```
npm test
```

```
./vendor/bin/phpunit tests
```

## Informacion adicional
Ejecutar en modo desarrollo
```
npm run dev
```
