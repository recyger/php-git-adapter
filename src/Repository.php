<?php
namespace recyger\GitAdapter;

use recyger\GitAdapter\base\Command;
use recyger\GitAdapter\base\Component;
use recyger\GitAdapter\base\RepositoryInterface;
use recyger\GitAdapter\commands\CloneCommand;
use recyger\GitAdapter\commands\ConfigCommand;
use recyger\GitAdapter\commands\FetchCommand;
use recyger\GitAdapter\commands\InitCommand;
use recyger\GitAdapter\commands\RemoteCommand;
use recyger\GitAdapter\components\RemoteManager;

/**
 * Class Repository
 *
 * @property RemoteManager remotes
 * @property RemoteCommand remoteCommand
 * @property InitCommand   initCommand
 * @property FetchCommand  fetchCommand
 * @property ConfigCommand configCommand
 * @property ConfigCommand config
 *
 *
 * @package recyger\GitAdapter
 */
class Repository extends Component implements RepositoryInterface
{

    private $_path;
    private $_gitPath;
    private $_lastError;
    private $_remoteManager;
    private $_classRemoteManager;

    public function __construct(string $path, string $classRemoteManager = RemoteManager::class)
    {
        $this->setPath($path);
        $this->_classRemoteManager = $classRemoteManager;
    }

    public function init() : bool
    {
        return $this->runCommand(new InitCommand($this));
    }

    private function runCommand(Command $command) : bool
    {
        $result = $command->run();
        $this->setLastError($command->getError());

        return $result;
    }

    private function setLastError($error)
    {
        $this->_lastError = $error;
    }

    /**
     * @return mixed
     */
    public function getLastError()
    {
        return $this->_lastError;
    }

    public function getFetchCommand() : FetchCommand
    {
        return $this->getCommand(FetchCommand::class);
    }

    private function getCommand($class) : Command
    {
        static $commands = [];
        if (!isset($commands[$class])) {
            $commands[$class] = new $class($this);
        }

        return $commands[$class];
    }

    public function getConfigCommand() : ConfigCommand
    {
        return $this->getCommand(ConfigCommand::class);
    }

    public function getConfig() : ConfigCommand
    {
        return $this->getConfigCommand();
    }

    public function cloneRemote(string $src) : bool
    {
        return $this->getCloneCommand()->remote($src);
    }

    public function getCloneCommand() : CloneCommand
    {
        return $this->getCommand(CloneCommand::class);
    }

    public function destroy()
    {
        unlink($this->getPath());
    }

    public function getPath() : string
    {
        return $this->_path;
    }


    public function setPath($_path) : self
    {
        if (!file_exists($_path)) {
            mkdir($_path);
        }
        $this->_path = $_path;

        return $this;
    }

    public function getRemoteCommand() : RemoteCommand
    {
        return $this->getCommand(RemoteCommand::class);
    }

    public function getRemotes(): RemoteManager
    {
        if (is_null($this->_remoteManager)) {
            $this->setRemoteManager();
        }

        return $this->_remoteManager;
    }

    private function setRemoteManager()
    {
        $this->_remoteManager = new $this->_classRemoteManager($this);
    }

    public function isInit() : bool
    {
        return is_dir($this->getGitPath());
    }

    public function getGitPath() : string
    {
        if (is_null($this->_gitPath)) {
            $this->setGitPath();
        }

        return $this->_gitPath;
    }

    public function setGitPath(string $path = null)
    {
        if (is_null($path)) {
            $path = $this->getPath() . DIRECTORY_SEPARATOR . '.git';
        }
        $this->_gitPath = $path;
    }

    public function getInitCommand() : InitCommand
    {
        return $this->getCommand(InitCommand::class);
    }
}
