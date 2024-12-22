<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersServerTable extends Migration
{
    public function up()
    {
        Schema::create('users_server', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('server_id')
                  ->constrained('servers')
                  ->onDelete('cascade');

            $table->boolean('is_admin');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();


            $table->primary(['user_id', 'server_id']); // Composite primary key
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_server');
    }
}
