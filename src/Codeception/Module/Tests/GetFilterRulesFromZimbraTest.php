<?php

namespace Codeception\Module\Tests;

class GetFilterRulesFromZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function callsGetFilterRulesOnZimbraConnectorOnce()
    {
        $this->module->getFilterRulesFromZimbra(null);
        $this->zasa->shouldHaveReceived('getFilterRules')->once();
    }
}
