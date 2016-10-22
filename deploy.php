<?php

require 'recipe/symfony3.php';

server('prod', 'vps314528.ovh.net', 2222)
    ->user('kevin')
    ->identityFile()
    ->stage('vps')
    ->env('deploy_path', '~/sites/mardi');

task('deploy:vendors', function() {
    cd('{{release_path}}');
    run('make composer-install npm-install');
});
task('deploy:assetic:dump', function() {
    cd('{{release_path}}');
    run('make styles');
});
task('deploy:cache:warmup', function() {
    cd('{{release_path}}');
    run('make cc');
});
task('migrations', function() {
    cd('{{release_path}}');
    run('make start migration-migrate');
});
task('app:configure', function() {
    cd('{{release_path}}');
    run('make configure');
});

after('deploy:shared', 'app:configure');
after('deploy', 'migrations');
before('deploy:vendors', 'deploy:copy_dirs');

set('repository', 'git@github.com:kevin-verschaeve/tuesday-movie.git');
set('composer_command', '/usr/local/bin/composer');

set('shared_dirs', []);
set('copy_dirs', ['vendor', 'node_modules', 'web/media']);
set('shared_files', []);
set('writable_dirs', ['var/cache', 'var/logs']);
//set('assets', ['web/css', 'web/images', 'web/js']);
env('env_vars', 'SYMFONY_ENV=prod');
env('env', 'prod');
