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

    protected function setUp()
    {
        parent::setUp();

        $this->zasa->shouldReceive('getCalendarResource')->andReturn(['id' => null])->byDefault();
    }
}
