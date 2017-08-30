<?php

namespace App\Helpers;

use Composer\Script\Event;
use Symfony\Component\Process\Process;

class ComposerProjectSetup
{
    public static function postProjectCrete(Event $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        $event->getIO()->write('run "php artisan project:setup"');
    }
}