<?php
namespace recyger\GitAdapter\commands;

use recyger\GitAdapter\base\Command;
use recyger\GitAdapter\base\RepositoryInterface;

class InitCommand extends Command
{
    public function __construct(RepositoryInterface $repository, array $attributes = null, array $options = null)
    {
        if (is_null($attributes)) {
            $attributes = [$repository->getPath()];
        }
        parent::__construct($repository, 'init', $attributes, $options, false);
    }
}
