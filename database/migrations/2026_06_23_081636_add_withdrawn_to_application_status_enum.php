<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('PRAGMA foreign_keys=off');
        DB::statement('ALTER TABLE applications RENAME TO _applications_old');
        DB::statement('CREATE TABLE "applications" (
            "id" integer primary key autoincrement not null,
            "created_at" datetime,
            "updated_at" datetime,
            "resume_path" varchar not null,
            "cover_letter" text,
            "user_id" integer not null,
            "job_listing_id" integer not null,
            "status" varchar check ("status" in (\'Not proceding\',\'Assesment in Progress\',\'Interview\',\'Rejected\',\'Offer\',\'Pending\',\'Withdrawn\')) not null default \'Pending\',
            foreign key("user_id") references "users"("id") on delete cascade,
            foreign key("job_listing_id") references "job_listings"("id") on delete cascade
        )');
        DB::statement('INSERT INTO applications SELECT * FROM _applications_old');
        DB::statement('DROP TABLE _applications_old');
        DB::statement('PRAGMA foreign_keys=on');
    }

    public function down(): void
    {
        DB::statement('PRAGMA foreign_keys=off');
        DB::statement('UPDATE applications SET status = \'Pending\' WHERE status = \'Withdrawn\'');
        DB::statement('ALTER TABLE applications RENAME TO _applications_old');
        DB::statement('CREATE TABLE "applications" (
            "id" integer primary key autoincrement not null,
            "created_at" datetime,
            "updated_at" datetime,
            "resume_path" varchar not null,
            "cover_letter" text,
            "user_id" integer not null,
            "job_listing_id" integer not null,
            "status" varchar check ("status" in (\'Not proceding\',\'Assesment in Progress\',\'Interview\',\'Rejected\',\'Offer\',\'Pending\')) not null default \'Pending\',
            foreign key("user_id") references "users"("id") on delete cascade,
            foreign key("job_listing_id") references "job_listings"("id") on delete cascade
        )');
        DB::statement('INSERT INTO applications SELECT * FROM _applications_old');
        DB::statement('DROP TABLE _applications_old');
        DB::statement('PRAGMA foreign_keys=on');
    }
};
