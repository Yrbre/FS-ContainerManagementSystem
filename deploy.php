<?php

namespace Deployer;
require 'recipe/laravel.php';
require 'contrib/cachetool.php';
// Project name
set('application', 'ctc');

set('cachetool', '/var/run/php/php8.1-fpm.sock');
// set('cachetool_args', '--web --web-path=./public --web-url=https://bagibagi.devhunts.com');

// Project repository
set('repository', 'git@github.com:itbaracoal/baracoal-cms.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);


// Hosts

host('172.16.10.28')
    ->set('remote_user', 'deployer')
    ->set('branch', 'main')
    ->set('cachetool', '/var/run/php/php8.1-fpm.sock')
    ->set('deploy_path', '/var/www/html');

// Tasks

task('build', function () {
    run('cd {{release_path}} && npm install && npm run prod');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'build');

after('deploy:symlink', 'cachetool:clear:opcache');

after('deploy:symlink', 'artisan:queue:restart');

/**
 * Main deploy task.
 */
desc('Deploys your project');
// task('deploy', [
//     'deploy:prepare',
//     'deploy:vendors',
//     'artisan:storage:link',
//     'artisan:config:cache',
//     'artisan:route:cache',
//     'artisan:view:cache',
//     'artisan:event:cache',
//     'artisan:migrate',
//     'deploy:publish',
//     'cachetool:clear:opcache'
// ]);

