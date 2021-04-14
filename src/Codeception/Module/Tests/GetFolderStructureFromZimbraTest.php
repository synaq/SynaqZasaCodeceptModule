<?php

namespace Codeception\Module\Tests;

class GetFolderStructureFromZimbraTest extends ZasaModuleTestCase
{
    /**
     * @test
     */
    public function callsGetFoldersOnZimbraConnectorOnce()
    {
        $this->module->getFolderStructureFromZimbra(null);
        $this->zasa->shouldHaveReceived('getFolders')->once();
    }

    /**
     * @test
     */
    public function callsGetFoldersWithGivenAccountName()
    {
        $this->module->getFolderStructureFromZimbra('foo@bar.com');
        $this->zasa->shouldHaveReceived('getFolders')->with('foo@bar.com');
    }

    /**
     * @test
     */
    public function acceptsAnyAccountName()
    {
        $this->module->getFolderStructureFromZimbra('bar@baz.com');
        $this->zasa->shouldHaveReceived('getFolders')->with('bar@baz.com');
    }

    /**
     * @test
     */
    public function mapsFoldersAndLinksToResultAsASimplifiedArray()
    {
        $this->module->getFolderStructureFromZimbra(null);
        $result = $this->module->grabResultFromZimbra();
        $this->assertEquals([
            'name' => 'USER_ROOT',
            'absolute_path' => '/',
            'link_target' => null,
            'children' => [
                [
                    'name' => 'Calendar',
                    'absolute_path' => '/Calendar',
                    'link_target' => null,
                    'children' => []
                ],
                [
                    'name' => 'Briefcase',
                    'absolute_path' => '/Briefcase',
                    'link_target' => null,
                    'children' => []
                ],
                [
                    'name' => 'Chats',
                    'absolute_path' => '/Chats',
                    'link_target' => null,
                    'children' => []
                ],
                [
                    'name' => 'Contacts',
                    'absolute_path' => '/Contacts',
                    'link_target' => null,
                    'children' => []
                ],
                [
                    'name' => 'Drafts',
                    'absolute_path' => '/Drafts',
                    'link_target' => null,
                    'children' => []
                ],
                [
                    'name' => 'Emailed Contacts',
                    'absolute_path' => '/Emailed Contacts',
                    'link_target' => null,
                    'children' => []
                ],
                [
                    'name' => 'Inbox',
                    'absolute_path' => '/Inbox',
                    'link_target' => null,
                    'children' => []
                ],
                [
                    'name' => 'Junk',
                    'absolute_path' => '/Junk',
                    'link_target' => null,
                    'children' => []
                ],
                [
                    'name' => 'Sent',
                    'absolute_path' => '/Sent',
                    'link_target' => null,
                    'children' => []
                ],
                [
                    'name' => 'Tasks',
                    'absolute_path' => '/Tasks',
                    'link_target' => null,
                    'children' => []
                ],
                [
                    'name' => 'Trash',
                    'absolute_path' => '/Trash',
                    'link_target' => null,
                    'children' => []
                ],
                [
                    'name' => 'Archive',
                    'absolute_path' => '/Archive',
                    'link_target' => 'bar@bar.com.archive',
                    'children' => []
                ],
                [
                    'name' => 'Archive_bar',
                    'absolute_path' => '/Archive_bar',
                    'link_target' => 'bar@bar.com.archive',
                    'children' => []
                ],
            ]
        ], $result);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->zasa->shouldReceive('getFolders')->andReturn($this->defaultFolderResponse())->byDefault();
    }

