<?php

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Company;
use App\Models\ChatRoom;
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
        $members = TestData::MEMBERS;
        $companies = TestData::COMPANIES;
        $departmentChatRooms = TestData::DEPARTMENT_CHAT_ROOMS;
        $personalChatRooms = TestData::PERSONAL_CHAT_ROOMS;

        foreach ($members as $idx => $member) {
            Member::create([
                '_id' => TestData::getMemberField($member, '_id'),
                'name' => TestData::getMemberField($member, 'name'),
                'ruby' => TestData::getMemberField($member, 'ruby'),
                'post' => TestData::getMemberField($member, 'post'),
                'mail' => TestData::getMemberField($member, 'mail'),
                'api_token' => TestData::getMemberField($member, 'api_token'),
                'password' => TestData::getMemberField($member, 'password'),
                'telephone_number' => TestData::getMemberField($member, 'telephone_number'),
                'secretary' => TestData::getMemberField($member, 'secretary'),
                'stamp_groups' => TestData::getMemberField($member, 'stamp_groups'),
                'department_name' => TestData::getMemberField($member, 'department_name'),
                'is_notification' => TestData::getMemberField($member, 'is_notification'),
                'notification_interval' => TestData::getMemberField($member, 'notification_interval'),
                'is_admin' => TestData::getMemberField($member, 'is_admin'),
                'invitations' => TestData::getMemberField($member, 'invitations')
            ]);
            Storage::putFileAs('private/images/profile_images/', new File('storage/app/images/test/' . TestData::getMemberField($member, 'profile_image') . '.png'), TestData::getMemberField($member, '_id') . '.png', 'private');
        }

        foreach ($companies as $idx => $company) {
            Company::create([
                '_id' => TestData::getCompanyField($company, '_id'),
                'name' => TestData::getCompanyField($company, 'name'),
                'address' => TestData::getCompanyField($company, 'address'),
                'telephone_number' => TestData::getCompanyField($company, 'telephone_number'),
                'members' => TestData::getCompanyField($company, 'members')
            ]);
        }

        foreach ($departmentChatRooms as $idx => $departmentChatRoom) {
            $chatRoomMembers = [];
            foreach ($members as $gmidx => $member) {
                if (strcmp(TestData::getDepartmentChatRoomField($departmentChatRoom, 'group_name'), TestData::getMemberField($member, 'department_name')) === 0 || TestData::getMemberField($member, 'is_admin')) {
                    $chatRoomMembers[] = ['_id' => TestData::getMemberField($member, '_id'), 'name' => TestData::getMemberField($member, 'name')];
                }
            }
            ChatRoom::create([
                '_id' => TestData::getDepartmentChatRoomField($departmentChatRoom, '_id'),
                'is_group' => true,
                'is_department' => true,
                'group_name' => TestData::getDepartmentChatRoomField($departmentChatRoom, 'group_name'),
                'admin_member_id' => TestData::getDepartmentChatRoomField($departmentChatRoom, 'admin_member_id'),
                'members' => $chatRoomMembers,
                'contents' => TestData::getDepartmentChatRoomField($departmentChatRoom, 'contents')
            ]);
            Storage::putFileAs('private/images/chats', new File('storage/app/images/test/' . TestData::getDepartmentChatRoomField($departmentChatRoom, 'chat_room_image') . '.png'), TestData::getDepartmentChatRoomField($departmentChatRoom, '_id') . '.png', 'private');
        }
        foreach ($personalChatRooms as $idx => $personalChatRoom) {
            ChatRoom::create([
                '_id' => TestData::getPersonalChatRoomField($personalChatRoom, '_id'),
                'is_group' => false,
                'is_department' => false,
                'members' => [['_id' => TestData::getPersonalChatRoomField($personalChatRoom, 'members._id1'), 'name' => TestData::getMemberField(TestData::getMember($members, TestData::getPersonalChatRoomField($personalChatRoom, 'members._id1')), 'name')], ['_id' => TestData::getPersonalChatRoomField($personalChatRoom, 'members._id2'), 'name' => TestData::getMemberField(TestData::getMember($members, TestData::getPersonalChatRoomField($personalChatRoom, 'members._id2')), 'name')]],
                'contents' => TestData::getPersonalChatRoomField($personalChatRoom, 'contents')
            ]);
        }
    }
}
