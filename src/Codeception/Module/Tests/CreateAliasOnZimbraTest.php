<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 2016/07/26
 * Time: 11:58
 */

namespace Codeception\Module\Tests;


use Mockery as m;

class CreateAliasOnZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function shouldCallGetAccountIdWithMailboxAddressOnce()
    {
        $this->module->createAliasOnZimbra('mailbox@domain.com', null);
        $this->zasa->shouldHaveReceived('getAccountId')->once();
    }

    /**
     * @test
     */
    public function shouldCallGetAccountIdWithMailboxAddress()
    {
        $this->module->createAliasOnZimbra('mailbox@domain.com', null);
        $this->zasa->shouldHaveReceived('getAccountId')->with('mailbox@domain.com');
    }

    /**
     * @test
     */
    public function shouldCallAddAccountAliasOnce()
    {
        $this->zasa->shouldReceive('getAccountId')->andReturn('mailbox-id');
        $this->module->createAliasOnZimbra(null, null);
        $this->zasa->shouldHaveReceived('addAccountAlias')->once();
    }

    /**
     * @test
     */
    public function shouldCallAddAccountAliasWithIdReturnedFromGetAccountId()
    {
        $this->zasa->shouldReceive('getAccountId')->andReturn('mailbox-id');
        $this->module->createAliasOnZimbra(null, null);
        $this->zasa->shouldHaveReceived('addAccountAlias')->with('mailbox-id', m::any());
    }

    /**
     * @test
     */
    public function shouldCallAddAccountAliasWithAliasAddress()
    {
        $this->module->createAliasOnZimbra(null, 'alias@domain.com');
        $this->zasa->shouldHaveReceived('addAccountAlias')->with(m::any(), 'alias@domain.com');
    }
}
