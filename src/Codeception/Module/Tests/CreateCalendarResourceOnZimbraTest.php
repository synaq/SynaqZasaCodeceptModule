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

    /**
     * @test
     * @throws SoapFaultException
     */
    public function usesAPseudoRandomPasswordIfNoneIsGiven()
    {
        srand(0);
        $expectedPassword = substr(md5(rand()), 0, 6) . 'A$';
        srand(0);
        $this->module->createCalendarResourceOnZimbra(null);
        $this->zasa->shouldHaveReceived('createCalendarResource')->with(m::any(), $expectedPassword, m::any(), m::any(), m::any());
    }

    /**
     * @test
     * @throws SoapFaultException
     */
    public function createsCalendarResourceUsingTheGivenDisplayName()
    {
        $this->module->createCalendarResourceOnZimbra(null, null, 'Some Display Name');
        $this->zasa->shouldHaveReceived('createCalendarResource')->with(m::any(), m::any(), 'Some Display Name', m::any(), m::any());
    }

    /**
     * @test
     * @throws SoapFaultException
     */
    public function acceptsAnyDisplayName()
    {
        $this->module->createCalendarResourceOnZimbra(null, null, 'Any Display Name');
        $this->zasa->shouldHaveReceived('createCalendarResource')->with(m::any(), m::any(), 'Any Display Name', m::any(), m::any());
    }

    /**
     * @test
     * @throws SoapFaultException
     */
    public function usesAGenericDisplayNameIfNoneIsGiven()
    {
        $this->module->createCalendarResourceOnZimbra(null, null);
        $this->zasa->shouldHaveReceived('createCalendarResource')->with(m::any(), m::any(), 'Test Calendar Resource', m::any(), m::any());
    }

    /**
     * @test
     * @throws SoapFaultException
     */
    public function createsCalendarResourceUsingTheGivenResourceType()
    {
        $this->module->createCalendarResourceOnZimbra(null, null, null, 'Location');
        $this->zasa->shouldHaveReceived('createCalendarResource')->with(m::any(), m::any(), m::any(), 'Location', m::any());
    }
}