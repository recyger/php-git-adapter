<?php
namespace recyger\GitAdapter\commands;

use recyger\GitAdapter\base\Command;
use recyger\GitAdapter\base\RepositoryInterface;

class FetchCommand extends Command
{
    public function __construct(RepositoryInterface $repository, array $arguments = null, array $options = null)
    {
        parent::__construct($repository, 'fetch', $arguments, $options, true);
    }
}
