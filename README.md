# Requirements
- PHP 7.4.x
- Postgres 11.x

# Setup
- Clone project `git clone git@github.com:xcopy/etl.git`
- Change directory to `./etl`
- Run `php requirements.php`
- Copy `.env.dist` to `.env` file
- Setup database connection in `.env` file
- Run `composer install`
- Run `./yii serve`, go to http://localhost:8080