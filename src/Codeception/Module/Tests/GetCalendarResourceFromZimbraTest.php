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
}
