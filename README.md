### SSLCommerz - Laravel Library

__Tags:__ Payment Gateway, SSLCommerz, IPN

__Requires:__  Laravel >= 5.6 and MySQL

__License:__ GPLv2 or later


#### Core Library Directory Structure

```
 |-- config/
    |-- sslcommerz.php
 |-- app/Library/SslCommerz
    |-- AbstractSslCommerz.php (core file)
    |-- SslCommerzInterface.php (core file)
    |-- SslCommerzNotification.php (core file)
 |-- README.md
 |-- orders.sql (sample)
```

#### Instructions:

* __Step 1:__ Download and extract the library files.

* __Step 2:__ Copy the `Library` folder and put it in the laravel project's `app/` directory. If needed, then run `composer dump -o`.

* __Step 3:__ Copy the `config/sslcommerz.php` file into your project's `config/` folder.

Now, we have already copied the core library files. Let's do copy some other helpers files that is provided to understand the integration process. The other files are not related to core library. 

* __Step 4:__ Add `STORE_ID` and `STORE_PASSWORD` values on your project's `.env` file. You can register for a store at [https://developer.sslcommerz.com/registration/](https://developer.sslcommerz.com/registration/)

* __Step 5:__ Copy the `SslCommerzPaymentController` into your project's `Controllers` folder.

* __Step 6:__ Copy the defined routes from `routes/web.php` into your project's route file.

* __Step 7:__ Add the below routes into the `$excepts` array of `VerifyCsrfToken` middleware.

```
protected $except = [
    '/pay-via-ajax', '/success','/cancel','/fail','/ipn'
];
```


* __Step 8:__ Copy the `resources/views/*.blade.php` files into your project's `resources/views/` folder.


Now, let's go to the main integration part. 
* __Step 9:__ To integrate popup checkout, use the below script before the end of body tag.

##### For Sandbox
```
<script>
    (function (window, document) {
        var loader = function () {
            var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
            script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
            tag.parentNode.insertBefore(script, tag);
        };

        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    })(window, document);
</script>
```

##### For Live
```
<script>
    (function (window, document) {
        var loader = function () {
            var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
            script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
            tag.parentNode.insertBefore(script, tag);
        };
    
        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    })(window, document);
</script>
```

* __Step 10:__ Use the below button where you want to show the **"Pay Now"** button:

```
<button class="your-button-class" id="sslczPayBtn"
        token="if you have any token validation"
        postdata="your javascript arrays or objects which requires in backend"
        order="If you already have the transaction generated for current order"
        endpoint="/pay-via-ajax"> Pay Now
</button>
```

* __Step 11:__ For EasyCheckout (Popup) integration, you can update the `checkout_ajax.php` or use a different file according to your need. We have provided a basic sample page from where you can kickstart the payment gateway integration.

* __Step 12:__ For Hosted Checkout integration, you can update the `checkout_hosted.php` or use a different file according to your need. We have provided a basic sample page from where you can kickstart the payment gateway integration.

* __Step 13:__ For redirecting action from SSLCommerz Payment gateway, we have also provided sample `success.php`, `cancel.php`, `fail.php`files. You can update those files according to your need.


### Contributors

>Prabal Mallick

> Md. Rakibul Islam

> integration@sslcommerz.com
