<?php

use App\Http\Controllers\HomeController;
use Ezegyfa\LaravelHelperMethods\Language\LanguageMethods;
use Ezegyfa\LaravelHelperMethods\ServerCommands\ServerCommandMethods;
use Illuminate\Support\Facades\Route;

Route::post('/contact-and-faq', [HomeController::class, 'storeContactMessage']);

Route::middleware('setLanguage')->group(function () {
    LanguageMethods::createGetRouteWithLanguage('/', [HomeController::class, 'welcome']);
    LanguageMethods::createGetRouteWithLanguage('/about-us', [HomeController::class, 'aboutUs']);
    LanguageMethods::createGetRouteWithLanguage('/contact-and-faq', [HomeController::class, 'contactAndFAQ']);
});
ServerCommandMethods::registerServerCommandRoutes();
