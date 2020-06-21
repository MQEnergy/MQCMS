<?php
declare(strict_types=1);

namespace App\Command;

use Hyperf\Command\Annotation\Command;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Devtool\Generator\GeneratorCommand;
use Hyperf\Utils\Arr;
use Hyperf\Utils\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @Command()
 * Class ControllerCommand
 * @package App\Command
 */
class ControllerCommand extends GeneratorCommand
{
    protected $name = 'mq:controller';

    public function __construct()
    {
        parent::__construct($this->name);
        $this->setDescription('Create a new mqcms controller class');
    }

    /**
     * Execute the console command.
     *
     * @return null|bool
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $inputs = $this->getNameInput();
        $name = $this->qualifyClass($inputs['name']);

        $path = $this->getPath($name);

        // First we will check to see if the class already exists. If it does, we don't want
        // to create the class and overwrite the user's code. So, we will bail out so the
        // code is untouched. Otherwise, we will continue generating this class' files.
        if (($input->getOption('force') === false) && $this->alreadyExists($inputs['name'])) {
            $output->writeln(sprintf('<fg=red>%s</>', $name . ' already exists!'));
            return false;
        }

        if (!$this->getStub()) {
            $this->output->writeln(sprintf('<fg=red>%s</>', 'module ' . trim($this->input->getArgument('type')) . ' not exists!'));
            return false;
        }

        // Next, we will generate the path to the location where this class' file should get
        // written. Then, we will build the class and make the proper replacements on the
        // stub files so that it gets the correctly formatted namespace and class name.
        $this->makeDirectory($path);

        file_put_contents($path, $this->buildModelClass($name, $inputs['logic'], $inputs['module']));

        $output->writeln(sprintf('<info>%s</info>', $name . ' created successfully.'));
    }

    /**
     * @param $name
     * @param $logic
     * @return string|string[]
     */
    protected function buildModelClass($name, $logic, $module)
    {
        $stub = file_get_contents($this->getStub());
        $stub = $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
        $stub = $this->replaceLogic($stub, $logic);
        return $this->replaceModule($stub, $module);
    }

    /**
     * @param $stub
     * @param $name
     * @return string|string[]
     */
    protected function replaceLogic($stub, $name)
    {
        return str_replace('%LOGIC%', $name, $stub);
    }

    /**
     * @param $stub
     * @param $name
     * @return string|string[]
     */
    protected function replaceModule($stub, $name)
    {
        return str_replace('%MODULE%', ucfirst(strtolower($name)), $stub);
    }

    /**
     * @return string
     */
    protected function getStub(): string
    {
        return $this->getConfig()['stub'] ?? __DIR__ . '/stubs/controller.stub';
    }

    /**
     * @return string
     */
    protected function getDefaultNamespace(): string
    {
        return $this->getConfig()['namespace'] ?? 'App\\Controller\\Admin';
    }


    /**
     * Get the custom config for generator.
     */
    protected function getConfig(): array
    {
        $class = Arr::last(explode('\\', static::class));
        $class = Str::replaceLast('Command', '', $class);
        $key = 'devtool.mqcms.' . Str::snake($class, '.');
        return $this->getContainer()->get(ConfigInterface::class)->get($key) ?? [];
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return [
            'name' => trim($this->input->getArgument('name')),
            'logic' => trim($this->input->getArgument('logic')),
            'module' => trim($this->input->getArgument('module'))
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the controller class'],
            ['logic', InputArgument::REQUIRED, 'The name of the logic class'],
            ['module', InputArgument::REQUIRED, 'module type, eg. admin, frontend or api ...'],
        ];
    }
}