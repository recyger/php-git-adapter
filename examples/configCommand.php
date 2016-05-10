<?php
use recyger\GitAdapter\commands\ConfigCommand;
use recyger\GitAdapter\Repository;

/** @type Repository $repository */
$repository = require_once '_constructRepository.php';

$repository->init();

if ($repository->isInit()) {
    $command            = new ConfigCommand($repository);
    $command->userName  = 'recyger';
    $command->userEmail = 'recyger@gmail.com';
}
