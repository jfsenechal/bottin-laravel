<?php

use App\Models\Category;
use App\Models\Fiche;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fiche_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fiche::class)->constrained()->onDelete(
                'cascade',
            );
            $table->foreignIdFor(Tag::class)->constrained()->onDelete(
                'cascade',
            );
            $table->unique(['fiche_id', 'tag_id']);
        });
        Schema::create('category_fiche', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fiche::class)->constrained()->onDelete(
                'cascade',
            );
            $table->foreignIdFor(Category::class)->constrained('categories')->onDelete(
                'cascade',
            );
            $table->boolean('is_main')->default(false);
            $table->unique(['fiche_id', 'category_id']);
            $table->timestamps();
        });
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Fiche::class)->constrained()->onDelete(
                'cascade',
            );
            $table->string('path');
            $table->boolean('is_main')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_fiche');
        Schema::dropIfExists('category_fiche');
        Schema::dropIfExists('images');
    }
};
