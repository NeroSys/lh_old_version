<?php
$loader = require_once dirname(__DIR__, 1) . '/vendor/autoload.php';

require_once(dirname(__DIR__, 1) . '/config/config.php');

use \Symfony\Component\Console\Application;

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader([$loader, 'loadClass']);

App\Helper\ActiveRecord::initializeActiveRecord(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);



$application = new Application();


/**
 * ERP Intergration commands
 */
$ampqConfig = new \LHGroup\From1cToWeb\ConnectionConfig(
    RABBIT_MQ_HOST,
    RABBIT_MQ_PORT,
    RABBIT_MQ_USER,
    RABBIT_MQ_PASSWORD,
    RABBIT_MQ_VHOST
);

$application->add(
    new \LHGroup\From1cToWeb\Command\QueueConsumeCommand(
        null,
        $ampqConfig
    )
);

$application->add(
    new \App\ErpIntegration\Commands\ConsumeProductsCommand(
        null,
        $ampqConfig
    )
);

/**
 * end of ERP Integration commands
 */

/**
 * MIGRATION COMMANDS
 */

putenv("MIGRATE_CONNECTION=".\ActiveRecord\Config::instance()->get_default_connection_string());
$application->add((new \ByJG\DbMigration\Console\InstallCommand())->setName("migration:install-migration-package"));
$application->add((new \ByJG\DbMigration\Console\UpCommand())->setName("migration:up"));
$application->add((new \ByJG\DbMigration\Console\DownCommand())->setName("migration:down"));
$application->add((new \ByJG\DbMigration\Console\DatabaseVersionCommand())->setName("migration:db-version"));
$application->add((new \ByJG\DbMigration\Console\UpdateCommand())->setName("migration:update"));

/**
 * END OF MIGRATION COMMANDS
 */



$application->run();