<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) { // ✅ UBAH 'user' MENJADI 'users'
            $table->foreignId('employee_id')->nullable()->after('password')->constrained('employees')->onDelete('cascade');
            $table->string('role')->default('employee')->after('employee_id');
            $table->boolean('is_active')->default(true)->after('role');
            $table->timestamp('last_login')->nullable()->after('is_active');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->dropColumn(['employee_id', 'role', 'is_active', 'last_login']);
        });
    }
};