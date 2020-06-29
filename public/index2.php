<?php

use App\Kernel;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

//require __DIR__.'/../vendor/autoload.php';  

//for local development 

//require __DIR__.'/../config/bootstrap.php';  

//for deployment system 3 
require 'system/vendor/autoload.php';

// The check is to ensure we don't use .env in production 
(new Dotenv())->load(__DIR__.'/system/.env.local');