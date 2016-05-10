<?php
namespace recyger\GitAdapter\base;

interface RemoteInterface
{
    public function getName() : string;

    public function getURL() : string;

    public function setUrl(string $url) : bool;

    public function fetch() : bool;

    public function rename($name) : bool;

    public function remove() : bool;
}
