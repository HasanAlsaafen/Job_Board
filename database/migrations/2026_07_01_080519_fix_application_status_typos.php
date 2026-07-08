<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE applications RENAME TO _applications_old');

        DB::statement('CREATE TABLE "applications" (
            "id" integer primary key autoincrement not null,
            "resume_path" varchar not null,
            "cover_letter" varchar,
            "user_id" integer not null,
            "job_listing_id" integer not null,
            "status" varchar check ("status" in (\'Not proceeding\',\'Assessment in Progress\',\'Interview\',\'Rejected\',\'Offer\',\'Pending\',\'Withdrawn\')) not null default \'Pending\',
            "created_at" datetime,
            "updated_at" datetime,
            foreign key("user_id") references "users"("id") on delete cascade,
            foreign key("job_listing_id") references "job_listings"("id") on delete cascade
        )');

        DB::statement("
            INSERT INTO applications
            SELECT
                id,
                resume_path,
                cover_letter,
                user_id,
                job_listing_id,
                CASE status
                    WHEN 'Assesment in Progress' THEN 'Assessment in Progress'
                    WHEN 'Not proceding'         THEN 'Not proceeding'
                    ELSE status
                END,
                created_at,
                updated_at
            FROM _applications_old
        ");

        DB::statement('DROP TABLE _applications_old');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE applications RENAME TO _applications_old');

        DB::statement('CREATE TABLE "applications" (
            "id" integer primary key autoincrement not null,
            "resume_path" varchar not null,
            "cover_letter" varchar,
            "user_id" integer not null,
            "job_listing_id" integer not null,
            "status" varchar check ("status" in (\'Not proceding\',\'Assesment in Progress\',\'Interview\',\'Rejected\',\'Offer\',\'Pending\',\'Withdrawn\')) not null default \'Pending\',
            "created_at" datetime,
            "updated_at" datetime,
            foreign key("user_id") references "users"("id") on delete cascade,
            foreign key("job_listing_id") references "job_listings"("id") on delete cascade
        )');

        DB::statement("
            INSERT INTO applications
            SELECT
                id,
                resume_path,
                cover_letter,
                user_id,
                job_listing_id,
                CASE status
                    WHEN 'Assessment in Progress' THEN 'Assesment in Progress'
                    WHEN 'Not proceeding'         THEN 'Not proceding'
                    ELSE status
                END,
                created_at,
                updated_at
            FROM _applications_old
        ");

        DB::statement('DROP TABLE _applications_old');
    }
};
