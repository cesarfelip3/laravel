<?php

namespace Deployer;

require 'recipe/laravel.php';

// Configuration
env('');
set('repository', 'git@github.com:cesarfelip3/nexus.git');
set('branch', 'master');

set('git_tty', false);
add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

set('bin/yarn', function () {
    return (string)run('which yarn');
});

set('bin/npm', function () {
    return (string)run('which npm');
});

// Hosts
host('clevermage.com')
    ->user('forge')
    ->set('deploy_path', '/home/forge/sjbookmanager.clevermage.com');

// Tasks
desc('Restart PHP-FPM service');
task('php-fpm:restart', function () {
    run('sudo service php7.1-fpm restart');
});

desc('Generate laroute');
task('artisan:laroute', function () {
    run('cd {{release_path}};{{bin/php}} artisan laroute:generate');
});

desc('Yarn install');
task('yarn:install', function () {
    if (has('previous_release')) {
        if (test('[ -d {{previous_release}}/node_modules ]')) {
            run('cp -R {{previous_release}}/node_modules {{release_path}}');
        }
    }
    run("cd {{release_path}} && {{bin/yarn}}");
});

desc('Laravel mixim for production');
task('npm:run:forge', function () {
    run("cd {{release_path}} && {{bin/npm}} run forge", [
        'timeout' => 1800,
    ]);
});

desc('Artisan config cache');
task('artisan:config:cache', function () {
    run('{{bin/php}} {{release_path}}/artisan config:cache');
});

desc('Artisan env');
task('artisan:env', function () {
    run('{{bin/php}} {{release_path}}/artisan env');
});

before('deploy:writable', 'yarn:install');
before('yarn:install', 'artisan:laroute');
before('deploy:symlink', 'artisan:migrate');
before('artisan:migrate', 'artisan:config:cache');
after('artisan:config:cache', 'artisan:env');
after('yarn:install', 'npm:run:forge');
after('deploy:symlink', 'php-fpm:restart');
after('deploy:failed', 'deploy:unlock');
