<?php

declare(strict_types=1);

namespace App\Command;

use App\Utils\Common;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Utils\Arr;
use Hyperf\Utils\CodeGen\Project;
use Hyperf\Utils\Str;
use PhpZip\Exception\ZipException;
use PhpZip\ZipFile;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * @Command
 */
class PluginCommand extends HyperfCommand
{
    protected $name = 'mq:plugin';

    protected $regRules = [
        'controller/' => 'controller+[*]?',
        'service/' => 'service+[*]?',
        'migration/' => 'migration+[*]?',
        'model/' => 'model+[*]?',
    ];

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct($this->name);
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('Install Uninstall the downloaded plugins or Create initialization plugins');
    }

    public function handle()
    {
        $action = $this->input->getArgument('action'); // 动作
        $name = $this->input->getArgument('name'); // 包名

        if (!in_array(strtolower($action), ['up', 'down', 'create'])) {
            $this->error('wrong action. the action only contains up, down or create');
            return false;
        }
        switch (strtolower($action)) {
            case 'up':
                $this->unzipInstallPlugin($name);
                break;
            case 'down':
                $this->uninstallPlugin($name);
                break;
            case 'create':
                $this->generateCreatePlugin($name);
                break;
        }
    }

    /**
     * generate create plugin
     * @param $name
     */
    protected function generateCreatePlugin($name)
    {
        $this->line('plugin ' . $name . ' created successfully! ', 'info');
    }

    /**
     * uninstall plugin
     * @param $name
     */
    protected function uninstallPlugin($name)
    {
        $this->line('plugin ' . $name . ' uninstalled successfully! ', 'info');
    }

    /**
     * unzip and install plugin
     * @param $name
     */
    protected function unzipInstallPlugin($name)
    {
        // 获取压缩包根据name
        try {
            $this->line("start install plugin {$name} ...", 'info');
            $pluginTempPath = BASE_PATH . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . $name;
            $migrationsPath = BASE_PATH . DIRECTORY_SEPARATOR . 'migrations';

            $zipFile = new ZipFile();
            $zipFile->openFile($pluginTempPath . '.zip');
            if ($zipFile->count() === 0) {
                throw new ZipException('The compressed plugins is Empty.');
            }
            $res = Common::mkDir($pluginTempPath);
            if (!$res) {
                throw new ZipException(sprintf('Directory %s creation failed, Please check permissions.', $name));
            }
            $zipFile->extractTo($pluginTempPath);

            $classControllerName    = $this->qualifyClass(ucfirst(strtolower($name)), 'controllerNamespace');
            $classServiceName       = $this->qualifyClass(ucfirst(strtolower($name)), 'serviceNamespace');
            $installControllerPath  = $this->getPath($classControllerName, '');
            $installServicePath     = $this->getPath($classServiceName, '');
            $controllerRes          = Common::mkDir($installControllerPath);
            $serviceRes             = Common::mkDir($installServicePath);

            if (!$controllerRes || !$serviceRes) {
                throw new ZipException(sprintf('Directory %s creation failed, Please check permissions.', $name));
            }
            $headers = ['插件临时路径', $pluginTempPath];
            $rows = [
                ['控制器路径', $installControllerPath],
                new TableSeparator(),
                ['服务层路径', $installServicePath],
                new TableSeparator(),
                ['数据库迁移路径', $migrationsPath]
            ];
            $this->table($headers, $rows, 'symfony-style-guide');

            $childPathList = Common::getChildPath($pluginTempPath);
            foreach ($childPathList as $key => $value) {
                if (strtolower($value) === 'controller') {
                    recurse_copy($pluginTempPath . DIRECTORY_SEPARATOR . $value, $installControllerPath);
                }
                if (strtolower($value) === 'service') {
                    recurse_copy($pluginTempPath . DIRECTORY_SEPARATOR . $value, $installServicePath);
                }
                if (strtolower($value) === 'migrations') {
                    recurse_copy($pluginTempPath . DIRECTORY_SEPARATOR . $value, $migrationsPath);
                }
            }

            $zipFile->close();
            Common::delDirFile($pluginTempPath);
            $this->line('plugin ' . $name . ' installed successfully! ', 'info');
            $this->line('restart hot reload server ...', 'info');

            if (!function_exists('system')) {
                throw new ZipException('请在php.ini配置中取消禁用system方法');
            }
            define('PHP', @system('which php'));
            if (!file_exists(PHP) || !is_executable(PHP)) {
                throw new ZipException('PHP bin (" ' . PHP . ' ") 路径没有找到或无法执行，请确认路径正确?' . PHP_EOL);
            }
            $hotStatus = $this->input->getOption('hot');
            if ($hotStatus !== '0') {
                echo @system(PHP . ' ' . BASE_PATH . '/watch');
            } else {
                echo @system(PHP . ' ' . BASE_PATH . '/bin/hyperf.php start');
            }

        } catch (ZipException $e) {
            $this->line($e->getMessage(), 'error');
        }
    }

    protected function getArguments()
    {
        return [
            ['action', InputArgument::REQUIRED, 'The operations for installing plugin e.g. up, down or create'],
            ['name', InputArgument::REQUIRED, 'The name of the plugin'],
        ];
    }

    protected function getOptions()
    {
        return [
            ['cnamespace', 'CN', InputOption::VALUE_OPTIONAL, 'The controller namespace for class.', $this->getDefaultNamespace('controllerNamespace')],
            ['snamespace', 'SN', InputOption::VALUE_OPTIONAL, 'The service namespace for class.', $this->getDefaultNamespace('serviceNamespace')],
            ['hot', 'H', InputOption::VALUE_OPTIONAL, 'service hot reload type.', '0']
        ];
    }

    /**
     * Get the custom config for generator.
     */
    protected function getConfig(): array
    {
        $class = Arr::last(explode('\\', static::class));
        $class = Str::replaceLast('Command', '', $class);
        $key = 'devtool.mqcms.' . Str::snake($class, '.');
        return $this->container->get(ConfigInterface::class)->get($key) ?? [];
    }

    /**
     * @return string
     */
    protected function getDefaultNamespace($namespace='controllerNamespace'): string
    {
        $appNamespace = $namespace === 'controllerNamespace' ? 'Controller' : 'Service';
        return $this->getConfig()[$namespace] ?? "App\\{$appNamespace}\\Plugins";
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param string $name
     * @return string
     */
    protected function qualifyClass($name, $namespace = 'controllerNamespace')
    {
        $name = ltrim($name, '\\/');

        $name = str_replace('/', '\\', $name);

        if ($namespace === 'controllerNamespace') {
            $namespace = $this->input->getOption('cnamespace');
        } else {
            $namespace = $this->input->getOption('snamespace');
        }
        if (empty($namespace)) {
            $namespace = $this->getDefaultNamespace('controllerNamespace');
        }
        if (empty($namespace)) {
            $namespace = $this->getDefaultNamespace('serviceNamespace');
        }

        return $namespace . '\\' . $name;
    }

    /**
     * Determine if the class already exists.
     *
     * @param string $rawName
     * @return bool
     */
    protected function alreadyExists($rawName, $namespace = 'controllerNamespace')
    {
        return is_file($this->getPath($this->qualifyClass($rawName, $namespace)));
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name, $extension = '.php')
    {
        $project = new Project();
        return BASE_PATH . '/' . $project->path($name, $extension);
    }
}
