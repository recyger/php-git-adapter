<?php
require_once '../vendor/autoload.php';
use recyger\GitAdapter\Repository;

$temporaryDirectory = tempnam(sys_get_temp_dir(), '');
if (file_exists($temporaryDirectory)) {
    unlink($temporaryDirectory);
}

return new Repository($temporaryDirectory);
