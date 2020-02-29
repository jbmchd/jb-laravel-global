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

        Validator::extend('cpf', 'JbGlobal\Validators\CPFValidation@validate');
        Validator::extend('cnpj', 'JbGlobal\Validators\CNPJValidation@validate');
        Validator::extend('cep', 'JbGlobal\Validators\CEPValidation@validate');
        Validator::extendImplicit('primary_key', 'JbGlobal\Validators\PrimaryKeyValidation@validate');
        Validator::extend('foreign_key', 'JbGlobal\Validators\ForeignKeyValidation@validate');
    }
}
