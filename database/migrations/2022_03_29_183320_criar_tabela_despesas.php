    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CriarTabelaDespesas extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('despesas', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('usuario_id')->nullable(false);
                $table->string('descricao', 191);
                $table->decimal('valor', 8, 2);
                $table->date('data_criacao');

                $table->foreign('usuario_id')
                    ->references('id')
                    ->on('usuarios');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('despesas');
        }
    }
