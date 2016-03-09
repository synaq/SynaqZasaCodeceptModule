<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 15/04/20
 * Time: 16:36
 */

namespace Codeception\Module\Tests;

use \Mockery as m;

/**
 * Class ZasaModuleTest
 * @package Codeception\Module
 */
class ZasaModuleTest extends ZasaModuleTestCase
{
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