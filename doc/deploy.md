# Deploy
Deploy работает в полуавтоматическом режиме.
Для выкатки сайта используется пакет deployer/deployer (https://github.com/deployphp/deployer) никаких модификаций его не делалось. читайте базовый faq по этому пакету.

"Инструкция" для deployer-а находится в корне сайта, файл: deploy.php

Посмотреть все доступные команды: 

``` php bin/deployer.php ```

Например, для выкатки на прод используйте комманду 

``` php bin/deployer.php deploy prod ```