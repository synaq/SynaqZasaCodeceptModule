<?php

namespace Codeception\Module\Tests;

class SeeLinkedFolderTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function passesIfALinkedFolderToTheGivenAccountExists()
    {
        $this->module->_setResult([
            'name' => 'USER_ROOT',
            'absolute_path' => '/',
            'link_target' => null,
            'children' => [
                [
                    'name' => 'Archive',
                    'absolute_path' => '/Archive',
                    'link_target' => 'bar@bar.com.archive',
                    'children' => []
                ]
            ]
        ]);

        $this->module->seeLinkedFolder('/Archive', 'bar@bar.com.archive');
    }

    /**
     * @test
     */
    public function failsIfALinkedFolderToTheGivenAccountDoesNotExist()
    {
        $this->module->_setResult([
            'name' => 'USER_ROOT',
            'absolute_path' => '/',
            'link_target' => null,
            'children' => [
                [
                    'name' => 'Archive',
                    'absolute_path' => '/Archive',
                    'link_target' => null,
                    'children' => []
                ]
            ]
        ]);

        $this->setExpectedException(\PHPUnit_Framework_ExpectationFailedException::class, 'I do not see a link from the folder /Archive to bar@bar.com.archive');
        $this->module->seeLinkedFolder('/Archive', 'bar@bar.com.archive');
    }
}
