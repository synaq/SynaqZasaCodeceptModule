<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 2016/05/18
 * Time: 09:00
 */

namespace Codeception\Module\Tests;

use Mockery as m;

class CreateDomainOnZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function shouldCallCreateDomainOnZasaConnectorWithDomainName()
    {
        $this->module->createDomainOnZimbra('example.com');
        $this->zasa->shouldHaveReceived('createDomain')->with('example.com', m::any());
    }
}
