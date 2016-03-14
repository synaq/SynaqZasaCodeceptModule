<?php
/**
 * Created by PhpStorm.
 * User: willemv
 * Date: 15/04/20
 * Time: 16:36
 */

namespace Codeception\Module\Tests;

use \Mockery as m;

/**
 * Class ModifyAccountOnZimbraTest
 * @package Codeception\Module
 */
class ModifyAccountOnZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function shouldCallGetAccountIdOnZasaConnectorWithEmailAddress()
    {
        $this->module->modifyAccountOnZimbra('example@example.com', []);
        $this->zasa->shouldHaveReceived('getAccountId')->with('example@example.com')->once();
    }

    /**
     * @test
     */
    public function shouldCallModifyAccountWithIdReturnedFromGetAccountId()
    {
        $this->zasa->shouldReceive('getAccountId')->andReturn('example-account-id');
        $this->module->modifyAccountOnZimbra(null, []);
        $this->zasa->shouldHaveReceived('modifyAccount')->with('example-account-id', m::any())->once();
    }

    /**
     * @test
     */
    public function shouldCallModifyAccountWithAttributesArray()
    {
        $attributes = ['exampleKey' => 'Example value'];
        $this->module->modifyAccountOnZimbra(null, $attributes);
        $this->zasa->shouldHaveReceived('modifyAccount')->with(m::any(), $attributes)->once();
    }
}