<?php

use App\Enums\ActiveStatus;
use App\Enums\UserChangeInfo;
use App\Enums\UserChangePassword;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->tinyInteger('status')->default(ActiveStatus::ACTIVE->value);
            $table->foreignUuid('userable_id')->nullable()->index();
            $table->string('userable_type', 45)->nullable();
            $table->string('role', 45)->nullable();
            $table->tinyInteger('is_changed_password')->default(UserChangePassword::NO_CHANGE->value);
            $table->tinyInteger('is_changed_info')->default(UserChangeInfo::NO_CHANGE->value);
            $table->string('language')->default('en');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
