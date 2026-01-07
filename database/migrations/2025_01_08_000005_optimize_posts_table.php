<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Composite Indexes for frequent lookups
            // slug + published_at is common for frontend retrieval
            $table->index(['slug', 'published_at'], 'posts_slug_published_index');

            // Index for relationship filtering
            $table->index('user_id', 'posts_user_index');

            // Index for filtering by Pillar
            $table->index('pillar', 'posts_pillar_index');
        });

        // Full-Text Index (Conditional based on Driver)
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE posts ADD FULLTEXT fulltext_index (title, content_theory)');
        }
        // SQLite doesn't support adding FULLTEXT to existing tables easily without virtual tables.
        // We will skip this optimization for SQLite to prevent migration errors in dev.
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex('posts_slug_published_index');
            $table->dropIndex('posts_user_index');
            $table->dropIndex('posts_pillar_index');
            if (DB::getDriverName() === 'mysql') {
                $table->dropIndex('fulltext_index');
            }
        });
    }
};
