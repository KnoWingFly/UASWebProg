<?php
// database/migrations/2024_01_01_000003_add_missing_attributes_to_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('material_categories', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()
                ->after('description')
                ->constrained('material_categories')
                ->nullOnDelete();
        });

        Schema::table('learning_materials', function (Blueprint $table) {
            $table->integer('order')->default(0)->after('is_published');
            
            if (Schema::hasColumn('learning_materials', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
            
            $table->foreignId('material_category_id')
                ->after('content')
                ->constrained('material_categories')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('material_categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });

        Schema::table('learning_materials', function (Blueprint $table) {
            $table->dropColumn('order');
            $table->dropForeign(['material_category_id']);
            $table->dropColumn('material_category_id');
            

            $table->foreignId('category_id')->nullable()
                ->constrained('material_categories')
                ->onDelete('set null');
        });
    }
};