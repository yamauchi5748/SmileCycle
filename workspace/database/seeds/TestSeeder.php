<?php

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Company;
use App\Models\ChatRoom;
use App\Models\StampGroup;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Tests\Feature\TestData;

class TestSeeder extends Seeder
{
    /**
     * Run the test data seeds.
     *
     * @return void
     */
    public function run()
    {
        $members = TestData::getMembers();
        $companies = TestData::getCompanies();
        $departmentChatRooms = TestData::getDepartmentChatRooms();
        $personalChatRooms = TestData::getPersonalChatRooms();
        $stampGroups = TestData::getStampGroups();

        foreach ($members as $idx => $member) {
            Member::create([
                '_id' => $member['_id'],
                'name' => $member['name'],
                'ruby' => $member['ruby'],
                'post' => $member['post'],
                'mail' => $member['mail'],
                'api_token' => $member['api_token'],
                'password' => $member['password'],
                'telephone_number' => $member['telephone_number'],
                'secretary' => $member['secretary'],
                'stamp_groups' => $member['stamp_groups'],
                'department_name' => $member['department_name'],
                'is_notification' => $member['is_notification'],
                'notification_interval' => $member['notification_interval'],
                'is_admin' => $member['is_admin'],
                'invitations' => $member['invitations']
            ]);
            Storage::putFileAs('private/images/profile_images/', new File('storage/app/images/test/' . $member['profile_image'] . '.png'), $member['_id'] . '.png', 'private');
        }

        foreach ($companies as $idx => $company) {
            Company::create([
                '_id' => $company['_id'],
                'name' => $company['name'],
                'address' => $company['address'],
                'telephone_number' => $company['telephone_number'],
                'members' => $company['members']
            ]);
        }

        foreach ($departmentChatRooms as $idx => $departmentChatRoom) {
            $chatRoomMembers = [];
            foreach ($members as $gmidx => $member) {
                if (strcmp($departmentChatRoom['group_name'], $member['department_name']) === 0 || $member['is_admin'] === 1) {
                    $chatRoomMembers[] = ['_id' => $member['_id'], 'name' => $member['name']];
                }
            }
            ChatRoom::create([
                '_id' => $departmentChatRoom['_id'],
                'is_group' => 1,
                'is_department' => 1,
                'group_name' => $departmentChatRoom['group_name'],
                'admin_member_id' => $departmentChatRoom['admin_member_id'],
                'members' => $chatRoomMembers,
                'contents' => $departmentChatRoom['contents']
            ]);
            Storage::putFileAs('private/images/chats', new File('storage/app/images/test/' . $departmentChatRoom['chat_room_image'] . '.png'), $departmentChatRoom['_id'] . '.png', 'private');
        }
        foreach ($personalChatRooms as $idx => $personalChatRoom) {
            ChatRoom::create([
                '_id' => $personalChatRoom['_id'],
                'is_group' => 0,
                'is_department' => 0,
                'members' => [['_id' => $personalChatRoom['_id1'], 'name' => TestData::getMember($members, $personalChatRoom['_id1'])['name']], ['_id' => $personalChatRoom['_id2'], 'name' => TestData::getMember($members, $personalChatRoom['_id2'])['name']]],
                'contents' => $personalChatRoom['contents']
            ]);
        }

        foreach ($stampGroups as $idx => $stampGroup) {
            StampGroup::create([
                '_id' => $stampGroup['_id'],
                'tab_image_id' => $stampGroup['tab_image_id'],
                'is_all' => $stampGroup['is_all'],
                'stamps' => $stampGroup['stamps'],
                'members' => $stampGroup['is_all'] === 1 ? array_column($members, '_id') : $stampGroup['members']
            ]);
            Storage::putFileAs('private/images/stamps', new File('storage/app/images/test/' . $stampGroup['tab_image'] . '.png'), $stampGroup['tab_image_id'] . '.png', 'private');
            foreach ($stampGroup['stamps'] as $idx2 => $stampId ) {
                Storage::putFileAs('private/images/stamps', new File('storage/app/images/test/' . $stampGroup['stamps_image'][$idx2] . '.png'), $stampId . '.png', 'private');
            }
        }
    }
}
