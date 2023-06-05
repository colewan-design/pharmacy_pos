DB SETUP
<br>
~ php artisan mysql:createdb point_of_sale
<br>
~php artisan migrate
~php artisan db:seed

php artisan key:generate

VHOST
<br>php

<textarea>
<VirtualHost *:80>
DocumentRoot C:\xampp\htdocs\SAHEI_CORE_TECHNOLOGIES_CO\point_of_sale\public
ServerName point_of_sale.com.ph
</VirtualHost>
</textarea>


<br>
<br>

HOST
<br>
~127.0.0.1 point_of_sale.com.ph

ROUTES
<br>
/dashboard
<br>
/product_category
<br>
/item
<br>
/department
<br>
