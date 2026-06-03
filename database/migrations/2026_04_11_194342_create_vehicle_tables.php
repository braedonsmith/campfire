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
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->id();
            $table->string('make');
            $table->string('model');
            $table->integer('capacity');
            $table->timestamps();
        });

        Schema::create('vehicles', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('vehicle_type_id');
            $table->integer('year');
            $table->string('home_unit');
            $table->integer('issued_to')->nullable();
            $table->boolean('in_service');
            $table->timestamps();
        });

        Schema::create('vehicle_inspections', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_id');
            $table->boolean('windows')->nullable();
            $table->string('windows_remarks')->nullable();
            $table->boolean('headlights')->nullable();
            $table->string('headlights_remarks')->nullable();
            $table->boolean('tail_lights')->nullable();
            $table->string('tail_lights_remarks')->nullable();
            $table->boolean('brake_lights')->nullable();
            $table->string('brake_lights_remarks')->nullable();
            $table->boolean('turn_signals')->nullable();
            $table->string('turn_signals_remarks')->nullable();
            $table->boolean('emergency_lights')->nullable();
            $table->string('emergency_lights_remarks')->nullable();
            $table->boolean('license_plate_light')->nullable();
            $table->string('license_plate_light_remarks')->nullable();
            $table->boolean('backup_light')->nullable();
            $table->string('backup_light_remarks')->nullable();
            $table->boolean('backup_alarm')->nullable();
            $table->string('backup_alarm_remarks')->nullable();
            $table->boolean('wiper_blades')->nullable();
            $table->string('wiper_blades_remarks')->nullable();
            $table->boolean('horn')->nullable();
            $table->string('horn_remarks')->nullable();
            $table->boolean('seats')->nullable();
            $table->string('seats_remarks')->nullable();
            $table->boolean('restraints')->nullable();
            $table->string('restraints_remarks')->nullable();
            $table->boolean('mirrors')->nullable();
            $table->string('mirrors_remarks')->nullable();
            $table->boolean('beacon_light')->nullable();
            $table->string('beacon_light_remarks')->nullable();
            $table->boolean('wiring')->nullable();
            $table->string('wiring_remarks')->nullable();
            $table->boolean('brakes')->nullable();
            $table->string('brakes_remarks')->nullable();
            $table->boolean('battery')->nullable();
            $table->string('battery_remarks')->nullable();
            $table->boolean('brake_fluid')->nullable();
            $table->string('brake_fluid_remarks')->nullable();
            $table->boolean('exhaust_system')->nullable();
            $table->string('exhaust_system_remarks')->nullable();
            $table->boolean('oil_level')->nullable();
            $table->string('oil_level_remarks')->nullable();
            $table->integer('oil_level_last_change')->nullable();
            $table->boolean('coolant')->nullable();
            $table->string('coolant_remarks')->nullable();
            $table->boolean('belts_hoses')->nullable();
            $table->string('belts_hoses_remarks')->nullable();
            $table->boolean('transmission')->nullable();
            $table->string('transmission_remarks')->nullable();
            $table->boolean('battery_cables')->nullable();
            $table->string('battery_cables_remarks')->nullable();
            $table->boolean('air_filter')->nullable();
            $table->string('air_filter_remarks')->nullable();
            $table->boolean('body')->nullable();
            $table->string('body_remarks')->nullable();
            $table->boolean('paint')->nullable();
            $table->string('paint_remarks')->nullable();
            $table->boolean('bumpers')->nullable();
            $table->string('bumpers_remarks')->nullable();
            $table->boolean('tire_tread')->nullable();
            $table->string('tire_tread_remarks')->nullable();
            $table->boolean('tire_gauge_present')->nullable();
            $table->integer('front_recommended_pressure')->nullable();
            $table->integer('rear_recommended_pressure')->nullable();
            $table->integer('lf_pressure')->nullable();
            $table->integer('rf_pressure')->nullable();
            $table->integer('lr_pressure')->nullable();
            $table->integer('rr_pressure')->nullable();
            $table->boolean('logbook_present')->nullable();
            $table->string('logbook_present_remarks')->nullable();
            $table->boolean('registration_present')->nullable();
            $table->string('registration_present_remarks')->nullable();
            $table->boolean('registration_current')->nullable();
            $table->string('registration_current_remarks')->nullable();
            $table->boolean('insurance_present')->nullable();
            $table->string('insurance_present_remarks')->nullable();
            $table->boolean('insurance_current')->nullable();
            $table->string('insurance_current_remarks')->nullable();
            $table->boolean('capf_132_present')->nullable();
            $table->string('capf_132_present_remarks')->nullable();
            $table->boolean('capf_132_current')->nullable();
            $table->string('capf_132_current_remarks')->nullable();
            $table->boolean('capf_132_signed')->nullable();
            $table->string('capf_132_signed_remarks')->nullable();
            $table->boolean('first_aid_kit_present')->nullable();
            $table->string('first_aid_kit_present_remarks')->nullable();
            $table->boolean('toolkit_present')->nullable();
            $table->string('toolkit_present_remarks')->nullable();
            $table->boolean('toolkit_secured')->nullable();
            $table->string('toolkit_secured_remarks')->nullable();
            $table->boolean('survival_kit_present')->nullable();
            $table->string('survival_kit_present_remarks')->nullable();
            $table->boolean('is_mission_ready')->nullable();
            $table->integer('inspector_capid')->nullable();
            $table->dateTime('signed_at')->nullable();
            $table->integer('ic_capid')->nullable();
            $table->dateTime('ic_signed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_inspections');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('vehicle_types');
    }
};
