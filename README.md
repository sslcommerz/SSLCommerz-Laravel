## SSLCommerz - Laravel Library

```
For any technical support, please email at integration@sslcommerz.com
```

### Compatibility

Supports Laravel v5.6 to v10.

### License

GPLv2 or later

### Instructions:

- **Step 1:** Download and extract the library files.

- **Step 2:** Copy the `Library` folder and put it in the laravel project's `app/` directory. If needed, then run `composer dump -o`.

- **Step 3:** Copy the `config/sslcommerz.php` file into your project's `config/` folder.

- **Step 4:** Copy and put 3 key-value pairs from `env_example` to your `.env` file.

For development purposes, you can obtain sandbox 'Store ID' and 'Store Password' by registering at [https://developer.sslcommerz.com/registration/](https://developer.sslcommerz.com/registration/)

- **Step 5:** Add exceptions for `VerifyCsrfToken` middleware accordingly (this is for our example code, **use your actual routes**).

```php
protected $except = [
    '/success',
    '/cancel',
    '/fail',
    '/ipn',
    '/pay-via-ajax', // only required to run example codes. Please see bellow.
];
```

> In Laravel 11, there is no middleware folder by default. Therefore, it might not work by simply copy-pasting. You can make changes in `bootstrap/app.php` with the following code:

```php
 ->withMiddleware(function (Middleware $middleware) {
       $middleware->validateCsrfTokens(except: [
           '/pay-via-ajax', '/success', '/cancel', '/fail', '/ipn'
       ]);
   })
```

- **Optional:** We have also provided some example codes which can help you understand the process. **Developer's discretion is needed. Following steps are not mandatory.**

> Copy `SslCommerzPaymentController` into your project's `Controllers` folder.

> Copy defined routes from `routes/web.php` into your project's route file.

> Copy views from `resources/views/*.blade.php`.

### To Show sslcommerz gateway page inside a popup (optional)

- If you use blade templates, we provide a simple solution to show sslcommerz gateway page inside popup. To integrate it, You need to have a `<button>` with following properties in your blade file -

  - id="sslczPayBtn"
  - endpoint=[your ajax route]
  - postdata= [you need to populate a js object with required form fields]

```
<button id="sslczPayBtn"
        token="if you have any token validation"
        postdata=""
        order="If you already have the transaction generated for current order"
        endpoint="/pay-via-ajax"> Pay Now
</button>
```

- Populate postdata obj as required -

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

- Add following script -

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

### FAQ

- Session is destroyed after redirecting to success/cancel/fail URL

> This is a general Laravel issue, **unrelated to SSLCommerz**. You can try setting

```php
'same_site' => env('SESSION_SAME_SITE', 'none')
```

in your `config/session.php` file.

> or try

```php
'same_site' => env('SESSION_SAME_SITE', null)
```

-Redirecting to success/cancel/fail URL is not working

> You can try setting in your `.env` file

```php
 APP_URL=http://localhost:8000
```

> or

```php
APP_URL=http://127.0.0.1:8000
```

- I am getting an error saying "Store Credential Error Or Store is Deactive"

> You have incorrect (or missing) configuration values in .env file. Check step 4.

- I am not getting IPN in localhost / development machine.

> You can't. IPN requires a publicly accessible webserver.

### Contributors

> Md. Rakibul Islam

> Prabal Mallick
