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
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('id_number')->nullable()->after('name');
            $table->string('contact_number')->nullable()->after('phone_number');
            $table->string('email')->nullable()->after('contact_number');
            $table->date('move_out_date')->nullable()->after('move_in_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['id_number', 'contact_number', 'email', 'move_out_date']);
        });
    }
};
