<?php

    return [
        'DefaultLoginProviders'=>[
            'google'=>[
                'client_id' => '',
                'client_secret' => '',
                'redirect' => '/login/google/callback'
            ],
            'twitter'=>[
                'redirect' => '/login/twitter/callback'
            ],
            'facebook'=>[
                'redirect' => '/login/facebook/callback'
            ]
        ],
        'HasRegister'=>true,
        'HasFormLogin'=>true,
        'HasForgotPassword'=>true,
        'HasSocialSignin'=>true,
        'RememberLogin' => true,
        'HasTermURL'=>null
    ];

?>