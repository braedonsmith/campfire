<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('campfire:ingest {path}', function (String $path) {
    $spreadsheet = IOFactory::load($path);
    $sheet = $spreadsheet->getSheetByName('UniversalReport');

    $users = [];

    for ($rowIndex = 2; $rowIndex <= $sheet->getHighestDataRow(); ++$rowIndex) {
        $first = $sheet->getCell([8, $rowIndex])->getValue();
        $last = $sheet->getCell([7, $rowIndex])->getValue();
        $rank = $sheet->getCell([6, $rowIndex])->getValue();

        // Normalize rank abbreviations to USAF standard
        switch ($rank) {
            case 'CADET':
                $rank = 'C/AB';
                break;
            case 'C/2dLt':
                $rank = 'C/2d Lt';
                break;
            case 'C/1stLt':
                $rank = 'C/1st Lt';
                break;
            case 'C/LtCol':
                $rank = 'C/Lt Col';
                break;
            case '2dLt':
                $rank = '2d Lt';
                break;
            case '1stLt':
                $rank = '1st Lt';
                break;
            case 'LtCol':
                $rank = 'Lt Col';
                break;
        }

        $email = $sheet->getCell([28, $rowIndex])->getValue();

        if (array_any($users, fn($user) => $user['email'] === $email)) {
            $this->error('Skipping user for duplicate email: ' . $rank . ' ' . $first . ' ' . $last);
            continue;
        }

        $password = Str::password();

        $height = intval($sheet->getCell([18, $rowIndex])->getValue());
        $weight = intval($sheet->getCell([19, $rowIndex])->getValue());

        $shirtSize = trim($sheet->getCell([20, $rowIndex])->getValue());

        $dl_expiration = $sheet->getCell([65, $rowIndex])->getValue();
        $last_encampment = $sheet->getCell([66, $rowIndex])->getValue();

        $highest_o_ride = intval($sheet->getCell([67, $rowIndex])->getValue());

        $aircraft_ground_handling = $sheet->getCell([69, $rowIndex])->getValue();
        $wing_runner = $sheet->getCell([70, $rowIndex])->getValue();
        $orm_basic = $sheet->getCell([71, $rowIndex])->getValue();
        $orm_intermediate = $sheet->getCell([72, $rowIndex])->getValue();
        $cppt_expiration = $sheet->getCell([73, $rowIndex])->getValue();
        $monthly_safety = $sheet->getCell([74, $rowIndex])->getValue();
        $icut = $sheet->getCell([75, $rowIndex])->getValue();
        $is_100 = $sheet->getCell([76, $rowIndex])->getValue();
        $is_700 = $sheet->getCell([77, $rowIndex])->getValue();
        $capt_116 = $sheet->getCell([78, $rowIndex])->getValue();
        $capt_117_part_1 = $sheet->getCell([79, $rowIndex])->getValue();
        $capt_117_part_2 = $sheet->getCell([80, $rowIndex])->getValue();
        $capt_117_part_3 = $sheet->getCell([81, $rowIndex])->getValue();
        $first_aid = $sheet->getCell([82, $rowIndex])->getValue();

        $invoice_id = intval($sheet->getCell([83, $rowIndex])->getValue());
        $prices_id = intval($sheet->getCell([84, $rowIndex])->getValue());

        $user = [
            'capid' => intval($sheet->getCell([2, $rowIndex])->getValue()),
            'rank' => $rank,
            'first_name' => $first,
            'last_name' => $last,
            'middle_name' => $sheet->getCell([9, $rowIndex])->getValue(),
            'email' => $sheet->getCell([28, $rowIndex])->getValue(),
            'email_verified_at' => null,
            'password' => Hash::make($password),
            'home_unit' => $sheet->getCell([10, $rowIndex])->getValue() . '-' . $sheet->getCell([11, $rowIndex])->getValue() . '-' . $sheet->getCell([12, $rowIndex])->getValue(),
            'gender' => $sheet->getCell([13, $rowIndex])->getValue(),
            'date_of_birth' => DateTime::createFromFormat('m/y', $sheet->getCell([14, $rowIndex])->getValue())->format('d M Y'),
            'age_at_start' => intval($sheet->getCell([16, $rowIndex])->getValue()),
            'age_at_end' => intval($sheet->getCell([17, $rowIndex])->getValue()),
            'height' => $height == 0 ? null : $height,
            'weight' => $weight == 0 ? null : $weight,
            'shirt_size' => $shirtSize == 'Unavailable' || $shirtSize == '' ? null : $shirtSize,
            'member_type' => strtolower($sheet->getCell([21, $rowIndex])->getValue()),
            'expiration' => $sheet->getCell([22, $rowIndex])->getValue(),
            'member_status' => $sheet->getCell([23, $rowIndex])->getValue(),
            'home_phone' => $sheet->getCell([24, $rowIndex])->getValue(),
            'cell_phone' => $sheet->getCell([25, $rowIndex])->getValue(),
            'address_1' => $sheet->getCell([29, $rowIndex])->getValue(),
            'address_2' => $sheet->getCell([30, $rowIndex])->getValue(),
            'city' => $sheet->getCell([31, $rowIndex])->getValue(),
            'state' => $sheet->getCell([32, $rowIndex])->getValue(),
            'zip_code' => $sheet->getCell([33, $rowIndex])->getValue(),
            'registration_status' => $sheet->getCell([36, $rowIndex])->getValue(),
            'is_staff' => $sheet->getCell([37, $rowIndex])->getValue() == 'Yes',
            'registration_id' => $sheet->getCell([41, $rowIndex])->getValue(),
            'comments' => $sheet->getCell([43, $rowIndex])->getValue(),
            'emergency_contact_name' => $sheet->getCell([26, $rowIndex])->getValue(),
            'emergency_contact_number' => $sheet->getCell([27, $rowIndex])->getValue(),
            'cadet_parent_phone_primary' => $sheet->getCell([54, $rowIndex])->getValue(),
            'cadet_parent_phone_secondary' => $sheet->getCell([55, $rowIndex])->getValue(),
            'cadet_parent_email_primary' => $sheet->getCell([56, $rowIndex])->getValue(),
            'cadet_parent_email_secondary' => $sheet->getCell([57, $rowIndex])->getValue(),
            'unit_commander_name' => $sheet->getCell([60, $rowIndex])->getValue(),
            'unit_commander_email' => $sheet->getCell([61, $rowIndex])->getValue(),
            'wing_commander_name' => $sheet->getCell([62, $rowIndex])->getValue(),
            'wing_commander_email' => $sheet->getCell([63, $rowIndex])->getValue(),
            'is_pilot' => $sheet->getCell([64, $rowIndex])->getValue() == 'Yes',
            'dl_expiration' => empty(trim($dl_expiration)) ? null : $dl_expiration,
            'last_encampment' => empty(trim($last_encampment)) ? null : $last_encampment,
            'highest_o_ride' => $highest_o_ride == 0 ? null : $highest_o_ride,
            'aircraft_ground_handling' => $aircraft_ground_handling == 'Not Complete' ? null : $aircraft_ground_handling,
            'wing_runner' => $wing_runner == 'Not Complete' ? null : $wing_runner,
            'orm_basic' => $orm_basic == 'Not Complete' ? null : $orm_basic,
            'orm_intermediate' => $orm_intermediate == 'Not Complete' ? null : $orm_intermediate,
            'cppt_expiration' => empty(trim($cppt_expiration)) ? null : $cppt_expiration,
            'monthly_safety' => $monthly_safety == 'Not Complete' ? null : $monthly_safety,
            'icut' => $icut == 'Not Complete' ? null : $icut,
            'is_100' => $is_100 == 'Not Complete' ? null : $is_100,
            'is_700' => $is_700 == 'Not Complete' ? null : $is_700,
            'capt_116' => $capt_116 == 'Not Complete' ? null : $capt_116,
            'capt_117_part_1' => $capt_117_part_1 == 'Not Complete' ? null : $capt_117_part_1,
            'capt_117_part_2' => $capt_117_part_2 == 'Not Complete' ? null : $capt_117_part_2,
            'capt_117_part_3' => $capt_117_part_3 == 'Not Complete' ? null : $capt_117_part_3,
            'first_aid' => $first_aid == 'Not Complete' ? null : $first_aid,
            'invoice_id' => $invoice_id == 0 ? null : $invoice_id,
            'prices_id' => $prices_id == 0 ? null : $prices_id,
            'invoice_status' => $sheet->getCell([85, $rowIndex])->getValue(),
            'registered_by' => $sheet->getCell([88, $rowIndex])->getValue()
        ];

        array_push($users, $user);

        $this->line('Created user: ' . $rank . ' ' . $first . ' ' . $last . ' with password ' . $password);
    }

    User::upsert($users, ['capid'], [
        'rank', 'first_name', 'last_name', 'middle_name',
        'email',
        'home_unit',
        'gender',
        'date_of_birth', 'age_at_start', 'age_at_end',
        'height', 'weight',
        'shirt_size',
        'member_type', 'expiration', 'member_status',
        'home_phone', 'cell_phone',
        'address_1', 'address_2', 'city', 'state', 'zip_code',
        'registration_status', 'is_staff', 'registration_id', 'comments',
        'emergency_contact_name', 'emergency_contact_number',
        'cadet_parent_phone_primary', 'cadet_parent_phone_secondary', 'cadet_parent_email_primary', 'cadet_parent_email_secondary',
        'unit_commander_name', 'unit_commander_email', 'wing_commander_name', 'wing_commander_email',
        'is_pilot',
        'dl_expiration', 'last_encampment',
        'highest_o_ride',
        'aircraft_ground_handling', 'wing_runner',
        'orm_basic', 'orm_intermediate',
        'cppt_expiration',
        'monthly_safety',
        'icut',
        'is_100', 'is_700',
        'capt_116', 'capt_117_part_1', 'capt_117_part_2', 'capt_117_part_3',
        'first_aid',
        'invoice_id', 'prices_id', 'invoice_status',
        'registered_by'
    ]);
})->purpose('Ingest data from a Registration Zone universal report');
