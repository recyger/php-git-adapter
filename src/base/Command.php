<?php
namespace recyger\GitAdapter\base;

use recyger\GitAdapter\base\exception\CommandException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

class Command extends Component
{
    private $_repository;
    private $_bin = 'git';
    private $_arguments;
    private $_options;
    private $_command;
    /**
     * Last process instance
     *
     * @var Process
     */
    private $_process;

    public function __construct(
        RepositoryInterface $repository,
        string $command,
        array $arguments = null,
        array $options = null,
        bool $requireInit = null
    ) {
        $isInit = $repository->isInit();
        if ($requireInit === true && $isInit === false) {
            throw new CommandException('It is impossible to perform if the repository is not initialized.');
        } elseif ($requireInit === false && $isInit === true) {
            throw new CommandException('I can not make a clone in a repository that is already initialized.');
        }
        $this->_repository = $repository;

        $this->_command = $command;

        if (is_null($arguments)) {
            $arguments = [];
        }

        $this->setArguments($arguments);

        if (is_null($options)) {
            $options = [];
        }

        $this->setOptions($options);

    }

    public function run() : bool
    {
        $processBuilder = ProcessBuilder::create(
            array_merge(
                [$this->getBin()],
                $this->normalizationArguments($this->getOptions()),
                [$this->_command],
                $this->normalizationArguments($this->getArguments())
            )
        );
        $this->_process = $processBuilder->getProcess();
        $this->_process->run();

        return $this->_process->isSuccessful();
    }

    public function getBin() : string
    {
        return $this->_bin;
    }

    public function setBin(string $_bin) : self
    {
        $this->_bin = $_bin;

        return $this;
    }

    private function normalizationArguments(array $rawArguments): array
    {
        $arguments = [];
        foreach ($rawArguments as $name => $value) {
            if (!is_numeric($name)) {
                $arguments[] = $name;
            }
            $arguments[] = $value;
        }

        return $arguments;
    }

    public function getOptions() : array
    {
        if (!is_array($this->_options)) {
            $this->setOptions([]);
        }

        return $this->_options;
    }

    public function setOptions(array $options) : self
    {
        if (!isset($options['-C'])) {
            $options['-C'] = $this->getRepository()->getPath();
        } elseif ($options['-C'] === false) {
            unset($options['-C']);
        }
        $this->_options = $options;

        return $this;
    }

    public function getArguments() : array
    {
        if (!is_array($this->_arguments)) {
            $this->setArguments([]);
        }

        return $this->_arguments;
    }

    public function setArguments(array $arguments) : self
    {
        $this->_arguments = $arguments;

        return $this;
    }

    public function getError()
    {
        return $this->_process->getErrorOutput();
    }

    public function getOutput()
    {
        return $this->_process->getOutput();
    }

    public function addArgument(string $value): self
    {
        $arguments = $this->getArguments();
        if (!in_array($value, $arguments)) {
            $arguments[] = $value;
        }
        $this->setArguments($arguments);

        return $this;
    }

    public function getRepository() : RepositoryInterface
    {
        return $this->_repository;
    }
}
