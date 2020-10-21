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
}
