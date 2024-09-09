<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable(); // slug (varchar 255, nullable)
            $table->string('name'); // name (varchar 255, not null)
            $table->boolean('mobile')->default(false); // mobile (tinyint 1, not null, default 0)
            $table->string('logo')->nullable(); // logo (varchar 255, nullable)
            $table->longText('description')->nullable(); // description (longtext, nullable)
            $table->string('logo_blanc')->nullable(); // logo_blanc (varchar 255, nullable)
            $table->timestamp('created_at')->nullable(); // created_at (datetime, nullable)
            $table->timestamp('updated_at')->nullable(); // updated_at (datetime, nullable)
            $table->string('materialized_path'); // materialized_path (varchar 255, not null)
            $table->string('color')->nullable(); // color (varchar 255, nullable)
            $table->string('icon')->nullable(); // icon (varchar 255, nullable)
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
