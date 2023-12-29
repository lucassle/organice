<?php

namespace App\Providers;

use App\Models\SettingModel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
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
     * @return void
     */
    public function boot()
    {
        $mail   = json_decode(SettingModel::where('key_value', 'setting-email-account')->first()->value, true);
        if (empty($mail)) {
            return false;
        } else {
            Config::set('mail.username', $mail['username']);
            Config::set('mail.password', $mail['password']);
        }
    }
}
