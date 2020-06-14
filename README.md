## Setup

1. Skopiuj zawartość .env.example do .env i uzupełnij dane dostępowe do lokalnej instancji bazy danych.

2. `composer install`

3. `npm install`

4. `npm run dev` - dla plików css i js

5. `php artisan key:generate`

6. `php artisan migrate:fresh --drop-views --seed`

7. `php artisan serve`

8. `php artisan queue:work - do websocketa`

Użytkownicy:
1. jan@kowalski.com
2. janina@kowalska.com

Admin:

1. adam.zuczek@gmail.com

hasło: "tajne"

## Testing

`./vendor/bin/phpunit`

## Przelewy

Przelewy ekspresowe są wykonywane synchronicznie. Przelewy standardowe, są kolejkowane przy pomocy tabeli "jobs". Aby wykonać zakolejkowane transakcje, należy uruchomić procesowanie kolejki za pomocą komendy `php artisan queue:work --queue=transakcje`.

W wypadku wystąpienia błędu, środki zostaną odblokowane eventem OdblokowanieSrodkow. Event będzie również zawierał informacje o błędzie.

## Event sourcing

Rekordy w tabeli `rachunki` oraz `transakcje` są tworzone na podstawie zarejestrowanych eventów w tabeli stored_event. Po usunięciu / zmianie zawartości obu tabel, mogą one zostać odtworzone komendą `php artisan event-sourcing:replay`.
