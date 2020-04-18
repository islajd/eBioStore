# eBioStore
E-commerce web application to connect users with natural products.

## Installation

* Clone project using in your machine using cmd or terminal

```bash
git clone https://github.com/islajd/eBioStore.git
```

* Run composer install inside project directory
```bash
composer install
```

* Install node modules
```bash
npm install
```


* Copy .env.example file to .env on the root folder. You can type copy .env.example .env if using command prompt Windows or cp .env.example .env if using terminal, Ubuntu
Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.
  * By default, the username is root and you can leave the password field empty. (This is for Xampp)
  * By default, the username is root and password is also root. (This is for Lamp)
  
* Generate app key using the following command, copy key and paste to .env file (field APP_KEY)
```$xslt
php artisan key:generate
```

* Create database

```$xslt
php artisan migrate
```

* Now the application is ready to start, start it by running artisan serve in root directory
```$xslt
php artisan serve
```

## Usage

http://localhost:8000

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](LICENSE)
