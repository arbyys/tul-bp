# Ukázková aplikace - BitcoinSpotlight

## Technologie, základní informace

- PHP 8.3, Laravel 10
- [Laravel Octane](https://laravel.com/docs/11.x/octane) se serverem Swoole
- Docker prostředí s použitím [Laravel Sail](https://laravel.com/docs/11.x/sail)

Aplikace je dostupná (na dobu neurčitou) na adrese https://bitcoin.arbystools.eu/.
 
## Sestavení a spuštění aplikace lokálně
0) Nainstalovat Docker a Docker Compose
1) Přesunout se do adresáře aplikace
2) Zkopírovat soubor `.env.example` jako nový soubor `.env`
    - konfiguraci lze případně upravit dle potřeby (může způsobit neočekávané chování aplikace)
3) Spustit následující příkaz, který nainstaluje composer závislosti a zpřístupní Sail příkazy (pomocí dočasného Docker kontejneru)
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```
(Sail příkazy jsou nyní dostupné pomocí volání souboru `./vendor/bin/sail`)

4) Sestavit kontejner příkazem `./vendor/bin/sail build`
5) Spustit aplikaci příkazem `./vendor/bin/sail up -d`
6) Vygenerovat klíč aplikace příkazem `./vendor/bin/sail artisan key:generate`
7) Aplikace nyní běží na adrese `localhost:8000`