<?php

namespace Database\Seeders;

use App\Models\DutyPosition;
use Illuminate\Database\Seeder;

class DutyPositionSeeder extends Seeder
{
    private static function build(String $name, String $office_symbol, ?int $next_higher = null, bool $only_one = true, bool $is_primary = true, bool $senior_only = true): DutyPosition {
        return DutyPosition::create([
            'name' => $name,
            'office_symbol' => $office_symbol,
            'only_one' => $only_one,
            'senior_only' => $senior_only,
            'is_primary' => $is_primary,
            'next_higher_id' => $next_higher
        ]);
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = DutyPosition::count();

        if ($count != 0) {
            return;
        }

        $cc = static::build('Commander', 'CC');

        $fm = static::build('Finance Officer', 'FM', $cc->id);
        static::build('Assistant Finance Officer', 'FM', $fm->id, false, false);

        $se = static::build('Safety Officer', 'SE', $cc->id);
        static::build('Assistant Safety Officer', 'SE', $se->id, false, false);

        $cds = static::build('Deputy Commander for Support', 'CDS', $cc->id);
        static::build('Assistant Deputy Commander for Support', 'CDS', $cds->id, false, false);

        $da = static::build('Administrative Officer', 'DA', $cds->id);
        static::build('Assistant Administrative Officer', 'DA', $da->id, false, false);

        $hc = static::build('Chaplain', 'HC', $cds->id);
        static::build('Chaplain Assistant', 'HC', $hc->id, false, false);
        static::build('Character Development Instructor', 'HCI', $hc->id, false, false);

        $xp = static::build('Curriculum and Plans Officer', 'XP', $cds->id);
        static::build('Assistant Curriculum and Plans Officer', 'XP', $xp->id, false, false);

        $lg = static::build('Logistics Officer', 'LG', $cds->id);
        static::build('Assistant Logistics Officer', 'LG', $lg->id, false, false);

        $lgs = static::build('Supply Officer', 'LGS', $cds->id);
        static::build('Assistant Supply Officer', 'LGS', $lgs->id, false, false);

        $lgt = static::build('Transportation Officer', 'LGT', $cds->id);
        static::build('Assistant Transportation Officer', 'LGT', $lgt->id, false, false);

        $hs = static::build('Medical Officer', 'HS', $cds->id);
        static::build('Assistant Medical Officer', 'HS', $hs->id, false, false);

        $pa = static::build('Public Affairs Officer', 'PA', $cds->id);
        static::build('Assistant Public Affairs Officer', 'PA', $pa->id, false, false);

        $cdc = static::build('Commandant of Cadets', 'CDC', $cc->id);

        $cto = static::build('Chief Training Officer', 'A3', $cdc->id);

        $sto = static::build('Senior Training Officer', 'A3', $cto->id);

        $to = static::build('Training Officer', 'A3', $sto->id);
        static::build('Assistant Training Officer', 'A3', $to->id, false, false);

        $c_cc = static::build('Cadet Commander', 'C/CC', $cdc->id, true, true, false);

        $c_cdo = static::build('Cadet Deputy Commander for Operations', 'C/CDO', $c_cc->id, true, true, false);

        $c_cc_s = static::build('Cadet Commander', 'C/CC', $c_cdo->id, true, true, false);
        static::build('Cadet Deputy Commander', 'C/CD', $c_cc_s->id, true, true, false);
        static::build('Cadet First Sergeant', 'C/CCF', $c_cc_s->id, true, true, false);

        $c_cc_f = static::build('Cadet Commander', 'C/CC', $c_cc_s->id, true, true, false);
        static::build('Cadet Deputy Commander', 'C/CD', $c_cc_f->id, true, true, false);
        static::build('Cadet Flight Sergeant', 'C/CCF', $c_cc_f->id, true, true, false);

        $c_cds = static::build('Cadet Deputy Commander for Support', 'C/CDS', $c_cc->id, true, true, false);

        $c_da = static::build('Cadet Administrative OIC', 'C/DA', $c_cds->id, true, true, false);
        static::build('Cadet Administrative Officer', 'C/DA', $c_da->id, false, false, false);

        $c_xp = static::build('Cadet Curriculum and Plans OIC', 'C/XP', $c_cds->id, true, true, false);
        static::build('Cadet Curriculum and Plans Officer', 'C/XP', $c_xp->id, false, false, false);

        $c_lg = static::build('Cadet Logistics OIC', 'C/LG', $c_cds->id, true, true, false);
        static::build('Cadet Logistics Officer', 'C/LG', $c_lg->id, false, false, false);

        $c_hs = static::build('Cadet Medical OIC', 'C/HS', $c_cds->id, true, true, false);
        static::build('Cadet Medical Officer', 'C/HS', $c_hs->id, false, false, false);

        $c_pa = static::build('Cadet Public Affairs OIC', 'C/PA', $c_cds->id, true, true, false);
        static::build('Cadet Public Affairs Officer', 'PA', $c_pa->id, false, false, false);
    }
}
