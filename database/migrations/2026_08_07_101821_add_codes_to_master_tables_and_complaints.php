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
        Schema::table('complaint_types', function (Blueprint $table) {
            $table->string('code')->nullable()->after('name');
        });

        Schema::table('divisions', function (Blueprint $table) {
            $table->string('code')->nullable()->after('name');
        });

        Schema::table('complaints', function (Blueprint $table) {
            $table->string('complaint_code')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaint_types', function (Blueprint $table) {
            $table->dropColumn('code');
        });

        Schema::table('divisions', function (Blueprint $table) {
            $table->dropColumn('code');
        });

        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn('complaint_code');
        });
    }
};
