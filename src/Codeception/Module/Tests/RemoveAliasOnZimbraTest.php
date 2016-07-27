<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 2016/07/27
 * Time: 12:00
 */

namespace Codeception\Module\Tests;


use Mockery as m;

class RemoveAliasOnZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function shouldCallGetAccountIdWithMailboxAddressOnce()
    {
        $this->module->removeAliasOnZimbra(null, null);
        $this->zasa->shouldHaveReceived('getAccountId')->once();
    }

    /**
     * @test
     */
    public function shouldCallGetAccountIdWithMailboxAddress()
    {
        $this->module->removeAliasOnZimbra('mailbox@domain.com', null);
        $this->zasa->shouldHaveReceived('getAccountId')->with('mailbox@domain.com');
    }

    /**
     * @test
     */
    public function shouldCallRemoveAccountAliasOnce()
    {
        $this->module->removeAliasOnZimbra(null, null);
        $this->zasa->shouldHaveReceived('removeAccountAlias')->once();
    }

    /**
     * @test
     */
    public function shouldCallRemoveAccountAliasWithIdReturnedFromGetAccountId()
    {
        $this->zasa->shouldReceive('getAccountId')->andReturn('mailbox-id');
        $this->module->removeAliasOnZimbra(null, null);
        $this->zasa->shouldHaveReceived('removeAccountAlias')->with('mailbox-id', m::any());
    }
}