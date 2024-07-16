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
        Schema::table('invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('tax_id')->nullable()->after('total');
            $table->decimal('tax', 10, 2)->nullable()->after('tax_id');
            $table->decimal('tax_total', 10, 2)->nullable()->default(0)->after('tax');
            $table->decimal('discount_total', 10, 2)->nullable()->default(0)->after('tax_total');

            $table->dropColumn('term');
            $table->dropColumn('status');

            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('invoices' , function( Blueprint $table)  {
            $table->dropForeign(['tax_id']);
        $table->dropColumn('tax_id');
        $table->dropColumn('tax');
        $table->dropColumn('tax_total');
        $table->dropColumn('discount_total');

        $table->text('term')->nullable();
        $table->string('status')->nullable();
        });
        
    }
};
