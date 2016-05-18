<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 2016/05/18
 * Time: 11:54
 */

namespace Codeception\Module\Tests;


class DeleteMailboxOnZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function shouldCallGetAccountIdOnZasaWithEmailAddress()
    {
        $this->module->deleteMailboxOnZimbra('example@mailbox.com');
        $this->zasa->shouldHaveReceived('getAccountId')->with('example@mailbox.com')->once();
    }

    /**
     * @test
     */
    public function shouldCallDeleteAccountOnZasaWithAccountId()
    {
        $this->module->deleteMailboxOnZimbra('example@mailbox.com');
        $this->zasa->shouldHaveReceived('deleteAccount')->with('an-account-id')->once();
    }

    protected function setUp()
    {
        parent::setUp();
        $this->zasa->shouldReceive('getAccountId')->andReturn('an-account-id');
    }
}
