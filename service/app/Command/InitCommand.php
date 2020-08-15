<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\Admin\AuthService;
use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Container\ContainerInterface;

/**
 * @Command()
 * Class InitCommand
 * @package App\Command
 */
class InitCommand extends HyperfCommand
{

    /**
     * @Inject()
     * @var AuthService
     */
    public $service;

    /**
     * @var string
     */
    protected $name = 'mq:init';

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject()
     * @var RequestInterface
     */
    protected $request;

    /**
     * InitCommand constructor.
     * @param string|null $name
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        parent::__construct($this->name);
    }

    /**
     * configure
     */
    protected function configure()
    {
        parent::configure();
        $this->setDescription('initialization app');
    }

    /**
     * Handle the console command.
     */
    public function handle()
    {
        $choice = $this->choice('是否执行migrate?', ['No', 'Yes']);
        if ($choice === 'Yes') {
            $this->initMigration();
        }
        $choice = $this->choice('是否初始化一个后台账号密码？', ['No', 'Yes']);
        if ($choice === 'Yes') {
            $this->initAccount();
        }
        $this->line('Initialization successfully.');
    }

    /**
     * init migration
     */
    public function initMigration()
    {
        $this->call('migrate');
    }

    /**
     * init account
     * @return bool
     */
    public function initAccount()
    {
        $account = $this->ask('账号');
        $password = $this->ask('密码');

        try {

            $this->service->register($account, '', $password, '127.0.0.1');
            $this->info('账号：' . $account . ' 密码：' . $password . ' 请记住账号密码');

        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return false;
        }
    }
}