# URI Shortener
URI Shortener utility with public click analytics

## Technologies used
1. PHP 7.2
2. Symfony 4.33
3. MySQL 5.7

## Libraries used
1. Bootstrap 4.3
2. jQuery 3.4

## Cron jobs to be setted up
*/5 * * * * php /var/www/uri/www/bin/console uri:remove >> /var/www/uril/log/cron.log