## Телефонная книга

Веб-приложение + API для управления контактами телефонной книги.

Включает в себя:

- список контактов с сортировкой, поиском и пагинацией;
- просмотр, добавление, редактирование, удаление контактов;
- API с документацией (Swagger). Авторизация - Bearer token в заголовках запросов;
- коллекцию и окружение для Postman (см. ссылки после входа в кабинет или файлы в public/postman).

### Запуск

- Скопировать файл окружения (.env.example => .env)
- Выполнить `composer install`
- Выполнить `php artisan key:generate --ansi`
- Настроить в файле **.env**:
    - почтовые параметры (MAIL_\*);
    - параметры доступа к БД (если sqlite):
        - DB_CONNECTION=sqlite, остальные DB_* закомментировать;
        - может потребоваться php-sqlite3, если не установлен (для установки выполнить `sudo apt-get install php-sqlite3`);
        - после настроек БД, создать файл БД (выполнить `touch database/database.sqlite`);
    - параметры доступа к БД (если MySQL):
        - настроить все необходимые константы DB_\*
- Запустить миграции (`php artisan migrate`)
- Запустить проект (`php artisan serve`)

### Что использовано

- Linux Ubuntu 18.04
- Laravel Framework 8.83.13 (+ пакеты ui/sanctum/l5-swagger/laravel-datatables)
- Composer 2.0.14
- PHP 7.4.29
- Bootstrap 5.1, jQuery 3.6.0, Datatables, SweetAlert

---
Денис Зиновьев bezarama@yandex.ru 2022