    private function defaultFolderResponse()
    {
        return [
            'folder' =>
                [
                    'link' =>
                        [
                            0 =>
                                [
                                    '@value' => '',
                                    '@attributes' =>
                                        [
                                            'owner' => 'bar.bar@bar.com.archive',
                                            'rev' => '2',
                                            'reminder' => '0',
                                            'ms' => '2',
                                            'deletable' => '1',
                                            'l' => '1',
                                            'rid' => '2',
                                            'uuid' => '043834dd-d81b-4be9-8d52-406dbe7c51e5',
                                            'luuid' => '9816e1c1-e7a3-4ad2-a52b-8890b616cae5',
                                            'ruuid' => '6f401912-76c2-4067-810b-7b8cd5499377',
                                            'activesyncdisabled' => '0',
                                            'absFolderPath' => '/Archive',
                                            'view' => 'message',
                                            'zid' => '1d072d9d-6b03-4611-a867-e52f7335adaa',
                                            'name' => 'Archive',
                                            'id' => '257',
                                            'webOfflineSyncDays' => '0',
                                        ],
                                ],
                            1 =>
                                [
                                    '@value' => '',
                                    '@attributes' =>
                                        [
                                            'owner' => 'bar.bar@bar.com.archive',
                                            'rev' => '3',
                                            'reminder' => '0',
                                            'ms' => '3',
                                            'deletable' => '1',
                                            'l' => '1',
                                            'rid' => '2',
                                            'uuid' => '5ca5a918-eefa-4619-88b0-c91fe26a0d31',
                                            'luuid' => '9816e1c1-e7a3-4ad2-a52b-8890b616cae5',
                                            'ruuid' => '6f401912-76c2-4067-810b-7b8cd5499377',
                                            'activesyncdisabled' => '0',
                                            'absFolderPath' => '/Archive_bar',
                                            'view' => 'message',
                                            'zid' => '1d072d9d-6b03-4611-a867-e52f7335adaa',
                                            'name' => 'Archive_bar',
                                            'id' => '258',
                                            'webOfflineSyncDays' => '0',
                                        ],
                                ],
                        ],
                    'folder' =>
                        [
                            0 =>
                                [
                                    '@value' => '',
                                    '@attributes' =>
                                        [
                                            'i4ms' => '1',
                                            'rev' => '1',
                                            'i4next' => '17',
                                            'ms' => '1',
                                            'deletable' => '0',
                                            'l' => '1',
                                            'uuid' => 'b4e9fc7d-1561-4ce7-b31a-5f7bd4f452b8',
                                            'n' => '0',
                                            'luuid' => '9816e1c1-e7a3-4ad2-a52b-8890b616cae5',
                                            'activesyncdisabled' => '0',
                                            'absFolderPath' => '/Briefcase',
                                            'view' => 'document',
                                            's' => '0',
                                            'name' => 'Briefcase',
                                            'id' => '16',
                                            'webOfflineSyncDays' => '0',
                                        ],
                                ],
                            1 =>
                                [
                                    '@value' => '',
                                    '@attributes' =>
                                        [
                                            'i4ms' => '1',
                                            'rev' => '1',
                                            'i4next' => '11',
                                            'f' => '#',
                                            'ms' => '1',
                                            'deletable' => '0',
                                            'l' => '1',
                                            'uuid' => 'a2bc7360-e3a7-4077-ae14-23d76c40d2e5',
                                            'n' => '0',
                                            'luuid' => '9816e1c1-e7a3-4ad2-a52b-8890b616cae5',
                                            'activesyncdisabled' => '0',
                                            'absFolderPath' => '/Calendar',
                                            'view' => 'appointment',
                                            's' => '0',
                                            'name' => 'Calendar',
                                            'id' => '10',
                                            'webOfflineSyncDays' => '0',
                                        ],
                                ],
                            2 =>
                                [
                                    '@value' => '',
                                    '@attributes' =>
                                        [
                                            'i4ms' => '1',
                                            'rev' => '1',
                                            'i4next' => '15',
                                            'ms' => '1',
                                            'deletable' => '0',
                                            'l' => '1',
                                            'uuid' => '5ce96d6c-118f-481a-997c-c2fbf386a072',
                                            'n' => '0',
                                            'luuid' => '9816e1c1-e7a3-4ad2-a52b-8890b616cae5',
                                            'activesyncdisabled' => '0',
                                            'absFolderPath' => '/Chats',
                                            'view' => 'message',
                                            's' => '0',
                                            'name' => 'Chats',
                                            'id' => '14',
                                            'webOfflineSyncDays' => '0',
                                        ],
                                ],
                            3 =>
                                [
                                    '@value' => '',
                                    '@attributes' =>
                                        [
                                            'i4ms' => '1',
                                            'rev' => '1',
                                            'i4next' => '8',
                                            'ms' => '1',
                                            'deletable' => '0',
                                            'l' => '1',
                                            'uuid' => '62135e54-db3c-4378-9783-706766cdfafd',
                                            'n' => '0',
                                            'luuid' => '9816e1c1-e7a3-4ad2-a52b-8890b616cae5',
                                            'activesyncdisabled' => '0',
                                            'absFolderPath' => '/Contacts',
                                            'view' => 'contact',
                                            's' => '0',
                                            'name' => 'Contacts',
                                            'id' => '7',
                                            'webOfflineSyncDays' => '0',
                                        ],
                                ],
                            4 =>
                                [
                                    '@value' => '',
                                    '@attributes' =>
                                        [
                                            'i4ms' => '1',
                                            'rev' => '1',
                                            'i4next' => '7',
                                            'ms' => '1',
                                            'deletable' => '0',
                                            'l' => '1',
                                            'uuid' => 'f2bc4cf7-1b31-46f9-b2bb-a1ee384ad6d9',
                                            'n' => '0',
                                            'luuid' => '9816e1c1-e7a3-4ad2-a52b-8890b616cae5',
                                            'activesyncdisabled' => '0',
                                            'absFolderPath' => '/Drafts',
                                            'view' => 'message',
                                            's' => '0',
                                            'name' => 'Drafts',
                                            'id' => '6',
                                            'webOfflineSyncDays' => '30',
                                        ],
                                ],
                            5 =>
                                [
                                    '@value' => '',
                                    '@attributes' =>
                                        [
                                            'i4ms' => '1',
                                            'rev' => '1',
                                            'i4next' => '14',
                                            'ms' => '1',
                                            'deletable' => '0',
                                            'l' => '1',
                                            'uuid' => '7a7921b1-53a7-435e-a1fc-9079989d3d1b',
                                            'n' => '0',
                                            'luuid' => '9816e1c1-e7a3-4ad2-a52b-8890b616cae5',
                                            'activesyncdisabled' => '0',
                                            'absFolderPath' => '/Emailed Contacts',
                                            'view' => 'contact',
                                            's' => '0',
                                            'name' => 'Emailed Contacts',
                                            'id' => '13',
                                            'webOfflineSyncDays' => '0',
                                        ],
                                ],
                            6 =>
                                [
                                    '@value' => '',
                                    '@attributes' =>
                                        [
                                            'i4ms' => '1',
                                            'rev' => '1',
                                            'i4next' => '3',
                                            'ms' => '1',
                                            'deletable' => '0',
                                            'l' => '1',
                                            'uuid' => 'f6fdc8d8-d706-42c7-84da-b79f61166f4e',
                                            'n' => '0',
                                            'luuid' => '9816e1c1-e7a3-4ad2-a52b-8890b616cae5',
                                            'activesyncdisabled' => '0',
                                            'absFolderPath' => '/Inbox',
                                            'view' => 'message',
                                            's' => '0',
                                            'name' => 'Inbox',
                                            'id' => '2',
                                            'webOfflineSyncDays' => '30',
                                        ],
                                ],
                            7 =>
                                [
                                    '@value' => '',
                                    '@attributes' =>
                                        [
                                            'i4ms' => '1',
                                            'rev' => '1',
                                            'i4next' => '5',
                                            'ms' => '1',
                                            'deletable' => '0',
                                            'l' => '1',
                                            'uuid' => 'f1f46241-a91f-4839-bf44-2f8cba26fb22',
                                            'n' => '0',
                                            'luuid' => '9816e1c1-e7a3-4ad2-a52b-8890b616cae5',
                                            'activesyncdisabled' => '0',
                                            'absFolderPath' => '/Junk',
                                            'view' => 'message',
                                            's' => '0',
                                            'name' => 'Junk',
                                            'id' => '4',
                                            'webOfflineSyncDays' => '0',
                                        ],
                                ],
                            8 =>
                                [
                                    '@value' => '',
                                    '@attributes' =>
                                        [
                                            'i4ms' => '1',
                                            'rev' => '1',
                                            'i4next' => '6',
                                            'ms' => '1',
                                            'deletable' => '0',
                                            'l' => '1',
                                            'uuid' => '70878c3f-426c-47ea-9fc6-ea6696f14a09',
                                            'n' => '0',
                                            'luuid' => '9816e1c1-e7a3-4ad2-a52b-8890b616cae5',
                                            'activesyncdisabled' => '0',
                                            'absFolderPath' => '/Sent',
                                            'view' => 'message',
                                            's' => '0',
                                            'name' => 'Sent',
                                            'id' => '5',
                                            'webOfflineSyncDays' => '30',
                                        ],
                                ],
                            9 =>
                                [
                                    '@value' => '',
                                    '@attributes' =>
                                        [
                                            'i4ms' => '1',
                                            'rev' => '1',
                                            'i4next' => '16',
                                            'f' => '#',
                                            'ms' => '1',
                                            'deletable' => '0',
                                            'l' => '1',
                                            'uuid' => '0e5ca363-1335-45a5-a008-17ee5d8c7f65',
                                            'n' => '0',
                                            'luuid' => '9816e1c1-e7a3-4ad2-a52b-8890b616cae5',
                                            'activesyncdisabled' => '0',
                                            'absFolderPath' => '/Tasks',
                                            'view' => 'task',
                                            's' => '0',
                                            'name' => 'Tasks',
                                            'id' => '15',
                                            'webOfflineSyncDays' => '0',
                                        ],
                                ],
                            10 =>
                                [
                                    '@value' => '',
                                    '@attributes' =>
                                        [
                                            'i4ms' => '1',
                                            'rev' => '1',
                                            'i4next' => '4',
                                            'ms' => '1',
                                            'deletable' => '0',
                                            'l' => '1',
                                            'uuid' => 'e8801c16-902f-4462-94ad-a6df33e789dc',
                                            'n' => '0',
                                            'luuid' => '9816e1c1-e7a3-4ad2-a52b-8890b616cae5',
                                            'activesyncdisabled' => '0',
                                            'absFolderPath' => '/Trash',
                                            's' => '0',
                                            'name' => 'Trash',
                                            'id' => '3',
                                            'webOfflineSyncDays' => '30',
                                        ],
                                ],
                        ],
                    '@attributes' =>
                        [
                            'i4ms' => '1',
                            'rev' => '1',
                            'i4next' => '2',
                            'ms' => '1',
                            'deletable' => '0',
                            'l' => '11',
                            'uuid' => '9816e1c1-e7a3-4ad2-a52b-8890b616cae5',
                            'n' => '0',
                            'luuid' => 'a884e761-8002-4491-9ed9-5085139c214c',
                            'activesyncdisabled' => '0',
                            'absFolderPath' => '/',
                            's' => '0',
                            'name' => 'USER_ROOT',
                            'id' => '1',
                            'webOfflineSyncDays' => '0',
                        ],
                ],
        ];
    }
}
