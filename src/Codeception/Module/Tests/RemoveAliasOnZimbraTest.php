<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 2016/07/27
 * Time: 12:00
 */

namespace Codeception\Module\Tests;


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
}