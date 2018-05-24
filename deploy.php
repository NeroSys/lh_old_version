<?php

namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'Little-House');

// Project repository
set('repository', 'git@bitbucket.org:little-house/little-house.com.ua_2.2.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys 
set('shared_files', ['config/local.yml', 'web/.htaccess']);
set('shared_dirs', ['logs', 'web/image', 'web/storage']);

// Writable dirs by web server 
set('writable_dirs', ['logs', 'cache', 'web/storage', 'web/image']);
set('allow_anonymous_stats', false);

// Hosts

host('dev.little-house.com.ua')
    ->set('deploy_path', '/home/admin/web/dev.little-house.com.ua/public_html')
    ->stage('dev')
    ->hostname('192.168.102.79')
    ->user('admin')
    ->port(22)
    // ->configFile('~/.ssh/config')
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no')
    ->set('branch', 'dev');

host('lhgroup.com.ua')
	->set('deploy_path', '/home/admin/web/lhgroup.com.ua/public_html')
	->stage('lhgroup')
	->hostname('192.168.102.147')
	->user('admin')
	->port(22)
	// ->configFile('~/.ssh/config')
	->identityFile('~/.ssh/id_rsa')
	->forwardAgent(true)
	->multiplexing(true)
	->addSshOption('UserKnownHostsFile', '/dev/null')
	->addSshOption('StrictHostKeyChecking', 'no')
	->set('branch', 'dev');

host('little-house.com.ua')
    ->set('deploy_path', '/home/admin/web/little-house.com.ua/public_html')
    ->stage('prod')
    ->hostname('192.168.102.120')
    ->user('admin')
    ->port(22)
    // ->configFile('~/.ssh/config')
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no')
    ->set('branch', 'master');

desc('Deploy Little-house');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

task('deploy:notifyDeploySuccess', function () {
    mail("y.tkachenko@mstsoft.org", "Deploy success", "Congrats, deploy successfuly done");
});

task('deploy:notifyDeployFailed', function () {
    mail("y.tkachenko@mstsoft.org", "Deploy failed", "Sorry, deploy failed");
});

task('deploy:clear-cache', function () {
    run('ls -la ');
});

task('deploy:db-migrations', function () {
    $migrationsResult = run('cd ' . get('release_path') . ' && command php ./bin/console migration:update -v');
    if (strpos($migrationsResult, 'Error migrating tables') !== false) {
        throw new \Exception("DB Migration failed: ".$migrationsResult);
    }
});


after('deploy:symlink', 'deploy:db-migrations');
after('deploy', 'deploy:clear-cache');
// [Optional] If deploy fails automatically unlock.

after('deploy:failed', 'deploy:unlock');
after('success', 'deploy:notifyDeploySuccess');
after('deploy:failed', 'deploy:notifyDeployFailed');
