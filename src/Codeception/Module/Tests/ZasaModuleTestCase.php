<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 2016/03/09
 * Time: 13:29
 */

namespace Codeception\Module\Tests;


use Codeception\Lib\ModuleContainer;
use Codeception\Module\ZasaModule;
use Mockery as m;
use Synaq\ZasaBundle\Connector\ZimbraConnector;

class ZasaModuleTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ZasaModule
     */
    protected $module;
    /**
     * @var ZimbraConnector | m\Mock
     */
    protected $zasa;

    protected function setUp()
    {
        /** @var ModuleContainer | m\Mock $container */
        $container = m::mock('\Codeception\Lib\ModuleContainer');
        $container->shouldIgnoreMissing();
        /** @var ZimbraConnector | m\Mock zasa */
        $this->zasa = \Mockery::mock('Synaq\ZasaBundle\Connector\ZimbraConnector');
        $this->zasa->shouldReceive('getAccountId')->andReturn('some-account-id')->byDefault();
        $this->zasa->shouldIgnoreMissing();
        $this->module = new ZasaModule($container, array(), $this->zasa);
    }
}