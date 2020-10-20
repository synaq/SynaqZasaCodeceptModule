<?php

namespace Codeception\Module\Tests;

use Mockery as m;
use Synaq\ZasaBundle\Exception\SoapFaultException;

class ModifyCalendarResourceOnZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     * @throws SoapFaultException
     */
    public function modifiesCalendarResourceOnce()
    {
        $this->module->modifyCalendarResourceOnZimbra(null, []);
        $this->zasa->shouldHaveReceived('modifyCalendarResource')->once();
    }

    /**
     * @test
     * @throws SoapFaultException
     */
    public function modifiesCalendarResourceUsingTheIdReturnedByZimbraForTheGivenName()
    {
        $this->zasa->shouldReceive('getCalendarResource')->with('foo@bar.com')->andReturn(['id' => 'SOME-ID']);
        $this->module->modifyCalendarResourceOnZimbra('foo@bar.com', []);
        $this->zasa->shouldHaveReceived('modifyCalendarResource')->with('SOME-ID', m::any());
    }

    /**
     * @test
     * @throws SoapFaultException
     */
    public function acceptsAnyGivenNameAndId()
    {
        $this->zasa->shouldReceive('getCalendarResource')->with('bar@baz.com')->andReturn(['id' => 'ANY-ID']);
        $this->module->modifyCalendarResourceOnZimbra('bar@baz.com', []);
        $this->zasa->shouldHaveReceived('modifyCalendarResource')->with('ANY-ID', m::any());
    }

    /**
     * @test
     * @throws SoapFaultException
     */
    public function passesTheGivenAttributesToZimbra()
    {
        $this->module->modifyCalendarResourceOnZimbra(null, ['foo' => 'bar']);
        $this->zasa->shouldHaveReceived('modifyCalendarResource')->with(m::any(), ['foo' => 'bar']);
    }

    protected function setUp()
    {
        parent::setUp();

        $this->zasa->shouldReceive('getCalendarResource')->andReturn(['id' => null])->byDefault();
    }
}
