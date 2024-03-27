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
       
        Schema::table('budgets', function (Blueprint $table) {
            $table->decimal('budget_initial', 10, 2)->nullable()->after('total_budget');
            // Ajoutez d'autres colonnes si nécessaire
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropColumn('budget_initial');
            // Supprimez d'autres colonnes ajoutées dans la méthode up() si nécessaire
        });
    }
};
