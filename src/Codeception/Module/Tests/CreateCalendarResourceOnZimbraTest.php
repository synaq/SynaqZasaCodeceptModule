<?php

namespace Codeception\Module\Tests;

use Mockery as m;
use Synaq\ZasaBundle\Exception\SoapFaultException;

class CreateCalendarResourceOnZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     * @throws SoapFaultException
     */
    public function createsCalendarResourceOnce()
    {
        $this->module->createCalendarResourceOnZimbra(null);
        $this->zasa->shouldHaveReceived('createCalendarResource')->once();
    }

    /**
     * @test
     * @throws SoapFaultException
     */
    public function createsCalendarResourceUsingTheGivenName()
    {
        $this->module->createCalendarResourceOnZimbra('foo@bar.com');
        $this->zasa->shouldHaveReceived('createCalendarResource')->with('foo@bar.com', m::any(), m::any(), m::any(), m::any());
    }
}