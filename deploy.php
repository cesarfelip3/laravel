<?php

namespace Deployer;

require __DIR__ . '/vendor/autoload.php';
require 'recipe/laravel.php';

$env = readEnv();

// Configuration
set('repository', function () {
    return (string)run('git config --get remote.origin.url');
});
set('git_tty', false);
set('bin/yarn', function () {
    return (string)run('which yarn');
});
set('bin/npm', function () {
    return (string)run('which npm');
});

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts
host('stage')
    ->hostname($env['DEPLOY_STAGE_HOSTNAME'])
    ->set('branch', $env['DEPLOY_STAGE_BRANCH'])
    ->user($env['DEPLOY_STAGE_USER'])
    ->set('deploy_path', $env['DEPLOY_STAGE_FOLDER']);

/*
host('production')
    ->hostname('****')
    ->set('branch', 'production')
    ->user('***')
    ->set('deploy_path', "/var/www/{$projectName}.com");
*/

// Tasks
desc('Generate laroute');
task('artisan:laroute', function () {
    run('cd {{release_path}};{{bin/php}} artisan laroute:generate');
});

desc('Yarn install');
task('yarn:install', function () {
    run("cd {{release_path}} && {{bin/yarn}}", [
        'timeout' => 3800,
    ]);
});

desc('NPM install');
task('npm:install', function () {
    run("cd {{release_path}} && {{bin/npm}} install", [
        'timeout' => 3800,
    ]);
});

desc('Laravel mixin for production');
task('npm:run', function () {
    run("cd {{release_path}} && {{bin/npm}} run production", [
        'timeout' => 3800,
    ]);
});

desc('Restart PHP-FPM service');
task('php-fpm:restart', function () {
    run('sudo service php7.1-fpm restart');
});

task('deploy', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',

    'artisan:storage:link',
    'artisan:view:clear',
    'artisan:cache:clear',
    'artisan:config:cache',
    'artisan:optimize',
    'artisan:laroute',

    'npm:install',
    'npm:run',

    'artisan:migrate',
    'deploy:symlink',
    'php-fpm:restart',
    'deploy:unlock',
    'cleanup',
]);

after('deploy', 'success');
after('deploy:failed', 'deploy:unlock');