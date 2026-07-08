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
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('title')->nullable()->after('img_url');
            $table->text("bio")->nullable()->after('title');
            $table->string('location')->nullable()->after('bio');
            $table->string('linkedin')->nullable()->after('location');
            $table->string('github')->nullable()->after('linkedin');
            $table->string('resume_path')->nullable()->after('github');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            //
        });
    }
};
