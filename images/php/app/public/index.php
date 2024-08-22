<?php

	$app = require __DIR__.'/../bootstrap/app.php';

	$app->run();

	$app->middleware([
		App\Http\Middleware\LogMiddleware::class
	]);
