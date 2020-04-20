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
}
