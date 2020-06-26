<?php

use Centauri\CMS\Model\BeUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CentauriBeUsers extends Migration
{
    /**
     * Name of this table.
     * 
     * @var string
     */
    protected $table = "be_users";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function(Blueprint $table) {
            $table->increments("uid");

            $table->timestamps();
            $table->softDeletes();

            $table->string("email", 100);
            $table->string("username", 100);
            $table->string("password");
        });

        $beUser = new BeUser;

        $beUser->email = "my@mail.com";
        $beUser->username = "admin";
        $beUser->password = "password";

        $beUser->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
