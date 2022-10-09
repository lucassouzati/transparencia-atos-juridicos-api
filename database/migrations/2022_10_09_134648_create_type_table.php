<?php

use App\Models\Type;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        Type::insert([
            ['name' => 'aviso', 'description' => 'Aviso', 'active' => 1],
            ['name' => 'edital', 'description' => 'Edital', 'active' => 1],
            ['name' => 'contrato', 'description' => 'Contrato', 'active' => 1],
            ['name' => 'termo_aditivo', 'description' => 'Termo Aditivo', 'active' => 1],
            ['name' => 'ata', 'description' => 'Ata de Registro de Preço', 'active' => 1],
            ['name' => 'termo_de_apostilamento', 'description' => 'Termo de Apostilamento', 'active' => 1],
            ['name' => 'extrato', 'description' => 'Extrato de Homologação', 'active' => 1],
            ['name' => 'atos_ratificacao', 'description' => 'Atos de Ratificação', 'active' => 1],
            ['name' => 'Recisão Contratual', 'description' => 'reciscao_contratual', 'active' => 1],
            ['name' => 'dispensa', 'description' => 'Dispensas de Licitação', 'active' => 1],
            ['name' => 'adesao_ata', 'description' => 'Adesão a Ata de Registro de Preço', 'active' => 1],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('types');
    }
};
