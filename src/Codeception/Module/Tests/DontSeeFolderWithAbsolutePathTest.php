<?php

namespace Codeception\Module\Tests;

class DontSeeFolderWithAbsolutePathTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function failsIfFolderWithTheGivenAbsolutePathExists()
    {
        $this->module->_setResult([
            'name' => 'USER_ROOT',
            'absolute_path' => '/',
            'link_target' => null,
            'children' => [
                [
                    'name' => 'Inbox',
                    'absolute_path' => '/Inbox',
                    'link_target' => null,
                    'children' => []
                ]
            ]
        ]);

        $this->setExpectedException(\PHPUnit_Framework_ExpectationFailedException::class, 'I see the folder /Inbox');
        $this->module->dontSeeFolderWithAbsolutePath('/Inbox');
    }
}
