<?php
/**
 * Created by PhpStorm.
 * User: nicholasp
 * Date: 2016/05/18
 * Time: 11:09 AM
 */

namespace Codeception\Module\Tests;


class DeleteDomainOnZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function shouldGetDomainIdFromZasa()
    {
        $this->module->deleteDomainOnZimbra('example.com');
        $this->zasa->shouldHaveReceived('getDomainId')->with('example.com')->once();
    }

    /**
     * @test
     */
    public function shouldCallDeleteDomainOnZasaWithIdReturnedFromGetDomainId()
    {
        $this->module->deleteDomainOnZimbra(null);
        $this->zasa->shouldHaveReceived('deleteDomain')->with('sample-domain-id')->once();
    }

    protected function setUp()
    {
        parent::setUp();
        $this->zasa->shouldReceive('getDomainId')->andReturn('sample-domain-id');
    }
}
