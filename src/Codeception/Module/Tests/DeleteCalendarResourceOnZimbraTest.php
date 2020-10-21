<?php

namespace Codeception\Module\Tests;

use Synaq\ZasaBundle\Exception\SoapFaultException;

class DeleteCalendarResourceOnZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     * @throws SoapFaultException
     */
    public function deletesCalendarResourceOnce()
    {
        $this->module->deleteCalendarResourceOnZimbra(null);
        $this->zasa->shouldHaveReceived('deleteCalendarResource')->once();
    }

    /**
     * @test
     * @throws SoapFaultException
     */
    public function deletesCalendarResourceUsingTheIdReturnedFromZimbraForTheGivenName()
    {
        $this->zasa->shouldReceive('getCalendarResource')->with('foo@bar.com')->andReturn(['id' => 'SOME-ID']);
        $this->module->deleteCalendarResourceOnZimbra('foo@bar.com');
        $this->zasa->shouldHaveReceived('deleteCalendarResource')->with('SOME-ID');
    }

    protected function setUp()
    {
        parent::setUp();

        $this->zasa->shouldReceive('getCalendarResource')->andReturn(['id' => 'SOME-OTHER-ID'])->byDefault();
    }
}
