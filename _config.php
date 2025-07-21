<?php

use Psr\Log\LoggerInterface;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\NonBlockingSessions\FileSessionHandler;

// PHPUnit 9 outputs headers early. This is unavoidable with PHPUnit 9.
// We can't use PHPUnit 10+ because of a dependency conflict with `sebastian/diff` which is a dependency of `silverstripe/framework`.
// After headers have been sent, we can't call `session_set_save_handler()` anymore without PHP complaining about it, so we
// need to avoid calling that method after headers have been sent.
if (headers_sent($filename, $line)) {
    // since we're handling this scenario here we should log it just in case something weird happens during non-test execution
    Injector::inst()->get(LoggerInterface::class)->warning(sprintf(
        'Session save handler cannot be changed after headers have already been sent in %s on line %s',
        $filename,
        $line
    ));
    // return here to prevent session_set_save_handler() being called below
    return;
}
session_set_save_handler(Injector::inst()->get(FileSessionHandler::class));
