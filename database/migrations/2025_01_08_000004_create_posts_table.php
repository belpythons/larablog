<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('component_id')->nullable()->constrained('components')->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('pillar', ['ecosystem', 'starter_kit', 'bricks']);

            $table->text('excerpt')->nullable();
            $table->longText('content_theory')->nullable(); // The Why
            $table->longText('content_technical')->nullable(); // The How

            $table->json('troubleshooting')->nullable(); // Repeater: [{error, solution}]

            $table->dateTime('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('post_tech_stack', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tech_stack_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('post_version', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('version_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_version');
        Schema::dropIfExists('post_tech_stack');
        Schema::dropIfExists('posts');
    }
};
