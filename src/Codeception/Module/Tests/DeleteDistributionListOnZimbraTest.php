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
        $this->zasa->shouldHaveReceived('getDlId')->with('foo@bar.com');
    }

    /**
     * @test
     */
    public function acceptsAnyDlEmailAddress()
    {
        $this->module->deleteDistributionListOnZimbra('bar@baz.com');
        $this->zasa->shouldHaveReceived('getDlId')->with('bar@baz.com');
    }

    /**
     * @test
     */
    public function callsDeleteDlWithTheReturnedId()
    {
        $this->zasa->shouldReceive('getDlId')->andReturn('some-dl-id');
        $this->module->deleteDistributionListOnZimbra(null);
        $this->zasa->shouldHaveReceived('deleteDl')->with('some-dl-id');
    }

    /**
     * @test
     */
    public function acceptsAnyReturnedId()
    {
        $this->zasa->shouldReceive('getDlId')->andReturn('any-dl-id');
        $this->module->deleteDistributionListOnZimbra(null);
        $this->zasa->shouldHaveReceived('deleteDl')->with('any-dl-id');
    }
}