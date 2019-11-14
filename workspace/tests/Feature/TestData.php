<?php

namespace Tests\Feature;

class TestData
{
    const MEMBER_INDEX = ['_id', 'name', 'ruby', 'post', 'mail', 'api_token', 'password', 'telephone_number', 'secretary', 'stamp_groups', 'department_name', 'is_notification', 'notification_interval', 'is_admin', 'invitations', 'profile_image'];
    const MEMBERS = [
        ['83b5603f-8436-4c93-189e-8387c15f823f', '橋本環奈', 'はしもとかんな', '女優', 'hashikann@discovery-n.co.jp', 'EgGvxAr4Wm97jGg1VNitMGj5JFovqhTZEDSIssnmkiFF6Sp0anJ5v07nLeHQ', '$2y$10$MPEgFZgwoRLZ3idAD4Oo9uSO2kGWl33o4QOvVIPU5Cu8z2TXQBMvS'/* 19990203 */, '080-0000-0000', [], [], '東京笑門会', true, '1h', false, [], 'test01'],
        ['a08999b6-c1ff-a0e7-81cb-d04e2466b61d', '井手上漠', 'いでがみばく', 'モデル', 'baaaakuuuu@discovery-n.co.jp', 'uq5VaRjvWwAZ1yx8KiB4vdfdD31QXuVrMBpySn3XajnuzMkkhAKfD49WEBQp', '$2y$10$Pgtc5Lh7D6esT9NLzonfx.xuf1UXl8XWbFAF91NuRa6kwaQN7Olfe'/* 20030120 */, '080-0000-0001', ['name' => '井手上秘書男', 'mail' => 'bakuhisyo@discovery-n.co.jp'], [], '東京笑門会', false, '5h', false, [], 'test02'],
        ['8a488ce6-dbd0-3b66-4570-981dfe0b7641', '亜戸明', 'あどみん', '管理者', 'admin@admin.com', '9MjKUP0pkkwcCbFgxPWtO5TYXKJ1KoqB7vzVgg8PriwOtekpPrloqmPAssPQ', '$2y$10$b7CtSFHuH6Af8FFrNhqotuN.AT7fdMI.8T6byBkkDYenJ2zXI5qxG'/* hogehoge */, '070-0000-0000', [], [], '愛媛笑門会', true, '0.5h', true, [], 'test03']
    ];

    const COMPANY_INDEX = ['_id', 'name', 'address', 'telephone_number', 'members'];
    const COMPANIES = [
        ['e6a91e70-bae6-08e0-8ee7-0a7f595f30fc', '株式会社 ディスカバリー･ネクスト', '東京都渋谷区神宮前6-23-2 第25SYビル4F', '03-6427-1408', ['83b5603f-8436-4c93-189e-8387c15f823f', 'a08999b6-c1ff-a0e7-81cb-d04e2466b61d']],
        ['67653c1a-6036-b2cd-0434-f1f21c024a86', '管理者コーポレーション', '愛媛県松山市今市', '089-0000-0000', ['8a488ce6-dbd0-3b66-4570-981dfe0b7641']],
        ['da192210-b876-0b59-1a96-095d2ef2dd11', '有限会社 テスト', '鎌倉の某所', '0467-0000-0000', []]
    ];

    const DEPARTMENT_CHAT_ROOM_INDEX = ['_id', 'group_name', 'admin_member_id', 'contents', 'chat_room_image'];
    const DEPARTMENT_CHAT_ROOMS = [
        ['feeee66d-695b-7eeb-78a5-7e373fcfce71', '愛媛笑門会', '8a488ce6-dbd0-3b66-4570-981dfe0b7641', [], 'testehime'],
        ['1e7e362e-531b-41a7-1ac1-2d13bd90673b', '鎌倉笑門会', '8a488ce6-dbd0-3b66-4570-981dfe0b7641', [], 'testkamakura'],
        ['367d0bee-ded1-46e5-f05d-5c9720b9a54e', '東京笑門会', '8a488ce6-dbd0-3b66-4570-981dfe0b7641', [], 'testtokyo'],
        ['18283bc6-0b2e-6aa7-e6b1-04a2ec773a46', '大阪笑門会', '8a488ce6-dbd0-3b66-4570-981dfe0b7641', [], 'testosaka']
    ];

    const PERSONAL_CHAT_ROOM_INDEX = ['_id', 'members._id1', 'members._id2', 'contents'];
    const PERSONAL_CHAT_ROOMS = [
        ['6f7dd1ad-df0b-33e1-8ba8-5e229b34386f', '83b5603f-8436-4c93-189e-8387c15f823f', 'a08999b6-c1ff-a0e7-81cb-d04e2466b61d', []],
        ['6597f39d-8676-c123-7a17-5a6858b3f55a', '83b5603f-8436-4c93-189e-8387c15f823f', '8a488ce6-dbd0-3b66-4570-981dfe0b7641', []],
        ['6edc6ccd-4177-00c6-cdca-277c59ece21e', 'a08999b6-c1ff-a0e7-81cb-d04e2466b61d', '8a488ce6-dbd0-3b66-4570-981dfe0b7641', []]
    ];

    public static function getMemberField($member, $field)
    {
        return $member[array_search($field, self::MEMBER_INDEX)];
    }
    public static function getCompanyField($company, $field)
    {
        return $company[array_search($field, self::COMPANY_INDEX)];
    }
    public static function getDepartmentChatRoomField($departmentChatRoom, $field)
    {
        return $departmentChatRoom[array_search($field, self::DEPARTMENT_CHAT_ROOM_INDEX)];
    }
    public static function getPersonalChatRoomField($personalChatRoom, $field)
    {
        return $personalChatRoom[array_search($field, self::PERSONAL_CHAT_ROOM_INDEX)];
    }

    public static function getMember($members, $id)
    {
        foreach ($members as $idx => $member) {
            if (strcmp(self::getMemberField($member, '_id'), $id) === 0) {
                return $member;
            }
        }
    }

    public static function getGeneralMembers($members)
    {
        $generalMembers = [];
        foreach ($members as $idx => $member) {
            if (!self::getMemberField($member, 'is_admin')) {
                $generalMembers[] = $member;
            }
        }
        return $generalMembers;
    }

    public static function getCompanyWithMemberId($companies, $memberId)
    {
        foreach ($companies as $idx => $company) {
            if (array_search($memberId, self::getCompanyField($company, 'members'), true) !== FALSE) {
                return $company;
            }
        }
    }
}
