## Simple Logistic Management App

How to run project : 

- Clone Repository
- Run
<pre><code>
composer install
</code></pre>
- Setup .env file, you can copy from .env.example
- Add or change .env configuration  below
- Add database configuration example : 
<pre><code>
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=
</code></pre>
- Run code below using terminal
<pre><code>
php artisan key:generate
</code></pre>
- Run Laravel Migration to create tables
<pre><code>
php artisan migrate
</code></pre>
- Run Laravel Development Server
<pre><code>
php artisan serve
</code></pre>
- Access to http://127.0.0.1:8000/

## Route List
<table>
    <tr>
        <th>Route</td>
        <th>Method</td>
    </tr>
    <tr>
        <th>/api/register</td>
        <th>POST</td>
    </tr>
    <tr>
        <th>/api/login</td>
        <th>POST</td>
    </tr>
    <tr>
        <th>/api/order</td>
        <th>POST</td>
    </tr>
    <tr>
        <th>/api/order/{order_id}</td>
        <th>GET</td>
    </tr>
    <tr>
        <th>/api/order/detail/{order_id}</td>
        <th>GET</td>
    </tr>
</table>
