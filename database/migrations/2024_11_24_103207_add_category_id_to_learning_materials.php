<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToLearningMaterials extends Migration
{
    public function up()
    {
        Schema::table('learning_materials', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained('material_categories')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('learning_materials', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
}