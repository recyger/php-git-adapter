<?php
namespace recyger\GitAdapter\components;

use recyger\GitAdapter\base\Component;
use recyger\GitAdapter\base\RemoteManagerInterface;
use recyger\GitAdapter\base\RepositoryInterface;

/**
 * Class RemoteManager
 *
 * @property \recyger\GitAdapter\Repository repository
 *
 * @package recyger\GitAdapter\adapter
 */
class RemoteManager extends Component implements RemoteManagerInterface, \ArrayAccess, \IteratorAggregate, \Countable
{

    private $_remotesCollection;
    private $_repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->_repository = $repository;
    }

    public function offsetExists($offset) : bool
    {
        return isset($this->_getList()[$offset]);
    }

    private function &_getList() : array
    {
        if (is_null($this->_remotesCollection)) {
            $this->_setRemoteCollection();
        }

        return $this->_remotesCollection;
    }

    private function _setRemoteCollection(array $remoteNames = null)
    {
        if (is_null($remoteNames)) {
            $remoteNames = $this->repository->remoteCommand->list;
        }
        $this->_remotesCollection = [];
        foreach ($remoteNames as $name) {
            $this->_remotesCollection[$name] = new Remote($this, $name);
        }
    }

    public function offsetGet($offset) : Remote
    {
        return $this->_getList()[$offset];
    }

    public function offsetSet($offset, $value) : bool
    {
        if ($this->repository->remoteCommand->add($offset, $value)) {
            $this->_getList()[$offset] = new Remote($this, $offset);

            return true;
        }

        return false;
    }

    public function offsetUnset($offset) : bool
    {
        return $this->remove($offset);
    }

    public function remove($name) : bool
    {
        if ($this->repository->remoteCommand->remove($name)) {
            unset($this->_getList()[$name]);

            return true;
        }

        return false;
    }

    public function rename($oldName, $newName) : bool
    {
        if (!isset($this[$oldName])) {
            throw new \Exception(sprintf('Remote "%s" not exists'));
        }
        if ($this->repository->remoteCommand->rename($oldName, $newName)) {
            $this->_remotesCollection[$newName] = new Remote($this, $newName);
            unset($this->_remotesCollection[$oldName]);

            return true;
        }

        return false;
    }

    public function getRepository(): RepositoryInterface
    {
        return $this->_repository;
    }

    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->_getList());
    }

    public function count()
    {
        return count($this->_getList());
    }
}
