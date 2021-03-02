# Upload-Laravel  

Загрузить **большие файлы** с пакетом расширения Laravel теперь очень просто. 

# Особенности
- [x] процентный индикатор выполнения
- ограничения типа файла [x]
- ограничение размера файла [x]
- [x] многоязычный
- конфигурация группировки [x]
- [x] пользовательское промежуточное по
- [x] пользовательская маршрутизация 

0 Переключитесь в корневой каталог вашего проекта laravel в терминале и выполните `composer require sequelone/upload-laravel ~2.0`  

1 (Для Laravel 5.5+ пропустите) в `config/app.php` в `providers` добавьте строку в массив`Upload\UploadServiceProvider::class,`  
  
2 Выполните `php artisan upload:publish` для публикации некоторых файлов и каталогов.  
  
3 Доступ в браузере `https://site.com/upload`. Вы можете перейти на страницу примера.

*Совет: чтобы изменить соответствующие параметры конфигурации, пожалуйста, отредактируйте файл `config/upload.php`*  

**Основное использование**  
  
Загрузка файла: обратитесь к разделу комментариев к образцам файлов и введите соответствующие файлы и код на странице, где вам нужно загрузить большие файлы.Пользовательское промежуточное программное обеспечение можно использовать для дополнительной фильтрации загрузок файлов и для дальнейшей обработки загруженных файлов с помощью событий завершения загрузки. 

Конфигурация группировки: 

Автоматически создайте соответствующий каталог `php artisan upload:groups`  

Пользовательское промежуточное по: обратитесь к разделу промежуточного по документации Laravel, чтобы создать свое промежуточное по и в " Ядре.зарегистрируйтесь в php`, заполните имя промежуточного программного обеспечения, которое вы зарегистрировали в соответствующем разделе конфигурационного файла, например ' ['middleware1', 'middleware2']"

Загрузить завершения события: делится на до загрузки и после загрузки событий см. В фреймворк Laravel документ системных событий каталоге, зарегистрировать события и слушатели в'EventServiceProvider`, выполнения'php ремесленника событие:создание Альто создавать события и слушатели, заполнить соответствующую часть конфигурационного файла с полным именем класса в случае, если вы зарегистрировались, например, из приложения\события\OrderShipped'.

