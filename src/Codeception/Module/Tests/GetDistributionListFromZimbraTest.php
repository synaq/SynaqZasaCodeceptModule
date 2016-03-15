<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 2016/03/10
 * Time: 07:48
 */

namespace Codeception\Module\Tests;


class GetDistributionListFromZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function shouldCallGetDlOnZasaConnectorWithEmailAddress()
    {
        $this->module->getDistributionListFromZimbra('example@example.com');
        $this->zasa->shouldHaveReceived('getDl')->with('example@example.com')->once();
    }

    /**
     * @test
     */
    public function shouldReturnAttributesFromZimbraConnector()
    {
        $this->zasa->shouldReceive('getDl')->andReturn([
            'id' => 'dummy-dl-id'
        ]);
        $this->module->getDistributionListFromZimbra(null);
        $dl = $this->module->grabResultFromZimbra();
        $this->assertEquals('dummy-dl-id', $dl['id']);
    }
}