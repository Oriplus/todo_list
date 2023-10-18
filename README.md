# Todo Task List

Agrega, edita, elimina y cambia de estatus tareas!



![image](https://github.com/Oriplus/todo_list/assets/42686893/931515a2-26d7-4b7f-8c79-62767dc6d906)



## Como ejecutar el proyecto

## Usando configuración local de docker del proyecto:

#### NOTA: por simplicidad se puede copiar el mismo .env.example, pero las credenciales .env deberian ser privadas .

Crear el archivo /config/.env con los mismos datos de /config/.env.example

 En la raiz de proyecto ejecutar
```
 docker-compose build
```
```
 docker-compose up  -d
```

```
 docker-compose exec web bash
```
Instalamos dependencias
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

```
 docker-compose exec web bash
```

```
npm test
```

```
./vendor/bin/phpunit tests
```

## Otras opciones aparte de docker:
* Usar xampp con php 7.4 y MySQL 5.7
* Node v 18.x
