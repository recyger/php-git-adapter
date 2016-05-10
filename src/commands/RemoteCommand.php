<?php
namespace recyger\GitAdapter\commands;

use recyger\GitAdapter\base\Command;
use recyger\GitAdapter\base\RepositoryInterface;

/**
 * Class RemoteCommand
 *
 * @property array list
 *
 * @package recyger\GitAdapter\commands
 */
class RemoteCommand extends Command
{
    public function __construct(RepositoryInterface $repository, array $arguments = null, array $options = null)
    {
        parent::__construct($repository, 'remote', $arguments, $options, true);
    }

    public function getList() : array
    {
        $list = [];
        $this->setArguments([]);
        if ($this->run()) {
            $list = array_filter(array_map('trim', explode("\n", $this->getOutput())));
        }

        return $list;
    }

    public function getUrl(string $name) : string
    {
        $url = '';
        $this->setArguments(['get-url', $name]);
        if ($this->run()) {
            $url = trim($this->getOutput());
        }

        return $url;
    }

    public function remove(string $name) : bool
    {
        $this->setArguments(['remove', $name]);

        return $this->run();
    }

    public function rename(string $oldName, string $newName) : bool
    {
        $this->setArguments(['rename', $oldName, $newName]);

        return $this->run();
    }

    public function setUrl(string $name, string $url) : bool
    {
        $this->setArguments(['set-url', $name, $url]);

        return $this->run();
    }

    public function add(string $name, string $url) : bool
    {
        $this->setArguments(['add', $name, $url]);

        return $this->run();
    }
}
