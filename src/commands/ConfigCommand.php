<?php
namespace recyger\GitAdapter\commands;

use recyger\GitAdapter\base\Command;
use recyger\GitAdapter\base\RepositoryInterface;

/**
 * Class ConfigCommand
 *
 * @property string userName
 * @property string userEmail
 *
 * @package recyger\GitAdapter\commands
 */
class ConfigCommand extends Command
{
    public function __construct(RepositoryInterface $repository, array $arguments = null, array $options = null)
    {

        parent::__construct($repository, 'config', $arguments, $options, true);
    }

    public function setUserName($value) : bool
    {
        return $this->setUser('name', $value);
    }

    public function setUser($name, $value) : bool
    {
        return $this->set('user.' . $name, $value);
    }

    public function set($name, $value) : bool
    {
        $this->setArguments([$name, $value]);

        return $this->run();
    }

    public function setUserEmail($value) : bool
    {
        return $this->setUser('email', $value);
    }

    public function getUserName() : string
    {
        return $this->getUser('name');
    }

    public function getUser($name) : string
    {
        return $this->get('user.' . $name);
    }

    public function get($name) : string
    {
        $this->setArguments([$name]);

        $result = '';

        if ($this->run()) {
            $result = $this->getOutput();
        }

        return $result;
    }

    public function getUserEmail() : string
    {
        return $this->getUser('email');
    }
}
