<?php

namespace Codeception\Module\Tests;

use Mockery as m;

class CreateDistributionListOnZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function callsCreateDlOnce()
    {
        $this->module->createDistributionListOnZimbra(null, []);
        $this->zasa->shouldHaveReceived('createDl')->once();
    }

    /**
     * @test
     */
    public function callsCreateDlWithSpecifiedAddress()
    {
        $this->module->createDistributionListOnZimbra('foo@bar.com', []);
        $this->zasa->shouldHaveReceived('createDl')->with('foo@bar.com', m::any(), m::any());
    }
}
