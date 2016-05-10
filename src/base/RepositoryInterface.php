<?php
namespace recyger\GitAdapter\base;

use recyger\GitAdapter\commands\FetchCommand;
use recyger\GitAdapter\commands\InitCommand;
use recyger\GitAdapter\commands\RemoteCommand;
use recyger\GitAdapter\components\RemoteManager;

interface RepositoryInterface
{
    public function isInit() : bool;

    public function getPath() : string;

    public function getGitPath() : string;

    public function getRemotes() : RemoteManager;

    public function getRemoteCommand() : RemoteCommand;

    public function getInitCommand() : InitCommand;

    public function getFetchCommand() : FetchCommand;
}
