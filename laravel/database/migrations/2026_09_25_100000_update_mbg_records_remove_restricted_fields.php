<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('mbg_records')) {
            return;
        }

        $columns = Schema::getColumnListing('mbg_records');
        $hasOldColumns = array_intersect(['unit', 'jenis_porsi', 'bentuk'], $columns);

        if (empty($hasOldColumns)) {
            return;
        }

        $originalTable = 'mbg_records';
        $newTable = 'mbg_records_new';

        Schema::create($newTable, function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kelas');
            $table->unsignedInteger('jumlah')->default(1);
            $table->dateTime('waktu_pengambilan');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        $existingColumns = array_values(array_intersect(['id', 'nama', 'kelas', 'jumlah', 'waktu_pengambilan', 'catatan', 'created_at', 'updated_at'], $columns));

        if (! empty($existingColumns)) {
            $columnList = implode(', ', array_map(fn ($column) => '"' . $column . '"', $existingColumns));
            $selectList = implode(', ', array_map(fn ($column) => '"' . $column . '"', $existingColumns));

            DB::statement("INSERT INTO \"{$newTable}\" ({$columnList}) SELECT {$selectList} FROM \"{$originalTable}\"");
        }

        Schema::dropIfExists($originalTable);
        Schema::rename($newTable, $originalTable);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('mbg_records')) {
            return;
        }

        $columns = Schema::getColumnListing('mbg_records');

        if (in_array('unit', $columns, true) && in_array('jenis_porsi', $columns, true) && in_array('bentuk', $columns, true)) {
            return;
        }

        $originalTable = 'mbg_records';
        $newTable = 'mbg_records_backup';

        Schema::create($newTable, function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kelas');
            $table->string('unit')->nullable();
            $table->string('jenis_porsi')->nullable();
            $table->string('bentuk')->nullable();
            $table->unsignedTinyInteger('jumlah')->default(1);
            $table->dateTime('waktu_pengambilan');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        $existingColumns = array_values(array_intersect(['id', 'nama', 'kelas', 'jumlah', 'waktu_pengambilan', 'catatan', 'created_at', 'updated_at'], $columns));

        if (! empty($existingColumns)) {
            $columnList = implode(', ', array_map(fn ($column) => '"' . $column . '"', $existingColumns));
            $selectList = implode(', ', array_map(fn ($column) => '"' . $column . '"', $existingColumns));

            DB::statement("INSERT INTO \"{$newTable}\" ({$columnList}) SELECT {$selectList} FROM \"{$originalTable}\"");
        }

        Schema::dropIfExists($originalTable);
        Schema::rename($newTable, $originalTable);
    }
};
