<?php

    return [
        'DefaultLoginProviders'=>[
            'google'=>[
                'client_id'=>'',
                'client_secret'=>'',
                'redirect'=>'http://devs.lvh.me/login/google/callback'
            ],
            'twitter'=>[],
            'facebook'=>[]
        ],
        'HasRegister'=>true,
        'HasFormLogin'=>true,
        'HasForgotPassword'=>true,
        'HasSocialSignin'=>true,
        'HasTermURL'=>null
    ];

?>