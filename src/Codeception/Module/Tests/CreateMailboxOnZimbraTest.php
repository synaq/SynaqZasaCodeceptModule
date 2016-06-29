<?php
/**
 * Created by PhpStorm.
 * User: nicholasp
 * Date: 2016/05/18
 * Time: 11:47 AM
 */

namespace Codeception\Module\Tests;

use Mockery as m;

class CreateMailboxOnZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function shouldCallCreateMailboxOnZasaWithAddress()
    {
        $this->module->createMailboxOnZimbra('test@example.com', null);
        $this->zasa->shouldHaveReceived('createAccount')->with('test@example.com', m::any(), m::any())->once();
    }

    /**
     * @test
     */
    public function shouldCallCreateMailboxOnZasaWithPassword()
    {
        $this->module->createMailboxOnZimbra(null, 'some-password');
        $this->zasa->shouldHaveReceived('createAccount')->with(m::any(), 'some-password', m::any());
    }

    /**
     * @test
     */
    public function shouldCallCreateMailboxOnZasaWithAddressAsSn()
    {
        $this->module->createMailboxOnZimbra('test@example.com', null);
        $this->zasa->shouldHaveReceived('createAccount')->with(m::any(), m::any(), ['sn' => 'test@example.com']);
    }
}