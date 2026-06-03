<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('capid')->primary();
            $table->enum('rank', [
                'C/AB', 'C/Amn', 'C/A1C', 'C/SrA',
                'C/SSgt', 'C/TSgt', 'C/MSgt', 'C/SMSgt', 'C/CMSgt',
                'C/2d Lt', 'C/1st Lt', 'C/Capt', 'C/Maj', 'C/Lt Col', 'C/Col',
                'SM',
                'SSgt', 'TSgt', 'MSgt', 'SMSgt', 'CMSgt',
                'FO', 'TFO', 'SFO',
                '2d Lt', '1st Lt', 'Capt', 'Maj', 'Lt Col', 'Col', 'Brig Gen', 'Maj Gen'
            ]);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('home_unit');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->integer('age_at_start');
            $table->integer('age_at_end');
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->string('shirt_size')->nullable();
            $table->enum('member_type', ['cadet', 'senior']);
            $table->date('expiration');
            $table->string('member_status');
            $table->string('home_phone')->nullable();
            $table->string('cell_phone')->nullable();
            $table->string('address_1');
            $table->string('address_2');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('registration_status');
            $table->boolean('is_staff');
            $table->integer('registration_id');
            $table->string('comments')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_number')->nullable();
            $table->string('cadet_parent_phone_primary')->nullable();
            $table->string('cadet_parent_phone_secondary')->nullable();
            $table->string('cadet_parent_email_primary')->nullable();
            $table->string('cadet_parent_email_secondary')->nullable();
            $table->string('unit_commander_name');
            $table->string('unit_commander_email');
            $table->string('wing_commander_name');
            $table->string('wing_commander_email');
            $table->boolean('is_pilot');
            $table->date('dl_expiration')->nullable();
            $table->date('last_encampment')->nullable();
            $table->integer('highest_o_ride')->nullable();
            $table->date('aircraft_ground_handling')->nullable();
            $table->date('wing_runner')->nullable();
            $table->date('orm_basic')->nullable();
            $table->date('orm_intermediate')->nullable();
            $table->date('cppt_expiration')->nullable();
            $table->date('monthly_safety')->nullable();
            $table->date('icut')->nullable();
            $table->date('is_100')->nullable();
            $table->date('is_700')->nullable();
            $table->date('capt_116')->nullable();
            $table->date('capt_117_part_1')->nullable();
            $table->date('capt_117_part_2')->nullable();
            $table->date('capt_117_part_3')->nullable();
            $table->date('first_aid')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->integer('prices_id')->nullable();
            $table->string('invoice_status')->nullable();
            $table->string('registered_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
