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
set('shared_files', ['config/local.yml']);
set('shared_dirs', ['logs', 'web/image', 'web/storage']);

// Writable dirs by web server 
set('writable_dirs', ['logs', 'cache', 'web/storage', 'web/image']);
set('allow_anonymous_stats', false);

// Hosts

host('little-house.com.ua')
    ->set('deploy_path', '/home/admin/web/dev.little-house.com.ua/public_html')
    ->stage('prod')
    ->hostname('192.168.102.79')
    ->user('admin')
    ->port(22)
    // ->configFile('~/.ssh/config')
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no')
    ->set('branch', 'master');

/*host('dev')
    ->set('deploy_path', '~/dev.little-house.com.ua')
    ->hostname('dev.little-house.com.ua')
    ->user('name')
    ->port(22)
  //  ->configFile('~/.ssh/config')
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no');*/

// Tasks

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

task('notifyDeploySuccess', function () {
    mail("mrtimosh@gmail.com", "Deploy success", "Congrats, deploy successfuly done");
});

task('notifyDeployFailed', function () {
    mail("mrtimosh@gmail.com", "Deploy failed", "Sorry, deploy failed");
});

task('clear:cache', function () {
    run('ls');
});

after('deploy', 'clear:cache');
// [Optional] If deploy fails automatically unlock.

after('deploy:failed', 'deploy:unlock');
after('success', 'notifyDeploySuccess');
after('deploy:failed', 'notifyDeployFailed');
