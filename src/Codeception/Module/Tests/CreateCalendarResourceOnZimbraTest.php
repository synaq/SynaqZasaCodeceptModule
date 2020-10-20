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

    /**
     * @test
     * @throws SoapFaultException
     */
    public function acceptsAnyName()
    {
        $this->module->createCalendarResourceOnZimbra('bar@baz.com');
        $this->zasa->shouldHaveReceived('createCalendarResource')->with('bar@baz.com', m::any(), m::any(), m::any(), m::any());
    }

    /**
     * @test
     * @throws SoapFaultException
     */
    public function createsCalendarResourceUsingTheGivenPassword()
    {
        $this->module->createCalendarResourceOnZimbra(null, 'Testing123$');
        $this->zasa->shouldHaveReceived('createCalendarResource')->with(m::any(), 'Testing123$', m::any(), m::any(), m::any());
    }

    /**
     * @test
     * @throws SoapFaultException
     */
    public function acceptsAnyGivenPassword()
    {
        $this->module->createCalendarResourceOnZimbra(null, 'Test456#');
        $this->zasa->shouldHaveReceived('createCalendarResource')->with(m::any(), 'Test456#', m::any(), m::any(), m::any());
    }
}