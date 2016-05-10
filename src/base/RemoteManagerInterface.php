<?php
namespace recyger\GitAdapter\base;

interface RemoteManagerInterface
{
    public function getRepository(): RepositoryInterface;

    public function remove($name);

    public function rename($oldName, $newName);
}
