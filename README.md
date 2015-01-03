THIS IS AN ALPHA STATE DO NOT USE IT FOR PRODUCTION
===========

CMS Module
===========

CMS Module is the start for a CMS built on Yii 2. It uses the advance yii2 template. It provides user authentication, registration and RBAC support to your Yii2 site.

## Installation

### Note
How you run composer depends on how you have it installed.  I usually install it as /usr/local/bin/composer so I can
just run "composer" from the command line.  You may need to run "php composer.phar" instead.

### Step 1
Install the advanced yii2 template. You can find the instructions here: https://github.com/yiisoft/yii2-app-advanced

In a nutshell, the following commands are required:

```
composer global require "fxp/composer-asset-plugin:1.0.0-beta4" 
composer create-project --prefer-dist --stability=dev yiisoft/yii2-app-advanced advanced
cd advanced
init --env=Production
```

### Step 2
Install the module. The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

From within the "advanced" directory you created above, run these commands:

```
composer update
composer require tez/yii2-cms-module "dev-master"
```

## Usage

Once the extension is installed, modify the backend\config\main.php application configuration to include:



```php
return [
	'modules' => [
	    ...
	        'core' => [
	            'class' => 'core\Module',
	            'attemptsBeforeCaptcha' => 3, // Optional
	        ],
	    ...
	],
	...
	'components' => [
	    ...
	    'user' => [
	        'class' => 'core\components\User',
            'enableAutoLogin' => true,
	    ],
        'authManager' => [
            'class' => 'core\components\DbManager'
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@core/views/layouts' => '@core/views/layouts',
                    '@core/views' => ['@app/views', '@core/views'],                    
                ],
                'baseUrl' => '@web/',
            ],
        ],
	    ...
	],
    'controllerMap' => [
        'site' => [
            'class' => 'core\controllers\SiteController',
        ],
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'access' => ['@'], //глобальный доступ к фаил менеджеру @ - для авторизорованных , ? - для гостей , чтоб открыть всем ['@', '?']
            'disabledCommands' => ['netmount'], //отключение ненужных команд https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#commands
            'roots' => [
                [
                    'class' => 'core\components\FrontendPath',
                    'path' => '../../frontend/web/files/images',
                    'url' => 'http://frontend.yii2/files/images',
                    'name'  => 'Public'
                ],
            ]
        ]        
    ],
];

```

### Note

I have done this via just keeping a modified version of the file in deploy/backend+config+main.php
It can be copied into place by running vendor/tez/yii2-cms-module/appconfig.sh

Use the new crud generator, replace in the backend/config/main-local.php the part with
```php
$config['modules']['gii'] = 'yii\gii\Module';
```
with
```php
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'crud'   => [
                'class'     => 'core\gii\crud\Generator',
                'templates' => ['crud' => '@core/gii/crud']
            ],
            'model'   => [
                'class'     => 'core\gii\model\Generator',
                'templates' => ['model' => '@core/gii/model/default']
            ],
        ]
    ];    
```

### Note

This line doesn't exist if you are working from Production.  It's there in development only.  Are
the added lines required in production and if so where do they go?

Copy .htaccess from vendor/tez/yii2-cms-module to frontend/web/ and to backend/web/
```bash
cp vendor/tez/yii2-cms-module/.htaccess backend/web/
cp vendor/tez/yii2-cms-module/.htaccess frontend/web/
```

In common/config/bootstrap add 
```php
Yii::setAlias('core', dirname(dirname(__DIR__)) . '/vendor/tez/yii2-cms-module');
Yii::setAlias('theme', dirname(dirname(__DIR__)) . '/vendor/tez/yii2-brain-theme');
```

### Note

I have done this by keeping a copy of the modified file in deploy/ as above.

Define the frontend-url in backend/config/params.php and/or backend/config/params-local.php. This is for the file picker preview. Change to match your domain
```php
return [
...
    'frontend-url' => 'http://frontend.yii2/',
...
];
```

### Note

Please define what actually needs doing here.  Do both files need modifying or just the one
and in that case which one?  Are you seriously hard coding URLs into the config?

In your common/config/params.php define the mandrill details and the logo for the notification. Change to your details.
```php
return [
...
    'mandrill'=>[
        'key' => 'xxxx', 
        'from_email' => 'admin@.....', 
        'from_name' => 'No Reply'
    ],
    'logo' => 'http://2ezweb.net/themes/default/images/logo.png', // the logo will be merged into the email notification.
...
];
```

### Note

Really?  Hard coded URLs again?  Needs to be fixed.

In backend\assets\AppAsset.php the depend section should look like this
```php
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'theme\assets\BrainAsset',
        'theme\assets\CustomAsset',          
    ];
```

### Note

I have kept a copy of the modified file as before.

Run migrations:

```bash
$ php yii migrate/up --migrationPath=@core/migrations
```

### Note

Nope, doesn't work.  What else is required here?

## License

Auth module is released under the BSD-3 License. See the bundled `LICENSE.md` for details.

## URLs

* Login: `yourhost/core/default/login`
Username: webmaster@2ezweb.com.au
Password: admin
* Logout: `yourhost/core/default/logout`
* Reset Password: `yourhost/core/default/request-password-reset`
* User management: `yourhost/core/administrator/`

## Tests
In
go to vendor/tez/yii2-cms-module/tests/codeception/backend/
run
```codecept build```

to initialize the tests. Then run
```codecept run functional```
to run the actual tests.

You can run
```codecept run functional --coverage-html```
to get the code coverage. You can find the coverage in vendor/tez/yii2-cms-module/tests/codeception/backend/_output/coverage/
