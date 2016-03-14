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
    /**
     * @test
     */
    public function shouldCallGetAccountOnZasaConnectorWithEmailAddress()
    {
        $this->module->getAccountFromZimbra('example@example.com');
        $this->zasa->shouldHaveReceived('getAccount')->with('example@example.com')->once();
    }

    /**
     * @test
     */
    public function shouldSetResultReturnedFromZimbraAsLatestResultInModule()
    {
        $this->zasa->shouldReceive('getAccount')->andReturn(['id' => 'returned-account-id']);
        $this->module->getAccountFromZimbra(null);
        $result = $this->module->grabResultFromZimbra();
        $this->assertEquals('returned-account-id', $result['id']);
    }
}