<?php
/**
 * Created by Evis Bregu <evis.bregu@gmail.com>.
 * Date: 12/21/17
 * Time: 2:53 PM
 */

require __DIR__.'/vendor/autoload.php';


use App\Command\TestCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Yaml\Yaml;

$application = new Application();

$config = Yaml::parse(file_get_contents(__DIR__.'/app/config/config.yml'));

// ... register commands
try {
    $application->add(new TestCommand($config));
} catch (Exception $e) {
    exit(1);
}

/** @noinspection PhpUnhandledExceptionInspection */
$application->run();
