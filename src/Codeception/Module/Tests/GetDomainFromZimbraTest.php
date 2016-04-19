<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 2016/04/19
 * Time: 10:22
 */

namespace Codeception\Module\Tests;


class GetDomainFromZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function shouldCallGetDomainOnZasaConnectorWithDomainName()
    {
        $this->module->getDomainFromZimbra('domain-name.com');
        $this->zasa->shouldHaveReceived('getDomain')->with('domain-name.com');
    }

    /**
     * @test
     */
    public function shouldSetResultReturnedFromZimbraAsLatestResultInModule()
    {
        $this->zasa->shouldReceive('getDomain')->andReturn(['id' => 'returned-domain-id']);
        $this->module->getDomainFromZimbra(null);
        $result = $this->module->grabResultFromZimbra();
        $this->assertEquals('returned-domain-id', $result['id']);
    }
}
