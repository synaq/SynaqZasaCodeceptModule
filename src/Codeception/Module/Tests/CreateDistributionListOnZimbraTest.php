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
        $this->module->createDistributionListOnZimbra(null, [], []);
        $this->zasa->shouldHaveReceived('createDl')->once();
    }

    /**
     * @test
     */
    public function callsCreateDlWithSpecifiedAddress()
    {
        $this->module->createDistributionListOnZimbra('foo@bar.com', [], []);
        $this->zasa->shouldHaveReceived('createDl')->with('foo@bar.com', m::any(), m::any());
    }

    /**
     * @test
     */
    public function acceptsAnyAddressForDl()
    {
        $this->module->createDistributionListOnZimbra('bar@baz.com', [], []);
        $this->zasa->shouldHaveReceived('createDl')->with('bar@baz.com', m::any(), m::any());
    }

    /**
     * @test
     */
    public function passesGivenAttributesToZimbra()
    {
        $this->module->createDistributionListOnZimbra(null, ['zimbraFoo' => 'zimbraBar'], []);
        $this->zasa->shouldHaveReceived('createDl')->with(m::any(), ['zimbraFoo' => 'zimbraBar'], m::any());
    }

    /**
     * @test
     */
    public function acceptsAnyAttributes()
    {
        $this->module->createDistributionListOnZimbra(null, ['zimbraBar' => 'baz'], []);
        $this->zasa->shouldHaveReceived('createDl')->with(m::any(), ['zimbraBar' => 'baz'], m::any());
    }

    /**
     * @test
     */
    public function passesAnEmptyArrayForViews()
    {
        $this->module->createDistributionListOnZimbra(null, [], []);
        $this->zasa->shouldHaveReceived('createDl')->with(m::any(), m::any(), []);
    }

    /**
     * @test
     */
    public function callsAddDlMemberForEachMember()
    {
        $this->module->createDistributionListOnZimbra(null, [], ['foo@bar.com', 'bar@bar.com']);
        $this->zasa->shouldHaveReceived('addDlMember')->twice();
    }

    /**
     * @test
     */
    public function onlyCallsAddDlMemberForActualMembersPassed()
    {
        $this->module->createDistributionListOnZimbra(null, [], ['foo@bar.com']);
        $this->zasa->shouldHaveReceived('addDlMember')->once();
    }

    /**
     * @test
     */
    public function callsAddDlMemberWithTheIdReturnedFromZimbra()
    {
        $this->zasa->shouldReceive('createDl')->andReturn('some-dl-id');
        $this->module->createDistributionListOnZimbra(null, [], ['foo@bar.com']);
        $this->zasa->shouldHaveReceived('addDlMember')->with('some-dl-id', m::any());
    }
}
