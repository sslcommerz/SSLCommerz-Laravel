=== Plugin Name ===
Contributors: C.M.Sayedur Rahman
	      cmsayed@gmail.com
Tags: Payment Gateway, SSLCommerz, IPN, Laravel 5.6
Requires : PHP 5.6 and Mysql
License: GPLv2 or later

== Description ==
In this example you will find below script and a mysql table creation file.
  1. routes\web.php : Create route for the functions
  2. app\Http\Controllers\PublicSslCommerzPaymentController.php: All the functions to do the transaction. Read the comments carefully.
  3. app\Http\Controllers\SSLCommerz.php: Helping class, here you will input store information
  4. app\Http\Middleware\VerifyCsrfToken.php : Input Route names to accept call from out side your site
  

==Run the project==
	1. First create your Sanbox store account from below url. After registration you will get two mail. One for Store_id and Store_password.
	   Another one for Report panel access.	
	   https://developer.sslcommerz.com/registration/
	2. Then give the store_id and store_password in SSLCommerz.php page. 
	3. Here you have to run the PublicSslCommerzPaymentController.php controller by calling pay(Like: http://yourdomain.com/pay or http://yourdomain.com/public/pay)
	   Here you have to receive all the order data to initate the payment.
           Lets your oder trnsaction informations are saving in a table called "orders"
           In orders table order uniq identity is "order_id","order_status" field contain status of the transaction, "grand_total" 
	   is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

== Help URL==
	1. https://developer.sslcommerz.com/docs.html :URL to start integrate SSLCOMMERZ as a Developer
	2. https://developer.sslcommerz.com/registration/: URL to Create Account in Sandbox

