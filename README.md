## ntgnn/swagger

Yet another tool for documenting laravel-based APIs with OpenApi/Swagger. This package is highly inspired by great [DarkaOnLine/L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger) and also wraps [zircote/swagger-php](https://github.com/zircote/swagger-php) and [swagger-api/swagger-ui](https://github.com/swagger-api/swagger-ui), but since we had some particular requirements plus some issues when serving the static assets for swagger-ui, we decided do take a different approach.
This package only supports OpenAPI annotations, Swagger 3.0, Laravel >=5.6.

To install this package in your laravel app, just use composer:

```bash
$ composer require ntgnn/swagger
```
After the package is loaded, it will provide you with 3 console commands: init, generate-docs and copy-assets

***Init***: this command will setup the settings file (config/swagger.php) and create a folder for swagger-related files inside your app/Http. You should run this command only once per install. 

```bash
$ php artisan swagger:init
```

***Copy-Assets***: this command with copy the swagger-ui related files to the public folder. You should run this command only once per install. 

```bash
$ php artisan swagger:copy-assets
```

***Generate-Docs***: this command will scan your php files and generate the json specification file to be used by the swagger ui. The json file will be located inside the public folder. You should run this command every time you want to update the json file, for instance after annotating a controller. 

```bash
$ php artisan swagger:generate-docs
```

### Quick setup
1. Go to an existing laravel app or create one
2. Install the ntgnn/swagger package
3. Run the init command
4. Run the copy-assets command
5. Run the generate-docs command
6. Serve the app and browse the route /docs 



