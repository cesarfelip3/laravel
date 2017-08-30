<?php

namespace App\Helpers;

use Composer\Script\Event;
use Symfony\Component\Process\Process;

class ComposerProjectSetup
{
    public static function postProjectCrete(Event $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');

        $msg = <<<msg
        \n\n
************************************\n
SUCCESS!
cd to your project and run:

     "php artisan project:setup"

************************************\n
\n
msg;
        $event->getIO()->write($msg);
    }
}