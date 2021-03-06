## Welcome to Fe_Login Repo
### **Recommended to be used with [LaraFrame](https://github.com/yu0307/LaraFrame)**
### Let's collaborate!
Email me for bugs, feature suggestions,pull requests,etc... or even hang out :) [yu0307@gmail.com](mailto:yu0307@gmail.com)
### This package allows users to 
- Authenticate using social media providers, 
- Traditional user and password logins,
- Single Sign-On,
- Register new users, 
- Send email confirmation and password resets,
- Resetting password with tokenized link,
- Providing 2 versions of the login screens. 1: individual login screen/page 2: Modal window on homepage
- Authenticate using either page redirects or ajax, 
- Manage user with interface.

### Dependencies:
- Composer [Visit vendor](https://getcomposer.org/)
- Laravel 5+
- Socialite [Visit vendor](https://github.com/laravel/socialite)

### Installation:

1. Please make sure composer is installed on your machine. For installation of composer, please visit [This Link](https://getcomposer.org/doc/00-intro.md)
2. Once composer is installed properly, please make sure Larave is up to date. 
3. Navigate to your project root directory
```
composer require FeIron/Fe_Login
```
4. This package is going to publish several files to the following path
- config/Fe_Login/
- public/FeIron/Fe_Login/
5. **Important!** This package is also going to perform several migrations. Please refer to the following changes and make backups of your tables if they are present. 
6. **Since I can't seem to have package auto publish assets**. make sure you run the following command at the end and every updates of this package. 

```
    php artisan vendor:publish --provider="feiron\fe_login\Fe_LoginServiceProvider" --force

```


```
Schema to be Created/Modified to be like
[users]:
id int(10) UN AI PK 
name varchar(200) 
email varchar(200) 
password varchar(200) 
remember_token varchar(100) 
created_at timestamp 
updated_at timestamp 
last_login datetime 
provider_id varchar(255) 
provider_type char(225) 
activated tinyint(1) 
email_verified_at datetime
------------------------------------------
[password_resets]:
id bigint(20) UN AI PK 
email varchar(200) 
token varchar(200) 
created_at timestamp
```
**Note**: During migration, if you encounter error showing "Specified key was too long"
This was due to MySQL version being older than 5.7.7, if you don't wish to upgrade MySQL server, consider the following.

Within your AppServiceProvider 
```
use Illuminate\Support\Facades\Schema;

/**
 * Bootstrap any application services.
 *
 * @return void
 */

public function boot()
{
    Schema::defaultStringLength(191);
}
```
Further reading on this could be found at [This Link](https://laravel.com/docs/master/migrations#creating-indexes)

### Basic Usage:

General Usage:
Within any php/blade files
```
@Fe_LoginForm()
```
**Important**, Make sure to insert the following at template header tags or the last line of body tag to import the necessary js and css. 
```
-------------header.blade.php-------------------
<head>
@stack('Fe_Login_scripts')
</head>
------------------------------------------------
OR
-------------home.blade.php-------------------
<body>
...some other codes ...
@stack('Fe_Login_scripts')
</body>
------------------------------------------------
```

You may also put everything all together like the following
```
@Fe_LoginForm()
@stack('Fe_Login_scripts')
```

### configuration:

**Important**. There is a configuration file being published to /config/Fe_Login/appconfig.php. Proper configuration is required. 
Sample config:
```
return [
        'DefaultLoginProviders'=>[
            'google'=>[
                'client_id' => 'google_client_id',
                'client_secret' => 'client_secret',
                'redirect' => '/login/google/callback'
            ],
            'twitter'=>[
                'client_id' => 'twitter_client_id',
                'client_secret' => 'client_secret',
                'redirect' => '/login/twitter/callback'
            ]
        ],
        'HasRegister'=>true,
        'HasFormLogin'=>true,
        'HasForgotPassword'=>true,
        'HasSocialSignin'=>true,
        'RememberLogin' => true,    
        'HasTermURL'=>null,
        'useSSOAuth'=>[
            'Driver'=> '\feiron\fe_login\lib\thirdpartyDriver\thirdpartydriver',
            'URL'=> 'singleSignOn URL',
            'Label'=>'Label for the button',
            'EscapeCookie'=>['cookie name'],
            'image'=>'relative path from public root to the image used on the button'
        ]
    ];
```
Explainations:
1. DefaultLoginProviders is an array that defines the social media authentication providers. You can define as many providers as needed. a list of supported providers are provided at socialite website. 
- client_id is required and can be obtained from the provider's developer site. 
- client_secret is required and can be obtained from the provider's developer site.
- redirect can be modified but not recommended. This is called once authentication from the provider is finished.
2. useSSOAuth settings:
    This option provides the ability to use Other Single Sign-On providers. You can created third party/custom providers by implementing thirdpartyDriver interface, located at feiron\fe_login\lib\thirdpartyDriver.
    - Driver is the path to the driver class to be used to handle the Single Sign-On Requests.
    - URL is the SSO end point.
    - Label is what shows on the Sign-On button.
    - image is the relative path to the image from the public root. It's used as the sign-on button image. 
**note**
    Refer to the end of this file for General instructions on building custom driver. 
3. Other config settings:

| option name | Values | Description | Default |
| --- | --- | --- | --- |
| HasRegister | boolean | If user registration option is displayed and available to user. | true |
| HasFormLogin | boolean | If traditional username and password authentication option is displayed and available to user. | true |
| HasForgotPassword | boolean | If password retrieval option is displayed and available to user. | true |
| HasSocialSignin | boolean | If social media authentication option is displayed and available to user. | true |
| RememberLogin | boolean | If remember login option is displayed and available to user. | true |
| HasTermURL | URL | If this URL is set, a link to term of use is diaplayed when showing user registration table  | null |

**note**
Registration and password retrieval are not available when **HasFormLogin is disabled**

### Options and parameters:
- Use the following syntax to pass in options,
```
@Fe_LoginForm([
    'option'=>'value'
])
```
- Available options:
**All parameters are optional**

| option name | Values | Description | Default |
| --- | --- | --- | --- |
| ajax | boolean | Enable ajax mode.<br/>This will disable single page mode and use modal to display login windows in one page. | null |
| target | string | Choose to render target section when displaying login window | null |
| logo | URL | pass in full img tag to display logo on the login screen. | app.name |
| FormTitle | string | Title to be shown on the login sreen | app.name |
| Slot | string | Caption/statements displayed under title | null |
| SignInTitle | string | title or statement displayed for sign in section | <strong>Sign in</strong> to your account |
| ResetTitle | string | title or statement displayed for password resetting section | <strong>Reset</strong> your password |
| SignUpTitle | string | title or statement displayed for registration section | <strong>Create</strong> your account |
| linkType | link/button | When Ajax is enabled, display login menu as link or button | false |
| FormAction | URL | URL for submiting sign in request | /login/webform |
| FormAction_forgotPass | URL | URL for processing password retrieval | /emailresetlink |
| SignUpURL | URL | URL for processing user registration | /register |
| FormAction_resetURL | URL | URL for processing password reset | /passreset |

Examples:
1. Display login control as modal and process requests using ajax. Also having link displayed as button
```
@Fe_LoginForm([
    'ajax'=>true,
    'linkType'=>'button'
])
```
2. Change logo displayed on the login screen. and have title displayed as "Welcome to my website" while stating "Something Amazing is coming..." under the title.
```
@Fe_LoginForm([
    'logo'=>'<img src="/imgs/logo.png"/>',
    'FormTitle'=>'Welcome to my website',
    'Slot'=>'Something Amazing is coming...'
])
```
3. Change Registration URL.
```
@Fe_LoginForm([
    'SignUpURL'=>'/signUp'
])

OR

@Fe_LoginForm([
    'SignUpURL'=>route('MySignupURL')
])

```

### User Management Feature
This package provides many useful user management features along with the ability to extend management feature. 
1. User management area can be access with URL "/usermanagement/" or route("Fe_UserManagementUI").
2. This package also provide user Meta-info storage, and these information can be managed from the interface. 
3. Outlet Feature:
Outlet is a feature provided for developers to attach/extend more funtionalities into the management interface. 
How to use Outlet: 
    - "UserManagementOutlet" is an outlet instance defined and stored within the app's service container. This is what you will need for outlet registration. 
    - "UserManageOutlet" is the outlet name made available by the package that you can register outlets with. This outlet is used by the management interface as well as other frameworks that is compatible with this package. 
    - \feiron\fe_login\lib\outlet\feOutlet is the outlet definition. Feel free to create your own outlet by implementing interface (feiron\felaraframe\lib\outlet\feOutletContract).
    - Constructor Parameters: 
        i. view: the view class to be used by this outlet when rendering it's interface.
        ii. myName: the label to be displayed when rendering this outlet section.
        iii. resource: the resources used by this outlet and its interface. 
    - Outlets are automatically attached and rendered from the user management interface according to the definitions. 
    - Within Service Provider's boot method, attach an outlet instance as follow:
```
    app()->UserManagementOutlet->bindOutlet('UserManageOutlet', new \feiron\fe_login\lib\outlet\feOutlet([
        'view'=> 'fe_login::outletViews.userMetaInfo',
        'myName'=> 'Additional Info'
    ]));
```

## LaraFrame Support
This package was tailored to work with [LaraFrame](https://github.com/yu0307/LaraFrame).
- User management is easily done through the shared control panel provided by the framework. 
- User meta field management is also provided by the framkework. You can build your list of meta fields from the framework's control panel. 
- Users were also provided with profile pages. People can view and manage their own profile information, as well as view other's profile page. 
- Outlets are automatically carried into the framework and making user information related management a breeze. 
- Custom outlets are automatically transfered into framework's general control panel. 

### General Instruction on Custom Driver:

Drivers must implement feiron\fe_login\lib\thirdpartyDriver interface.
1. Method "Login" will be called when user clicked on single singe-on button. From here you can assign values, build payloads, encrypt cookies or set session data. 
2. Once the authentication is processed and returned with a valid status. It is routed to /login_SSO/callback. Method "handle" from the driver is subsequently called. From there, you can retrieve session data, cookies, etc. You may also want to set private variables that stores user information to be used when creating user when first signed in. 
3. Getter methods like 'getName()' are used for user creation process. 

## Support us:

If you like this project, Please, please, please consider put a Star⭐️ and tweet about it.

I would love for any forms of supports and they are deeply appreciated👍! Thanks!