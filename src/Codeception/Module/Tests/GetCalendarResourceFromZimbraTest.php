<?php

namespace Codeception\Module\Tests;

use Synaq\ZasaBundle\Exception\SoapFaultException;

class GetCalendarResourceFromZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     * @throws SoapFaultException
     */
    public function getsCalendarResourceFromZimbraOnce()
    {
        $this->module->getCalendarResourceFromZimbra(null);
        $this->zasa->shouldHaveReceived('getCalendarResource')->once();
    }


    /**
     * @test
     * @throws SoapFaultException
     */
    public function getsCalendarResourceUsingTheGivenName()
    {
        $this->module->getCalendarResourceFromZimbra('foo@bar.com');
        $this->zasa->shouldHaveReceived('getCalendarResource')->with('foo@bar.com');
    }

    /**
     * @test
     * @throws SoapFaultException
     */
    public function acceptsAnyName()
    {
        $this->module->getCalendarResourceFromZimbra('bar@baz.com');
        $this->zasa->shouldHaveReceived('getCalendarResource')->with('bar@baz.com');
    }
}
