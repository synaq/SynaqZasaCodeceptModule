<?php

namespace Codeception\Module\Tests;

class CreateCalendarResourceOnZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function createsCalendarResourceOnce()
    {
        $this->module->createCalendarResourceOnZimbra(null);
        $this->zasa->shouldHaveReceived('createCalendarResource')->once();
    }
}