** Добавлена функция второго прохода (требуется поддержка Redis и браузера）**

Установите Redis и запустите сервер.Установите пакет predis 'composer require predis/predis'.Убедитесь, что на странице загрузки представлен spark-md5.минута.файл js.

* Совет: в Redis поддерживается второй список пропусков, соответствующий фактическому файлу ресурсов, изменения, вызванные добавлениями и удалениями фактического файла ресурсов,должны быть синхронизированы со вторым списком пропусков,в противном случае он будет производить грязные данные, пакет расширения содержит новую часть, при удалении файла ресурсов пользователю необходимо вручную вызвать соответствующий метод для удаления файла ресурсов.*
``в PHP
\Upload\Util:: deleteResource ($savedPath); / / удалить соответствующий файл ресурса
\Upload\Util:: deleteRedisSavedPath ($savedPath); / / удалить соответствующую вторую биографию redis
```

** Распределенное развертывание (требуется междоменная поддержка Redis и домена）**

Распределенное развертывание разделив сервер приложений и сервер хранения, можно уменьшить нагрузку на сервер приложений, увеличить количество одновременных подключений к приложению, уменьшить сцепление, снизить риск единой точки отказа, повысить эффективность доступа, после включения распределенного развертывания сервер приложений не будет обрабатывать никаких запросов на загрузку и доступ.

Установите Redis и запустите сервер.Установите пакет predis 'composer require predis/predis'.Убедитесь, что форма страницы загрузки содержит ' {{storage_host_field ()}}`.

Конфигурация сервера приложений：
В`config/upload.php настройте параметр'distributed_deployment 'в ' enable' на 'true', 'role' на 'web', 'storage_host' на доменное имя сервера хранения`http://storage.your-domain.com".
В файле`. env` измените элементы конфигурации 'APP_NAME' и 'APP_KEY' на соответствующие конкретные значения, соответствующие конфигурации сервера хранения. SESSION_DOMAIN=.your-domain.com измените конфигурацию SESSION_DRIVER=redis', чтобы поделиться сеансом.

Конфигурация сервера хранения：
В config/upload.php`настройка'distributed_deployment товаров в'enable с'установить правду", "роль с'набор для'storage`,`middleware_cors с'имя зарегистрировано в междоменной промежуточного UploadCORS класс в <адрес>,`allow_origin установлен как доменное имя сервера приложений`http://www.your-domain.com'.
В файле`. env` измените элементы конфигурации 'APP_NAME' и 'APP_KEY' на соответствующие конкретные значения, соответствующие конфигурации сервера приложений. SESSION_DOMAIN=.your-domain.com измените конфигурацию SESSION_DRIVER=redis', чтобы поделиться сеансом.

** Простая в использовании команда ремесленника**

'php artisan upload: groups` перечисляет все группы и автоматически создает соответствующий каталог
'php artisan upload: build` перестраивает второй список пропусков файлов ресурсов в Redis
'php artisan upload: clean 2` очищает недопустимые временные файлы 2 дня назад
` php artisan upload:publish ' vendor:publish упрощенная команда, которая переопределяет публикацию некоторых каталогов и файлов

# Предложения по оптимизации
* (Рекомендуется) установите режим автоматической очистки недопустимых временных файлов каждый день.
Из - за неожиданного прекращения процесса загрузки, такого как принудительное закрытие страницы или браузера во время передачи, приведет к тому, что сгенерированная часть файла станет недействительными файлами, занимающими много места для хранения, мы можем использовать функцию планирования задач Laravel для периодической их очистки.
Запустите команду 'crontab-e' в Linux, чтобы убедиться, что эта строка кода включена в файл：
``в PHP
* * * * * php /абсолютный путь к корневому каталогу проекта/artisan schedule: run 1> > /dev / null 2>&1
```
В ' app/Console / Kernel.добавьте следующий код к методу 'schedule' в php`：
``в PHP
$schedule->command('upload:clean 2')->daily();
```
* (Рекомендуется) повысить эффективность чтения и записи заголовочных файлов.
Изменив файловую систему заголовочного файла с локального жесткого диска на Redis, можно повысить эффективность чтения и записи заголовочных файлов.
В конфигурации/загрузки.php 'изменяет соответствующее значение элемента 'header_storage_disk' на 'redis'.
В ' config/filesystems.добавить'redis'configuration к'item'disks РНР`：
``в PHP
"диски" => [
...
'в Redis' => [
'драйвер' => 'Redis с',
'disable_asserts'=>верно,
],
...
]
```
* Установите автоматическую перестройку второго списка пропусков в Redis каждый день.
Неправильная обработка и некоторые крайние случаи могут привести к появлению грязных данных во втором списке передачи, что повлияет на точность второй передаточной функции, реконструкция второго списка передачи может устранить грязные данные, восстановить синхронизацию с фактическими файлами ресурсов.
Запустите команду 'crontab-e' в Linux, чтобы убедиться, что эта строка кода включена в файл：
``в PHP
* * * * * php /абсолютный путь к корневому каталогу проекта/artisan schedule: run 1> > /dev / null 2>&1
```
В ' app/Console / Kernel.добавьте следующий код к методу 'schedule' в php`：
``в PHP
$schedule->command('upload:build')->daily();
```
* Улучшите скорость чтения и записи фрагментированных временных файлов (эффективно только для PHP).
Использование файловой системы Linux tmpfs,для достижения загруженного блока временных файлов в память с целью быстрого чтения и записи, путем изменения пространства во времени, повышения эффективности чтения и записи, позволит**** * * часть дополнительной памяти (около 1 размера блока).
Будет php.значение временного каталога загрузки ' upload_tmp_dir'item в ini установлено в`"/dev/shm"для перезапуска службы fpm или apache.

* Улучшите скорость чтения и записи временных файлов блоков (эффективно для системного временного каталога).
Использование файловой системы Linux tmpfs,для достижения загруженного блока временных файлов в память с целью быстрого чтения и записи, путем изменения пространства во времени, повышения эффективности чтения и записи, позволит**** * * часть дополнительной памяти (около 1 размера блока).
Выполните следующую команду：
  
`mkdir /dev/shm/tmp`  
`chmod 1777 /dev/shm/tmp`  
`mount --bind /dev/shm/tmp /tmp`  

# Совместимость
<table>
  <th></th>
  <th>IE</th>
  <th>Edge</th>
  <th>Firefox</th>
  <th>Chrome</th>
  <th>Safari</th>
  <tr>
  <td>Версия</td>
  <td>10+</td>
  <td>12+</td>
  <td>3.6+</td>
  <td>6+</td>
  <td>5.1+</td>
  </tr>
  <tr>
  <td>Версия</td>
  <td>10+</td>
  <td>12+</td>
  <td>3.6+</td>
  <td>6+</td>
  <td>6+</td>
  </tr>
</table>

# Безопасность
Upload использует форму whitelist+blacklist для фильтрации расширения файла перед загрузкой, а затем проверяет тип Mime-типа файла после загрузки.Белый список непосредственно ограничивает расширение файла сохранения,черный список по умолчанию shield common executable file extension,чтобы предотвратить загрузку вредоносных файлов,столбец белого списка безопасности не должен оставаться пустым.

Хотя сделать много работы по обеспечению безопасности, но вредоносную загрузку файлов предотвратить невозможно, рекомендуется правильно установить разрешения каталога загрузки,чтобы убедиться, что соответствующая программа не выполняет разрешения на файл ресурса.

# Список изменений
**2021-01-04 v2.0.8**
Исправлена ошибка, из-за которой при выполнении route:cache могла появиться ошибка
Добавлено предупреждение об ошибке типа mime
Оптимизация слияния js-файлов

Changelog [CHANGELOG.md](https://github.com/sequelone/Upload-Laravel/blob/master/CHANGELOG.md)