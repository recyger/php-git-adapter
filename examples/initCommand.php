<?php
/** @type Repository $repository */
use recyger\GitAdapter\commands\InitCommand;
use recyger\GitAdapter\Repository;

$repository = require_once '_constructRepository.php';

$command = new InitCommand($repository);

printf('Repository for "%s" %s', $repository->getPath(), $repository->isInit() ? 'initialized' : 'is not initialized');
echo PHP_EOL;

if ($command->run()) {
    echo 'Success' . PHP_EOL;
} else {
    echo 'Error when init: ' . $command->getError();
}

printf('Repository for "%s" %s', $repository->getPath(), $repository->isInit() ? 'initialized' : 'is not initialized');
echo PHP_EOL;
