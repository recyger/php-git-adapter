<?php
namespace recyger\GitAdapter\components;

use recyger\GitAdapter\base\Component;
use recyger\GitAdapter\base\RemoteInterface;
use recyger\GitAdapter\base\RemoteManagerInterface;

/**
 * Class Remote
 *
 * @property string        name
 * @property string        url
 * @property RemoteManager remoteManager
 *
 * @package recyger\GitAdapter\adapter
 */
class Remote extends Component implements RemoteInterface
{

    private $_remoteManager;
    private $_name;
    private $_url;

    public function __construct(RemoteManagerInterface $remoteManager, string $name)
    {
        $this->_remoteManager = $remoteManager;
        $this->_name          = $name;
    }

    public function fetch() : bool
    {
        return $this->remoteManager->repository->fetchCommand->setArguments([$this->getName()])->run();
    }

    public function getName() : string
    {
        return $this->_name;
    }

    public function getURL() : string
    {
        if (is_null($this->_url)) {
            $this->_requestURL();
        }

        return $this->_url;
    }

    public function setUrl(string $url) : bool
    {
        if ($this->remoteManager->repository->remoteCommand->setUrl($this->getName(), $url)) {
            $this->_url = $url;

            return true;
        }

        return false;
    }

    private function _requestURL()
    {
        $this->_url = $this->remoteManager->repository->remoteCommand->getUrl($this->getName());
    }

    public function remove() : bool
    {
        return $this->remoteManager->remove($this->getName());
    }

    public function rename($name) : bool
    {
        return $this->remoteManager->rename($this->getName(), $name);
    }

    public function getRemoteManager() : RemoteManagerInterface
    {
        return $this->_remoteManager;
    }
}
