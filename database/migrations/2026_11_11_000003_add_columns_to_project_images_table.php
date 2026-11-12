<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Kolom dicek satu per satu agar aman untuk database baru
        // yang sudah memiliki struktur lengkap dari migration awal.
        $addProjectId = ! Schema::hasColumn('project_images', 'project_id');
        $addImage = ! Schema::hasColumn('project_images', 'image');
        $addCaption = ! Schema::hasColumn('project_images', 'caption');
        $addSortOrder = ! Schema::hasColumn('project_images', 'sort_order');

        Schema::table('project_images', function (Blueprint $table) use ($addProjectId, $addImage, $addCaption, $addSortOrder) {
            if ($addProjectId) {
                $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            }

            if ($addImage) {
                $table->string('image'); // path, bukan file
            }

            if ($addCaption) {
                $table->string('caption')->nullable();
            }

            if ($addSortOrder) {
                $table->integer('sort_order')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $hasProjectId = Schema::hasColumn('project_images', 'project_id');
        $hasImage = Schema::hasColumn('project_images', 'image');
        $hasCaption = Schema::hasColumn('project_images', 'caption');
        $hasSortOrder = Schema::hasColumn('project_images', 'sort_order');

        Schema::table('project_images', function (Blueprint $table) use ($hasProjectId, $hasImage, $hasCaption, $hasSortOrder) {
            if ($hasProjectId) {
                $table->dropConstrainedForeignId('project_id');
            }

            if ($hasImage) {
                $table->dropColumn('image');
            }

            if ($hasCaption) {
                $table->dropColumn('caption');
            }

            if ($hasSortOrder) {
                $table->dropColumn('sort_order');
            }
        });
    }
};
