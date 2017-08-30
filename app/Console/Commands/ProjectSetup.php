<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProjectSetup extends Command
{

    protected $signature = 'project:setup';

    protected $description = 'Setup project info';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $dir = basename(base_path());
        updateEnv(['APP_NAME' => $this->ask('APP_NAME?', title_case($dir))]);

        updateEnv(['DB_DATABASE' => $this->ask('DB_DATABASE?', $dir)]);
        updateEnv(['DB_USERNAME' => $this->ask('DB_USERNAME?', "root")]);
        updateEnv(['DB_PASSWORD' => trim($this->ask('DB_PASSWORD?', " "))]);

        updateEnv(['DEPLOY_STAGE_HOST' => $this->ask("DEPLOY_STAGE_HOST?", 'clevermage.com')]);
        updateEnv(['DEPLOY_STAGE_BRANCH' => $this->ask("DEPLOY_STAGE_BRANCH?", 'master')]);
        updateEnv(['DEPLOY_STAGE_USER' => $this->ask("DEPLOY_STAGE_USER?", 'forge')]);

        $default = kebab_case($dir);
        updateEnv(['DEPLOY_STAGE_FOLDER' => $this->ask("DEPLOY_STAGE_FOLDER?", "/home/forge/{$default}.clevermage.com")]);

        $env = readEnv();

        if ($this->confirm('Would you like to create the database?', true)) {
            $password = "";
            if ($env['DB_PASSWORD']) {
                $password = "-p{$env['DB_PASSWORD']}";
            }
            $cmd = <<<cmd
            mysql -u {$env['DB_USERNAME']} $password -e "drop database if exists {$env['DB_DATABASE']}; create database {$env['DB_DATABASE']};"
cmd;
            shell_exec($cmd);
        }

        if ($this->confirm('Would you like to run migration (and seed)?', true)) {
            \Artisan::call('cache:clear');
            \Artisan::call('config:cache');
            \Artisan::call('migrate', ['--seed' => '']);
        }
    }


}
