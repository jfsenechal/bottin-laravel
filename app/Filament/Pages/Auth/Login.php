<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BasePage;

class Login extends BasePage
{
    public function mount(): void
    {
        parent::mount();

        if (app()->isLocal()) {
            $this->form->fill([
                'email' => env('LOGIN_USER_DEFAULT'),
                'password' => env('LOGIN_PWD_DEFAULT'),
                'remember' => true,
            ]);
        }
    }
}
