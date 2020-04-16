<?php

namespace Codeception\Module\Tests;

class DeleteDistributionListOnZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function callsGetDlIdWithEmailAddress()
    {
        $this->module->deleteDistributionListOnZimbra('foo@bar.com');
        $this->zasa->shouldHaveReceived('getDlId')->with('foo@bar.com')->once();
    }
}