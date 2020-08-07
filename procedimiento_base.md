
ciclo de vida petición laravel

petición
ruta laravel, apunta a una vsita => contenido estático
                                 => flujo estandar => controlador => acción  => modelo => BD (o mediante un store procedure)

Finalmente lo que retorne la base de datos regresa al controlador y posteriormente a la  vista.

- Dentro de views, crearemos un archivo:
app.blade.php
- Una vez creado, copiamos el contenido de la plantilla adminLTE3 : pages/forms/general.html


- posteriormente en el archivo webpack.mix.js:
mix.styles([
    'resources/vendor/css/all.min.css',
    'resources/vendor/css/adminlte.min.css',
    'resources/vendor/css/adminlte.min.css'
], 'public/css/plantilla.css')
.js('resources/js/app.js', 'public/js') // jquery, bootstrap, Vuejs
.scripts([
    'resources/vendor/js/adminlte.min.js',
    'resources/vendor/js/demo.js'
], 'public/js/plantilla.js');


- ejecutamos:
npm install
npm run dev

- Tan pronto tengamos linkeado adecuadamente las referencias CSS y JS 

# 1 FRONTEND VUE
- Instalamos primero el paquete con composer:
[COMANDO]:
composer require laravel/ui

- Una vez instalado lo anterior, se procede a instalar VUE:
[COMANDO]:
php artisan ui vue

## VUE ROUTER
instalación:
[COMANDO]:
npm install vue-router

- Se crea el fichero de rutas: routes.js con el componente a cargar en determinada ruta.

- Se crea luego dentro de la carpeta components, la carpeta:  
[CARPETA]:
modulos
    categoria
    cliente
    dahsboard
    pedido
    permiso
    producto
    reporte
    rol
    usuario




## MIGRACIONES:
[COMANDO]:
php artisan make:migration create_files_table

- Ahora modificamos la fecha del Timestamp para que se ejecute primero:
CAMBIAMOS SIMPLEMENTE EL AÑO POR: 2014 para que esté antes de la migración de users

### MIGRACIÓN PERSMISOS
[COMANDO]:
php artisan make:migration create_permissions_table
- con los campos:
[SOURCE]:
            $table->string('slug');
            $table->string('name');


### MIGRACIÓN ROLES
[COMANDO]:
php artisan make:migration create_roles_table
[SOURCE]:
            $table->string('slug');
            $table->string('name');



### MIGRACIÓN USUARIOS - PERMISOS
[COMANDO]:
php artisan make:migration create_users_persmissions_table
[SOURCE]:
            $table->bigInteger('user_id')->unsigned()->required();
            $table->bigInteger('permission_id')->unsigned()->required();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('permission_id')->references('id')->on('permissions');




### MIGRACIÓN USUARIOS - ROLES
[COMANDO]:
php artisan make:migration create_users_roles_table
[SOURCE]:
            $table->bigInteger('user_id')->unsigned()->required();
            $table->bigInteger('role_id')->unsigned()->required();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');




### MIGRACIÓN ROLES - PERMISSIONS
[COMANDO]:
php artisan make:migration create_roles_permissions_table
[SOURCE]:
            $table->bigInteger('user_id')->unsigned()->required();
            $table->bigInteger('role_id')->unsigned()->required();




### MIGRACIÓN MENSAJES
[COMANDO]:
php artisan make:migration create_messages_table
[SOURCE]:
            $table->bigIncrements('id');
            $table->integer('from')->unsigned();
            $table->intenger('to')->unsigned();
            $table->boolean('read')->default(false);
            $table->text('text');




### MIGRACIÓN CATEGORÍAS
[COMANDO]:
php artisan make:migration create_categories_table
[SOURCE]:
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->bigInteger('created_at')->unsigned()->index();
            $table->bigInteger('updated_at')->unsigned()->index();
            



### MIGRACIÓN PRODUCTOS
[COMANDO]:
php artisan make:migration create_products_table
[SOURCE]:
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->smallInteger('stock')->default(1);
            $table->double('price', 4,2)->default(10.50);
            $table->bigInteger('categorie_id')->unsigned()->nullable();
            $table->bigInteger('created_by')->unsigned()->index();
            $table->bigInteger('updated_by')->unsigned()->index();



### MIGRACIÓN CLIENTES (CUSTOMERS)
[COMANDO]:
php artisan make:migration create_customers_table
[SOURCE]:
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('lastname')->index();
            $table->string('document')->index();
            $table->string('phone')->nullable();
            $table->string('email')->index()->nullable();
            $table->bigInteger('created_by')->unsigned()->index();
            $table->bigInteger('updated_by')->unsigned()->index();





### MIGRACIÓN ORDERS
[COMANDO]:
php artisan make:migration create_orders_table
[SOURCE]:
            $table->bigIncrements('id');
            $table->string('order_number')->nullable;
            $table->string('comments')->index();
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->double('total', 4,2)->default(10.50);

            $table->bigInteger('created_by')->unsigned()->index();
            $table->bigInteger('updated_by')->unsigned()->index();            
            $table->enum('state', ['A', 'I'])->nullable()->default('A');
            
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('user_id')->references('id')->on('users');


### MIGRACIÓN   DETAILS ORDERS
[COMANDO]:
php artisan make:migration create_details_orders_table
[SOURCE]:            
            $table->bigInteger('order_id')->unsigned()->required();
            $table->bigInteger('product_id')->unsigned()->required();

            $table->smallInteger('quantity')->nullable()->default(12);
            $table->smallInteger('price')->nullable()->default(12);

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('product_id')->references('id')->on('products');


## FINALMENTE SE EJECUTA EL COMANDO:
[COMANDO]:
php artisan migrate



---------------------------------------------------------------------------
# GIT COMANDOS
---------------------------------------------------------------------------

git config --global user.name = "Jaime Diaz"
git config --global user.email = "jaimeivan0017@gmail.com"
git remote add origin https://jdiaz0017@bitbucket.org/jdiaz0017/laravelvue.git

- Work directory
- Index (area de ensao)
- Head (apunta al ultimo commit realizado)

git add -A
git commit -m "Commit inicial del proyecto con todas las migraciones realizadas"

Git pull origin master (si no hay diferencias todo estará actualizado)
