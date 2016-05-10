<?php

use recyger\GitAdapter\Repository;

function printListRemotes(Repository $repository)
{
    if (count($repository->remotes) > 0) {
        print "List remotes for repository:" . PHP_EOL;
        foreach ($repository->remotes as $remote) {
            printf('=> %s %s%s', $remote->name, $remote->url, PHP_EOL);
        }
    } else {
        print "Empty list remotes" . PHP_EOL;
    }
}
