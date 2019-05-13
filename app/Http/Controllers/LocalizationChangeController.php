<?php

namespace App\Http\Controllers;

use Mcamara\LaravelLocalization\LaravelLocalization;

class LocalizationChangeController extends Controller
{
    public function __invoke($name)
    {
        LaravelLocalization::setLocale($name);
    }
}
