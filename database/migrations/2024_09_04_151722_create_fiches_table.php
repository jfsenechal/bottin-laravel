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
        Schema::create('adresses', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 150)->nullable();
            $table->string('rue', 255)->nullable();
            $table->string('numero', 255)->nullable();
            $table->integer('cp')->nullable();
            $table->string('localite', 255)->nullable();
            $table->string('longitude', 255)->nullable();
            $table->string('latitude', 255)->nullable();
            $table->string('slug', 255)->nullable();
        });
        Schema::create('fiches', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable()->unique();
            $table->string('societe');
            $table->string('rue')->nullable();
            $table->string('numero')->nullable();
            $table->integer('cp')->nullable();
            $table->string('localite')->nullable();
            $table->string('telephone')->nullable(); // telephone (varchar 255, nullable)
            $table->string('telephone_autre')->nullable(); // telephone_autre (varchar 255, nullable)
            $table->string('fax')->nullable(); // fax (varchar 255, nullable)
            $table->string('gsm')->nullable(); // gsm (varchar 255, nullable)
            $table->string('website')->nullable(); // website (varchar 255, nullable)
            $table->string('email')->nullable(); // email (varchar 255, nullable)
            $table->string('facebook')->nullable(); // facebook (varchar 255, nullable)
            $table->string('twitter')->nullable(); // twitter (varchar 255, nullable)
            $table->double('longitude')->nullable(); // longitude (varchar 255, nullable)
            $table->double('latitude')->nullable(); // latitude (varchar 255, nullable)
            $table->boolean('centreville')->default(false); // centreville (tinyint 1, default 0)
            $table->boolean('midi')->default(false); // midi (tinyint 1, default 0)
            $table->boolean('pmr')->default(false); // pmr (tinyint 1, default 0)
            $table->string('fonction')->nullable(); // fonction (varchar 255, nullable)
            $table->string('civilite')->nullable(); // civilite (varchar 255, nullable)
            $table->string('nom')->nullable(); // nom (varchar 255, nullable)
            $table->string('prenom')->nullable(); // prenom (varchar 255, nullable)
            $table->string('contact_rue')->nullable(); // contact_rue (varchar 255, nullable)
            $table->string('contact_num')->nullable(); // contact_num (varchar 255, nullable)
            $table->string('contact_cp')->nullable(); // contact_cp (varchar 255, nullable)
            $table->string('contact_localite')->nullable(); // contact_localite (varchar 255, nullable)
            $table->string('contact_telephone')->nullable(); // contact_telephone (varchar 255, nullable)
            $table->string('contact_telephone_autre')->nullable(); // contact_telephone_autre (varchar 255, nullable)
            $table->string('contact_fax')->nullable(); // contact_fax (varchar 255, nullable)
            $table->string('contact_gsm')->nullable(); // contact_gsm (varchar 255, nullable)
            $table->string('contact_email')->nullable(); // contact_email (varchar 255, nullable)
            $table->string('admin_fonction')->nullable(); // admin_fonction (varchar 255, nullable)
            $table->string('admin_civilite')->nullable(); // admin_civilite (varchar 255, nullable)
            $table->string('admin_nom')->nullable(); // admin_nom (varchar 255, nullable)
            $table->string('admin_prenom')->nullable(); // admin_prenom (varchar 255, nullable)
            $table->string('admin_telephone')->nullable(); // admin_telephone (varchar 255, nullable)
            $table->string('admin_telephone_autre')->nullable(); // admin_telephone_autre (varchar 255, nullable)
            $table->string('admin_fax')->nullable(); // admin_fax (varchar 255, nullable)
            $table->string('admin_gsm')->nullable(); // admin_gsm (varchar 255, nullable)
            $table->string('admin_email')->nullable(); // admin_email (varchar 255, nullable)
            $table->longText('comment1')->nullable(); // comment1 (longtext, nullable)
            $table->longText('comment2')->nullable(); // comment2 (longtext, nullable)
            $table->longText('comment3')->nullable(); // comment3 (longtext, nullable)
            $table->longText('note')->nullable(); // note (longtext, nullable)
            $table->integer('ftlb')->nullable(); // ftlb (int, nullable)
            $table->string('user')->nullable(); // user (varchar 255, nullable)
            $table->string('instagram')->nullable(); // instagram (varchar 255, nullable)
            $table->boolean('enabled')->default(false); // enabled (tinyint 1, default 0)
            $table->foreignId('adresse_id')->nullable()->constrained('adresses'); // adresse_id (foreign key)
            $table->boolean('click_collect')->default(false); // click_collect (tinyint 1, default 0)
            $table->boolean('ecommerce')->default(false); // ecommerce (tinyint 1, default 0)
            $table->string('numero_tva')->nullable(); // numero_tva (varchar 255, nullable)
            $table->string('tiktok')->nullable(); // tiktok (varchar 255, nullable)
            $table->string('youtube')->nullable(); // youtube (varchar 255, nullable)
            $table->string('linkedin')->nullable(); // linkedin (varchar 255, nullable)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fiches');
        Schema::dropIfExists('adresses');
    }
};
