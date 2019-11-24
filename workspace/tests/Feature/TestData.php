<?php

namespace Tests\Feature;

use Illuminate\Support\Str;

class TestData
{
    const MEMBER_INDEX = ['_id', 'name', 'ruby', 'post', 'mail', 'api_token', 'password', 'telephone_number', 'secretary', 'stamp_groups', 'department_name', 'is_notification', 'notification_interval', 'is_admin', 'invitations', 'profile_image'];
    const MEMBERS = [
        ['83b5603f-8436-4c93-189e-8387c15f823f', '橋本環奈', 'はしもとかんな', '女優', 'hashikann@discovery-n.co.jp', 'EgGvxAr4Wm97jGg1VNitMGj5JFovqhTZEDSIssnmkiFF6Sp0anJ5v07nLeHQ', '$2y$10$MPEgFZgwoRLZ3idAD4Oo9uSO2kGWl33o4QOvVIPU5Cu8z2TXQBMvS'/* 19990203 */, '080-0000-0000', [], [], '東京笑門会', 1, '1h', 0, [], 'test01'],
        ['a08999b6-c1ff-a0e7-81cb-d04e2466b61d', '井手上漠', 'いでがみばく', 'モデル', 'baaaakuuuu@discovery-n.co.jp', 'uq5VaRjvWwAZ1yx8KiB4vdfdD31QXuVrMBpySn3XajnuzMkkhAKfD49WEBQp', '$2y$10$Pgtc5Lh7D6esT9NLzonfx.xuf1UXl8XWbFAF91NuRa6kwaQN7Olfe'/* 20030120 */, '080-0000-0001', ['name' => '井手上秘書男', 'mail' => 'bakuhisyo@discovery-n.co.jp'], ['536aef36-44d6-7fb5-ed78-d5cf83325316'], '東京笑門会', 0, '5h', 0, [], 'test02'],
        ['8a488ce6-dbd0-3b66-4570-981dfe0b7641', '亜戸明', 'あどみん', '管理者', 'admin@admin.com', '9MjKUP0pkkwcCbFgxPWtO5TYXKJ1KoqB7vzVgg8PriwOtekpPrloqmPAssPQ', '$2y$10$b7CtSFHuH6Af8FFrNhqotuN.AT7fdMI.8T6byBkkDYenJ2zXI5qxG'/* hogehoge */, '070-0000-0000', [], [], '愛媛笑門会', 1, '0.5h', 1, [], 'test03']
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

    const PERSONAL_CHAT_ROOM_INDEX = ['_id', '_id1', '_id2', 'contents'];
    const PERSONAL_CHAT_ROOMS = [
        ['6f7dd1ad-df0b-33e1-8ba8-5e229b34386f', '83b5603f-8436-4c93-189e-8387c15f823f', 'a08999b6-c1ff-a0e7-81cb-d04e2466b61d', []],
        ['6597f39d-8676-c123-7a17-5a6858b3f55a', '83b5603f-8436-4c93-189e-8387c15f823f', '8a488ce6-dbd0-3b66-4570-981dfe0b7641', []],
        ['6edc6ccd-4177-00c6-cdca-277c59ece21e', 'a08999b6-c1ff-a0e7-81cb-d04e2466b61d', '8a488ce6-dbd0-3b66-4570-981dfe0b7641', []]
    ];

    const STAMP_GROUP_INDEX = ['_id', 'tab_image_id', 'tab_image', 'is_all', 'stamps', 'stamps_image', 'members'];
    const STAMP_GROUPS = [
        ['c620d4cf-bb75-1e3e-486d-c56ac4f956f3', 'bd16357a-2a23-22df-2bcc-c43728f07857', 'stamp01', 1, ['5d49f872-5874-8715-9da8-7ca9b532e446', 'cce909bb-facd-524e-88f5-c68028f5ae6c', '6cb2c578-19c9-5ff3-6c4f-18007a5518db', '7c06b4d0-2c01-7963-7fe6-18f618b685f3', 'f79be5d0-e4f6-603d-7d91-b5c12cfc5ab8', '03962a63-47d7-f098-37d4-b4210f0ff475', '1ccd679d-a0f2-a750-907c-2dda8f461fa0', 'd8edc929-fcb0-29c8-0035-10750da89d75', 'f822532a-7c8c-c27d-2230-ad9ac62113e8', '0620566c-5412-ed0a-be1f-de48b682615d'], ['stamp01', 'stamp02', 'stamp03', 'stamp04', 'stamp05', 'stamp06', 'stamp07', 'stamp08', 'stamp09', 'stamp10'], []],
        ['536aef36-44d6-7fb5-ed78-d5cf83325316', 'c777aa44-18e5-14d6-65ed-ee2c3544fd82', 'stamp11', 0, ['036a3870-54d5-f6d4-ca84-599282f1dab3', '98d2bd87-60a9-6942-8592-9392648e4726', 'db94b6fc-e0d1-647e-9a89-552b106f32af'], ['stamp11', 'stamp12', 'stamp01'], ['a08999b6-c1ff-a0e7-81cb-d04e2466b61d']],
        ['f8d433f6-314d-5187-4040-8dfce404e037', '86f2e72f-95ab-00d6-b08c-ff09d3ea687f', 'stamp02', 1, ['7117c753-ed57-2cc9-c0cd-85bffac25120', 'daf8c5f4-f2ee-c637-0115-d38715f5b6bd'], ['stamp02', 'stamp03'], []]
    ];

    public static function getMembers()
    {
        return self::format(self::MEMBERS, self::MEMBER_INDEX);
    }
    public static function getCompanies()
    {
        return self::format(self::COMPANIES, self::COMPANY_INDEX);
    }
    public static function getDepartmentChatRooms()
    {
        return self::format(self::DEPARTMENT_CHAT_ROOMS, self::DEPARTMENT_CHAT_ROOM_INDEX);
    }
    public static function getPersonalChatRooms()
    {
        return self::format(self::PERSONAL_CHAT_ROOMS, self::PERSONAL_CHAT_ROOM_INDEX);
    }
    public static function getStampGroups()
    {
        return self::format(self::STAMP_GROUPS, self::STAMP_GROUP_INDEX);
    }
    private static function format($data, $dataIndex)
    {
        $result = [];
        foreach ($data as $datum) {
            $format = [];
            foreach ($dataIndex as $idx => $key) {
                $format[$key] = $datum[$idx];
            }
            $result[] = $format;
        }
        return $result;
    }

    // $membersの中から_idが$idの会員を返す
    public static function getMember($members, $id)
    {
        foreach ($members as $idx => $member) {
            if (strcmp($member['_id'], $id) === 0) {
                return $member;
            }
        }
    }

    // $membersの中からランダムで会員を返す
    public static function getRandMember($members)
    {
        return $members[array_rand($members)];
    }
    // $membersの中からランダムで一般会員を返す
    public static function getRandGeneralMember($members)
    {
        return self::getRandMember(self::getGeneralMembers($members));
    }
    // $membersの中からランダムで管理者を返す
    public static function getRandAdminMember($members)
    {
        return self::getRandMember(self::getAdminMembers($members));
    }

    // $membersの中から一般会員を配列で返す
    public static function getGeneralMembers($members)
    {
        $generalMembers = [];
        foreach ($members as $idx => $member) {
            if ($member['is_admin'] === 0) {
                $generalMembers[] = $member;
            }
        }
        return $generalMembers;
    }
    // $membersの中から管理者を配列で返す
    public static function getAdminMembers($members)
    {
        $adminMembers = [];
        foreach ($members as $idx => $member) {
            if ($member['is_admin'] === 1) {
                $adminMembers[] = $member;
            }
        }
        return $adminMembers;
    }

    // $membersの_idに存在しないuuidを返す
    public static function noDuplicateMemberUuid($members)
    {
        while (true) {
            $uuid = (string) Str::uuid();
            foreach ($members as $idx => $member) {
                if (strcmp($member['_id'], $uuid) === 0) {
                    continue;
                }
            }
            return $uuid;
        }
    }

    // $companiesの中から$memberIdがmembersに含まれている会社を返す
    public static function getCompanyWithMemberId($companies, $memberId)
    {
        foreach ($companies as $idx => $company) {
            if (array_search($memberId, $company['members'], true) !== FALSE) {
                return $company;
            }
        }
    }

    public static function getRandCompany($companies)
    {
        return $companies[array_rand($companies)];
    }

    // $stampGroupsの中からis_allがtrueのやつを配列で返す
    public static function getStampGroupsAreAll($stampGroups)
    {
        $alls = [];
        foreach ($stampGroups as $stampGroup) {
            if ($stampGroup['is_all'] === 1) {
                $alls[] = $stampGroup;
            }
        }
        return $alls;
    }
}
