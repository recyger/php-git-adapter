<?php
/** @type Repository $repository */
use recyger\GitAdapter\commands\CloneCommand;
use recyger\GitAdapter\Repository;

$repository = require_once '_constructRepository.php';

if (!$repository->isInit()) {
    $command = new CloneCommand($repository);

    if ($command->remote('git@github.com:recyger/php-git-adapter.git')) {
        echo 'Success' . PHP_EOL;
    } else {
        echo 'Error when cloning: ' . $command->getError();
    }
}
