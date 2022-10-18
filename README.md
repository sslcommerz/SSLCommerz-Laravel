## SSLCommerz - Laravel Library

```
For any technical support, please email at integration@sslcommerz.com
```



### Requirement
Laravel v5.6 or later


### License
GPLv2 or later


### Instructions:

* __Step 1:__ Download and extract the library files.

* __Step 2:__ Copy the `Library` folder and put it in the laravel project's `app/` directory. If needed, then run `composer dump -o`.

* __Step 3:__ Copy the `config/sslcommerz.php` file into your project's `config/` folder.

```
If you later encounter issues with session destroying after redirect, you can set 'same_site' => 'none' in your `config/session.php` file.
```

* __Step 4:__ Copy and put 3 key-value pairs from `env_example` to your `.env` file. 

For development purposes, you can obtain sandbox 'Store ID' and 'Store Password' by registering at [https://developer.sslcommerz.com/registration/](https://developer.sslcommerz.com/registration/)


* __Step 5:__ Add exceptions for `VerifyCsrfToken` middleware accordingly.

```php
protected $except = [
    '/success',
    '/cancel',
    '/fail',
    '/ipn'
    '/pay-via-ajax', // only required to run example codes. Please see bellow.
];
```

We have also provided some example codes which can help you understand the process. Developer's discretion is needed. Following steps are not mandatory.

* Copy `SslCommerzPaymentController` into your project's `Controllers` folder.

* Copy defined routes from `routes/web.php` into your project's route file.

* Copy views from `resources/views/*.blade.php`.


### Show sslcommerz gateway inside a popup

* We provide a simple solution to show sslcommerz gateway page inside popup. To integrate it, You need to have a `<button>` with following properties -

    * id="sslczPayBtn" 
    * endpoint=[your ajax route]
    * postdata= [you need to populate a js object with required form fields]

```
<button id="sslczPayBtn"
        token="if you have any token validation"
        postdata=""
        order="If you already have the transaction generated for current order"
        endpoint="/pay-via-ajax"> Pay Now
</button>
```
* Populate postdata obj as required -

```
<script>
    var obj = {};
    obj.cus_name = $('#customer_name').val();
    obj.cus_phone = $('#mobile').val();
    obj.cus_email = $('#email').val();
    obj.cus_addr1 = $('#address').val();
    obj.amount = $('#total_amount').val();
    
    $('#sslczPayBtn').prop('postdata', obj);
</script>
```

* Add following script -

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


### Contributors
> Md. Rakibul Islam

> Prabal Mallick

