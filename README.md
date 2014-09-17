Auth Module
===========

CMS Module is the start for a CMS built on Yii.It provides user authentication, registration and RBAC support to your Yii2 site.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require tez/yii2-cms-module "dev-master"
```

or add

```
"tez/yii2-cms-module": "dev-master"
```

to the require section of your `composer.json` file.

## Usage

Once the extension is installed, modify your application configuration to include:

```php
return [
	'modules' => [
	    ...
	        'auth' => [
	            'class' => 'core\Module',
	            'layout' => '//homepage', // Layout when not logged in yet
	            'layoutLogged' => '//main', // Layout for logged in users
	            'attemptsBeforeCaptcha' => 3, // Optional
	            'superAdmins' => ['admin'], // SuperAdmin users
	            'tableMap' => [ // Optional, but if defined, all must be declared
	                'User' => 'user',
	            ],
	        ],
	    ...
	],
	...
	'components' => [
	    ...
	    'user' => [
	        'class' => 'auth\components\User',
	    ],
	    ...
	]
];
```

And run migrations:

```bash
$ php yii migrate/up --migrationPath=@core/migrations
```

## License

Auth module is released under the BSD-3 License. See the bundled `LICENSE.md` for details.

#INSTALLATION

./yii migrate/up --migrationPath=@core/migrations

## URLs

* Login: `yourhost/core/default/login`
* Logout: `yourhost/core/default/logout`
* Sign-up: `yourhost/core/default/signup`
* Reset Password: `yourhost/core/default/request-password-reset`
* User management: `yourhost/core/user/index`