<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PostProjectCreate extends Command
{

    protected $signature = 'project:create';

    protected $description = 'Setup project info';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->updateEnv(['APP_NAME' => $this->ask('APP_NAME?')]);

        $this->updateEnv(['DB_DATABASE' => $this->ask('DB_DATABASE?')]);
        $this->updateEnv(['DB_USERNAME' => $this->ask('DB_USERNAME?')]);
        $this->updateEnv(['DB_PASSWORD' => $this->secret('DB_PASSWORD?')]);

        $this->updateEnv(['MAIL_HOST' => $this->choice('MAIL_HOST?', [env('MAIL_HOST')], env('MAIL_HOST'))]);

        $this->updateEnv(['BUGSNAG_API_KEY' => $this->ask('BUGSNAG_API_KEY?')]);
    }

    private function updateEnv($data = array())
    {
        if (!count($data)) {
            return;
        }

        $pattern = '/([^\=]*)\=[^\n]*/';

        $envFile = base_path() . '/.env';
        $lines = file($envFile);
        $newLines = [];
        foreach ($lines as $line) {
            preg_match($pattern, $line, $matches);

            if (!count($matches)) {
                $newLines[] = $line;
                continue;
            }

            if (!key_exists(trim($matches[1]), $data)) {
                $newLines[] = $line;
                continue;
            }

            $line = trim($matches[1]) . "={$data[trim($matches[1])]}\n";
            $newLines[] = $line;
        }

        $newContent = implode('', $newLines);
        file_put_contents($envFile, $newContent);
    }
}
