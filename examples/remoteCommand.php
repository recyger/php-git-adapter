<?php
use recyger\GitAdapter\commands\RemoteCommand;
use recyger\GitAdapter\Repository;

/** @type Repository $repository */
$repository = require_once '_constructRepository.php';

$repository->init();

if ($repository->isInit()) {
    $command = new RemoteCommand($repository);
    $command->add('origin', 'git@github.com:recyger/php-git-adapter.git');
    $remotes = $command->getList();
    foreach ($remotes as $index => $name) {
        $url = $command->getUrl($name);
        printf('%s. %s: %s', $index + 1, $name, $url);
    }
}
