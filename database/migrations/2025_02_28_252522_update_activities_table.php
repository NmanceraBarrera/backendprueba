<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->index(['user_id', 'created_at']); 
        });
    }

    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'created_at']);
        });
    }
};
