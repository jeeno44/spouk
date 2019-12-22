<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrollmentReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollment_reasons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('college_id')->unsigned()->nullable();
            $table->integer('system_id')->unsigned()->nullable();
            $table->foreign('college_id')->references('id')->on('colleges')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('system_id')->references('id')->on('systems')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->string('title');
            $table->boolean('is_global');
            $table->timestamps();
        });
        $titles = [
            'Возвратился из академического отпуска',
            'Возвратился из рядов Вооруженных сил',
            'Возвратился из ранее отчисленных',
            'Другие причины',
            'На условиях свободного приема',
            'На условиях свободного приема (обучение по ускоренным программам)',
            'Переведен из других профессиональных образовательных организаций и образовательных организаций высшего образования',
            'Переведен с других форм обучения данной профессиональной образовательной организации',
            'По результатам ЕГЭ',
            'По результатам ЕГЭ и дополнительных вступительных испытаний',
            'По результатам вступительных испытаний, проводимых образовательным учреждением',
            'По результатам государственной (итоговой) аттестации, проводимой экзаменационными комиссиями',
            'По среднему баллу аттестата',
            'По среднему баллу аттестата и дополнительным вступительным испытаниям'
        ];
        foreach ($titles as $title) {
            \App\Models\EnrollmentReason::create(['title' => $title, 'is_global' => 1]);
        }
        Schema::table('candidates', function (Blueprint $table) {
            $table->integer('enrollment_reason_id')->unsigned()->nullable()->default(5);
            $table->foreign('enrollment_reason_id')->references('id')->on('enrollment_reasons')->onUpdate('NO ACTION')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('enrollment_reasons');
    }
}
