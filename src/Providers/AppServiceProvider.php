<?php

namespace JbGlobal\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(env('DB_MAX_STRING_LENGTH',191));

        Validator::extend('cpf', '\App\Validations\CPFValidation@validate');
        Validator::extend('cnpj', '\App\Validations\CNPJValidation@validate');
        Validator::extend('cep', '\App\Validations\CEPValidation@validate');

        Validator::replacer('cpf', function ($message, $attribute, $rule, $parameters) {
            return 'CPF inválido';
        });
        Validator::replacer('cnpj', function ($message, $attribute, $rule, $parameters) {
            return 'CNPJ inválido';
        });
        Validator::replacer('cep', function ($message, $attribute, $rule, $parameters) {
            return 'CEP inválido';
        });
    }
}
