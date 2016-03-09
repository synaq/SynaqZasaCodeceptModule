<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 2016/03/09
 * Time: 13:49
 */

namespace Codeception\Module\Tests;


class GetAccountFromZimbraTest extends ZasaModuleTestCase
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
}