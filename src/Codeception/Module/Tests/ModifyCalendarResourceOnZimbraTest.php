<?php

namespace Codeception\Module\Tests;

class ModifyCalendarResourceOnZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function modifiesCalendarResourceOnce()
    {
        $this->module->modifyCalendarResourceOnZimbra(null, []);
        $this->zasa->shouldHaveReceived('modifyCalendarResource')->once();
    }
}
