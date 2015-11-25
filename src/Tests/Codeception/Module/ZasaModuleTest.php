<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 15/04/20
 * Time: 16:36
 */

namespace Codeception\Module;

use Codeception\Lib\ModuleContainer;
use Synaq\ZasaBundle\Connector\ZimbraConnector;
use \Mockery as m;

/**
 * Class ZasaModuleTest
 * @package Codeception\Module
 */
class ZasaModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ZimbraConnector | m\Mock
     */
    private $zasa;

    /**
     * @var ZasaModule
     */
    private $module;

    public function setUp()
    {
        /** @var ModuleContainer $container */
        $container = m::mock('\Codeception\Lib\ModuleContainer');
        $this->zasa = \Mockery::mock('Synaq\ZasaBundle\Connector\ZimbraConnector');
        $this->module = new ZasaModule($container);
        $this->module->_setZasa($this->zasa);
    }

    public function testGrabResultFromZimbra()
    {
        $dummyResult = array(
            'foo' => 'bar'
        );

        $this->module->_setResult($dummyResult);
        $result = $this->module->grabResultFromZimbra();
        $this->assertEquals($dummyResult, $result, "Incorrect result returned");
    }

    public function testSeeResultFromZimbraContains()
    {
        $dummyResult = array(
            'foo' => 'bar',
            'baz' => array(
                'fruit' => 'apple',
                'veg' => 'tomato',
                'meat' => 'beef'
            )
        );

        $this->module->_setResult($dummyResult);
        $this->module->seeResultFromZimbraContains(array('fruit' => 'apple'));
    }

    public function testDontSeeResultFromZimbraContains()
    {
        $dummyResult = array(
            'foo' => 'bar',
            'baz' => array(
                'fruit' => 'apple',
                'veg' => 'tomato',
                'meat' => 'beef'
            )
        );

        $this->module->_setResult($dummyResult);
        $this->module->dontSeeResultFromZimbraContains(array('fruit' => 'banana'));
    }

    public function testGetAccountFromZimbra()
    {
        $this->zasa
            ->shouldReceive('getAccount')
            ->once()
            ->with('example@example.com')
            ->andReturn(array(
                'id' => 'dummy-account-id',
                'displayName' => 'Test User',
                'givenName' => 'Test',
                'sn' => 'User',
                'zimbraIsDelegatedAdminAccount' => 'TRUE',
                'description' => 'IT;IT Services',
                'company' => 'IT',
                'zimbraHideInGal' => 'TRUE',
                'zimbraPrefOutOfOfficeReplyEnabled' => 'TRUE',
                'zimbraPrefOutOfOfficeReply' => 'Dummy out of office',
                'zimbraPrefMailForwardingAddress' => 'test@test.com',
                'zimbraPasswordMustChange' => 'TRUE',
                'zimbraPrefMailLocalDeliveryDisabled' => 'TRUE',
                'zimbraPrefFromDisplay' => 'From User',
                'zimbraPrefOutOfOfficeFromDate' => '20141231220000Z',
                'zimbraPrefOutOfOfficeUntilDate' => '23151231215959Z',
                'zimbraAccountStatus' => 'active'
            ));

        $this->module->getAccountFromZimbra("example@example.com");
        $this->zasa->mockery_verify();

        $result = $this->module->grabResultFromZimbra();
        $this->assertInternalType('array', $result, "Result not returned as array");
        $this->assertArrayHasKey('id', $result, "Account ID not returned");
        $this->assertEquals('dummy-account-id', $result['id'], "Incorrect account ID returned");
    }

    public function testModifyAccountOnZimbra()
    {
        $this->zasa
            ->shouldReceive('getAccountId')
            ->once()
            ->with('example@example.com')
            ->andReturn('example-account-id');

        $this->zasa
            ->shouldReceive('modifyAccount')
            ->once()
            ->withArgs(array(
                'example-account-id',
                array(
                    'zimbraPrefMailForwardingAddress' => 'dummy@example.com'
                )
            ));

        $this->module->modifyAccountOnZimbra("example@example.com", array(
            'zimbraPrefMailForwardingAddress' => 'dummy@example.com'
        ));
        $this->zasa->mockery_verify();
    }
}