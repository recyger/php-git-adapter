<?php
use recyger\GitAdapter\Repository;

include_once('_printListRemotes.php');
/** @var Repository $repository */
$repository = require_once '_constructRepository.php';

if ($repository->cloneRemote('git@github.com:recyger/php-git-adapter.git')) {
    printListRemotes($repository);

    print "Check exists 'origin'" . PHP_EOL;
    if (isset($repository->remotes['origin'])) {
        print "Unset 'origin'" . PHP_EOL;
        unset($repository->remotes['origin']);
    } else {
        print "Not exists 'origin'" . PHP_EOL;
    }

    printListRemotes($repository);

    print "Add 'origin'" . PHP_EOL;
    $repository->remotes['origin'] = 'git@github.com:recyger/php-git-adapter.git';

    printListRemotes($repository);

    printf('User name %s%s', $repository->configCommand->userName, PHP_EOL);
    printf('User email %s%s', $repository->configCommand->userEmail, PHP_EOL);
}
