<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 15/04/20
 * Time: 16:36
 */

namespace Codeception\Module;

use Synaq\ZasaBundle\Connector\ZimbraConnector;
use \Mockery as m;

/**
 * Class ZasaModuleTest
 * @package Codeception\Module
 */
class ZasaModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ZimbraConnector|m\MockInterface
     */
    private $zasa;

    /**
     * @var ZasaModule
     */
    private $module;

    public function setUp()
    {
        $this->zasa = \Mockery::mock('Synaq\ZasaBundle\Connector\ZimbraConnector');
        $this->module = new ZasaModule();
        $this->module->_setZasa($this->zasa);
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

        $result = $this->module->getAccountFromZimbra("example@example.com");
        $this->zasa->mockery_verify();
        $this->assertInternalType('array', $result, "Result not returned as array");
        $this->assertArrayHasKey('id', $result, "Account ID not returned");
        $this->assertEquals('dummy-account-id', $result['id'], "Incorrect account ID returned");
    }
}