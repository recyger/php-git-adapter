<?php
namespace recyger\GitAdapter\commands;

use recyger\GitAdapter\base\Command;
use recyger\GitAdapter\base\RepositoryInterface;

class CloneCommand extends Command
{
    public function __construct(RepositoryInterface $repository, array $arguments = null, array $options = null)
    {
        parent::__construct($repository, 'clone', $arguments, $options, false);
    }

    public function remote(string $remoteRepositoryURL) : bool
    {
        $this->setArguments([$remoteRepositoryURL, $this->getRepository()->getPath()]);
        return $this->run();
    }
}
