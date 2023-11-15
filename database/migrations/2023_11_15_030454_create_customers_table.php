<?php

use App\Enums\PremiumStatus;
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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('email', 50);
            $table->string('phone_number', 15)->nullable();
            $table->foreignUuid('company_id')->index();
            $table->string('stripe_id')->nullable()->index();
            $table->string('pm_type')->nullable();
            $table->string('pm_last_four', 4)->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->dateTime('next_cycle_date')->nullable();
            $table->string('user_number', 45)->nullable();
            $table->string('billing_contact_email', 50)->nullable();
            $table->tinyInteger('is_premium')->default(PremiumStatus::FREE->value);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
