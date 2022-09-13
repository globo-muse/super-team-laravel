<?php

namespace App\Services\Email\Sendgrid\TemplateData;

use App\Models\User;

class UserCreatedTemplateData
{
    static public function transform(User $user, string $password = '')
    {
        return [
            "user_name" => $user->name,
            "user_password" => $password,
            "user_email" => $user->email,
            "url_superteam" => getenv('FRONTEND_APP_URL') . 'login',
        ];
    }
}
