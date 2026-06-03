<?php

namespace Database\Seeders;

use App\Models\ScheduleBlockType;
use Illuminate\Database\Seeder;

class ScheduleBlockTypeSeeder extends Seeder
{
    private static function save(String $code, String $category, String $name) {
        $model = new ScheduleBlockType;

        $model->code = $code;
        $model->category = $category;
        $model->name = $name;

        $model->save();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        static::save('A1', 'Career', 'Military Aviation Speaker');
        static::save('A2', 'Career', 'Civilian STEM Speaker/Forum/Career Fair');
        static::save('A3', 'Opportunities', 'AE/STEM NCSAs Overview');
        static::save('A4', 'Opportunities', 'AE/STEM Competitions Overview');
        static::save('A5', 'Opportunities', 'Cadet Flight Opportunities');
        static::save('A6', 'Hands On', 'AE/STEM Activity');
        static::save('A7', 'Hands On', 'Electives');
        static::save('A8', 'Explore', 'Cyber Domain');
        static::save('A9', 'Explore', 'Space Domain');

        static::save('C1', 'Character Development', 'Honor Agreement');
        static::save('C2', 'Character Development', 'Core Values (Encampment Focus)');
        static::save('C3', 'Character Development', 'Core Values In Practice (Keynote Speaker)');
        static::save('C4', 'Character Development', 'Drug-Free Lifestyle');
        static::save('C5', 'Character Development', 'Graduation Ceremony and C/CC Charge');
        static::save('C6A', 'Character Development', 'Individual Advisories (Student)');
        static::save('C6B', 'Character Development', 'Individual Advisories (Cadre)');
        static::save('C6C', 'Character Development', 'Flight Advisory');

        static::save('F1', 'Safety', 'Day Two Physical Training Safety Briefing');
        static::save('F2', 'Safety', 'Day Two Daily Sports Safety Briefing');
        static::save('F3', 'Exercise', 'Daily Physical Training/Stretching');
        static::save('F4', 'Exercise', 'Daily Sports');
        static::save('F5', 'Education', 'Healthy Lifestyle (Nutrition/Hydration)');
        static::save('F6', 'Education', 'Fitness for Life');
        static::save('F7', 'Team', 'Team Fitness Challenge');

        static::save('L1A', 'Day One', 'Report to Flights');
        static::save('L1B', 'Day One', 'Initial Skills Assessment');
        static::save('L1C', 'Day One', 'Dormitory Orientation & Preparation');
        static::save('L2A', 'Drill & Ceremonies', 'Group Reveille Formation (Daily)');
        static::save('L2B', 'Drill & Ceremonies', 'Group Retreat Formation (Daily)');
        static::save('L2C', 'Drill & Ceremonies', 'Drill & Ceremonies (Daily)');
        static::save('L2D', 'Drill & Ceremonies', 'Drill & Ceremonies Final Evaluation');
        static::save('L2E', 'Drill & Ceremonies', 'Graduation Parade');
        static::save('L3', 'Leadership Class', 'Wingmen & The Warrior Spirit (ENC focused)');
        static::save('L4', 'Leadership Class', 'Teamwork (ENC focus, taught by Cadet Commander)');
        static::save('L5', 'Leadership Class', 'Leadership Keynote Speaker');
        static::save('L6', 'Leadership Class', 'Military Leadership Speaker (Former cadet suggested)');
        static::save('L7', 'Leadership Class', 'What\'s Next After Encampment?');
        static::save('L8A', 'Inspection Dormitory', 'Inspection #1');
        static::save('L8B', 'Inspection Dormitory', 'Inspection #2');
        static::save('L8C', 'Inspection Dormitory', 'Inspection #3');
        static::save('L8D', 'Inspection Uniform', 'Inspection #1');
        static::save('L8E', 'Inspection Uniform', 'Inspection #2');
        static::save('L8F', 'Inspection Uniform', 'Inspection #3');
        static::save('L9A', 'Team Leadership', 'Team Leadership Problem #1');
        static::save('L9B', 'Team Leadership', 'Team Leadership Problem #2');
        static::save('L9C', 'Team Leadership', 'Team Leadership Problem #3');
        static::save('L9D', 'Team Leadership', 'Flight Commander Time (Daily)');
        static::save('L9E', 'Team Leadership', 'Flight/Squadron After Action Discussion (end of week)');
        static::save('L10', 'Leadership Electives', 'Other leadership classes, activities, speakers, tours, etc.');

        static::save('X1', 'Day One', 'Student Reception Varies');
        static::save('X2', 'Day One', 'Welcome, Overview & Safety Briefing');
        static::save('X3', 'Day One', 'Parents\' Orientation');
        static::save('X4', 'Day One', 'Contraband Check Varies');
        static::save('X5', 'Daily Personal Care', 'First Call');
        static::save('x6', 'Daily Personal Care', 'Shower/Dress/Prepare Dormitory');
        static::save('X7', 'Daily Personal Care', 'Personal Time');
        static::save('X8', 'Daily Personal Care', 'Showers and Blister Check');
        static::save('X9', 'Meals', 'Breakfast');
        static::save('X10', 'Meals', 'Lunch');
        static::save('X11', 'Meals', 'Dinner');
        static::save('X12', 'Sleep', 'Students Lights Out/Sleep');
        static::save('X13', 'Sleep', 'Cadre Lights Out/Sleep');
        static::save('X14', 'Staff Meeting', 'Squadron Staff Meeting/Debrief');
        static::save('X15', 'Staff Meeting', 'Encampment Staff Daily Meeting/Debrief');
        static::save('X16', 'Staff Meeting', 'Chief TO Check In with TOs');
        static::save('X17', 'End of Week', 'Graduation Picnic or Social');
        static::save('X18', 'End of Week', 'Pack, Clean Up, Check-Out');
        static::save('X19', 'End of Week', 'Dismissal & Departure');
        static::save('X20', 'End of Week', 'Debrief/Lessons Learned/AAR');
    }
}
