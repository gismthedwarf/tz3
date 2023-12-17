<?php

use App\Models\Currency;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->string('login');
            $table->text('creds')
                ->comment('credentials');
            $table->integer('sum')
                ->comment('sum in integers like cents');
            $table->foreignIdFor(Currency::class)->constrained();
            $table->index('currency_id');
            $table->enum('status', ['open', 'paid'])->default('open')
                ->comment('status: open, paid');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
