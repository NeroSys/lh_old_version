##Содержание:
- [Особенности проекта](#Features)
- [Технические требования](#Requirements)
- [Установка](#Install)
- [Структура сайта](#Structure)
- [Deploy](#Deploy)
- [Обмен данными с 1С](#Integration)

##<a name="Features"></a> Особенности
- CMS OpenCart установлена в проекте в качестве пакета
- CMS пропатчена. См. папку  ``` /patches ```
- Базовая функциональность CMS переопределяется в папках  ``` /rewrites ``` и ``` /src/Overrides  ```

    В директории ``` /rewrites ``` находятся все файлы перезаписывающие core функционал opencart.
Перезаписан он не в типичной манере modifications. а в несколько другой. так это сделано для возможности обновления / безболезненной перезаписи и понятности какие именно файлы были перезаписаны.
Это можно было сделать через модификаторы - но система модификаторов неудобная / использовать сторонние модули через модификаторы не хотим. 
    
    Директория  ``` /bin ``` дает возможность перезаписать контроллеры и модели коровские или заrewrite-тченные. Это сделано преимущественно для возможности Отнаследоваться от core-модели, а не полностью реврайтить все. 
 
- Добавлены миграции  ``` /migrations ```
- Добавлена symfony-console 
- Добавлен deployer

##<a name="Requirements"></a> Технические требования

- php7.1
- apache2
- memcached
- curl
- пример [Dockerfile](/doc/docker/Dockerfile)


##<a name="Install"></a> Установка

- git clone git@bitbucket.org:little-house/little-house.com.ua_2.2.git
- ``` composer install ```
- настроить ``` /config/local.yml ```
- импортировать дамп базы
- настроить .htaccess

    - Для локальной копии, разместить в папку ``` /web ``` одноименный файл 
    - Для сервера с системой деплоя - разместить в ``` ../../shared ```


        Options -Indexes
        RewriteEngine On
        RewriteBase /
        
        RewriteRule ^system/download/(.*) index.php?route=error/not_found [L]
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_URI} !.*\.(ico|gif|jpg|jpeg|png|js|css|svg)
        RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]>


### Возможные ошибки установки:
- Не установились патчи. Проверьте ``` composer patch ```
- Не корректно настроен apache. Проверьте доступность ``` /robots.txt ```, поправьте .htaccess
- Нет соединения с БД. Включите отображение ошибок. Настройте параметры подключения
- Не установлен Memcached

##<a name="Deploy"></a> Деплой

Deploy работает в полуавтоматическом режиме.
Для выкатки сайта используется пакет deployer/deployer (https://github.com/deployphp/deployer) никаких модификаций его не делалось. читайте базовый faq по этому пакету.

"Инструкция" для deployer-а находится в корне сайта, файл: deploy.php

Посмотреть все доступные команды: 

``` php bin/deployer.php ```

Например, для выкатки на прод используйте комманду 

``` php bin/deployer.php deploy prod ```

##<a name="Integration"></a> Интеграция

- [Документация](https://bitbucket.org/little-house/from1ctoweb/src/master/README.MD)
