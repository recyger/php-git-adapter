<?php
namespace recyger\GitAdapter\base;

class Component
{

    public function __get($name)
    {
        $methodName = 'get' . $name;
        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        }
        return null;
    }

    public function __set($name, $value)
    {
        $methodName = 'set' . $name;
        if (method_exists($this, $methodName)) {
            return $this->$methodName($value);
        }
        return null;
    }
}
