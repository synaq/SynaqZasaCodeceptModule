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
    public function shouldCallCreateMailboxOnZasa()
    {
        $this->module->createMailboxOnZimbra('test@example.com', 'some-password');
        $this->zasa->shouldHaveReceived('createAccount')->with('test@example.com', 'some-password', m::any());
    }
}