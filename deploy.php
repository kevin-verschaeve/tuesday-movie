<?php

require 'recipe/symfony3.php';

server('prod', 'vps314528.ovh.net', 2222)
    ->user('kevin')
    ->identityFile()
    ->stage('vps')
    ->env('deploy_path', '~/sites/mardi');

task('deploy:vendors', function() {}); // do not deploy vendors as docker will do it
// Temp override
task('deploy:assetic:dump', function() {});
task('deploy:cache:warmup', function() {});

task('make:install', function() {
    cd('{{deploy_path}}/current');
    run('env="prod" make install');
});

after('deploy', 'make:install');

set('repository', 'git@github.com:kevin-verschaeve/tuesday-movie.git');
set('composer_command', '/usr/local/bin/composer');

set('shared_dirs', []);
set('shared_files', []);
set('writable_dirs', ['var/cache', 'var/logs']);
//set('assets', ['web/css', 'web/images', 'web/js']);
env('env_vars', 'SYMFONY_ENV=prod');
env('env', 'prod');
