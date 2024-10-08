<?php

use App\Models\Fiche;
use App\Models\TagGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
        });
        Schema::create('tag_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
        });
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('slug')->nullable();
            $table->string('color')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('private')->default(false);
            $table->longText('description')->nullable();
            $table->foreignIdFor(TagGroup::class)
                ->constrained()
                ->onDelete(
                'cascade',
            );
        });
        Schema::create('horaires', function (Blueprint $table) {
            $table->id();
            $table->integer('day')->nullable();
            $table->string('media_path')->nullable();
            $table->boolean('is_open_at_lunch')->default(false);
            $table->boolean('is_rdv')->default(false);
            $table->time('morning_start')->nullable();
            $table->time('morning_end')->nullable();
            $table->time('noon_start')->nullable();
            $table->time('noon_end')->nullable();
            $table->boolean('is_closed')->default(false);
            $table
                ->foreignIdFor(Fiche::class)
                ->constrained()->onDelete(
                    'cascade',
                );
        });
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('telephone')->nullable();
            $table->string('telephone_autre')->nullable();
            $table->string('fax')->nullable();
            $table->string('gsm')->nullable();
            $table->string('email')->nullable();
            $table->string('fonction')->nullable();
            $table->string('civilite')->nullable();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->boolean('is_main')->default(false);
            $table
                ->foreignIdFor(Fiche::class)
                ->unique('fiche_id')
                ->constrained()
                ->onDelete(
                    'cascade',
                );
        });
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('group');
            $table->string('url');
            $table
                ->foreignIdFor(Fiche::class)
                ->constrained()
                ->onDelete(
                    'cascade',
                );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('tag_groups');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('horaires');
        Schema::dropIfExists('links');
    }
};
