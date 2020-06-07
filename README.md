## Setup

`composer install`

`npm install`

`npm run watch` - dla plików css i js


`php artisan migrate:fresh --seed`

Użytkownicy:
1. jan@kowalski.com
2. janina@kowalska.com

Admin:

1. adam.zuczek@gmail.com

hasło: "tajne"

## Testing

`./vendor/bin/phpunit`

## Przelewy

Przelewy ekspresowe są wykonywane synchronicznie. Przelewy standardowe, są kolejkowane przy pomocy tabeli "jobs". Aby wykonać zakolejkowane transakcje, należy uruchomić procesowanie kolejki za pomocą komendy `php artisan queue:work`.

W wypadku wystąpienia błędu, środki zostaną odblokowane eventem OdblokowanieSrodkow. Event będzie również zawierał informacje o błędzie.
