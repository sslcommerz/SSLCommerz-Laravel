<?php

 // SSLCOMMERZ Start
	Route::get('/pay', 'PublicSslCommerzPaymentController@index');
 	Route::POST('/success', 'PublicSslCommerzPaymentController@success');
 	Route::POST('/fail', 'PublicSslCommerzPaymentController@fail');
 	Route::POST('/cancel', 'PublicSslCommerzPaymentController@cancel');
 	Route::POST('/ipn', 'PublicSslCommerzPaymentController@ipn');

//SSLCOMMERZ END
