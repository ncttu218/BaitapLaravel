<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbActionTable extends Migration {

    /**
     * tb_actionを作成するコマンド
     * インポートするデータ
     * ・活動リスト（基本）.csv
     * ・活動リスト（個別）.csv
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tb_action');
        Schema::create('tb_action', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('act_inspection_id')->nullable();
            $table->string('act_inspection_ym');
            $table->string('act_flg');
            $table->string('act_car_manage_number');
            $table->string('act_base_code')->nullable();
            $table->string('act_base_name')->nullable();
            $table->string('act_user_id')->nullable();
            $table->string('act_user_name')->nullable();
            $table->string('act_customer_code')->nullable();
            $table->string('act_car_taisyo_number')->nullable();
            $table->string('act_action_code')->nullable();
            $table->string('act_action_name')->nullable();
            $table->integer('act_customer_id')->nullable();
            $table->string('act_customer_name_kanji')->nullable();
            $table->string('act_customer_name_kata')->nullable();
            $table->string('act_customer_address')->nullable();
            $table->string('act_customer_tel')->nullable();
            $table->string('act_car_base_number')->nullable();
            $table->string('act_car_frame_number')->nullable();
            $table->string('act_car_name')->nullable();
            $table->integer('act_syaken_times')->nullable();
            $table->date('act_syaken_next_date')->nullable();
            $table->date('act_contact_day')->nullable();
            $table->string('act_contact_time')->nullable();
            $table->integer('act_status')->default(0)->nullable();
            $table->integer('act_action')->default(0)->nullable();
            $table->text('act_memo')->nullable();
            $table->integer('act_mikomi_id')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by');
            $table->string('updated_by');
        });

        DB::statement("COMMENT ON COLUMN tb_action.id IS 'シリアルID'");
        DB::statement("COMMENT ON COLUMN tb_action.act_inspection_id IS '車点検区分'");
        DB::statement("COMMENT ON COLUMN tb_action.act_inspection_ym IS '対象年月'");
        DB::statement("COMMENT ON COLUMN tb_action.act_flg IS '基本か個別か'");
        DB::statement("COMMENT ON COLUMN tb_action.act_car_manage_number IS '統合車両管理ＮＯ'");
        DB::statement("COMMENT ON COLUMN tb_action.act_base_code IS '販売店コード'");
        DB::statement("COMMENT ON COLUMN tb_action.act_base_name IS '拠点略称'");
        DB::statement("COMMENT ON COLUMN tb_action.act_user_id IS '担当者コード'");
        DB::statement("COMMENT ON COLUMN tb_action.act_user_name IS '担当者氏名（漢字）'");
        DB::statement("COMMENT ON COLUMN tb_action.act_customer_code IS '顧客コード'");
        DB::statement("COMMENT ON COLUMN tb_action.act_car_taisyo_number IS '接触対象車'");
        DB::statement("COMMENT ON COLUMN tb_action.act_action_code IS '目的コード'");
        DB::statement("COMMENT ON COLUMN tb_action.act_action_name IS '目的名称'");
        DB::statement("COMMENT ON COLUMN tb_action.act_customer_id IS '顧客データID'");
        DB::statement("COMMENT ON COLUMN tb_action.act_customer_name_kanji IS '顧客漢字氏名'");
        DB::statement("COMMENT ON COLUMN tb_action.act_customer_name_kata IS '顧客名カタカナ'");
        DB::statement("COMMENT ON COLUMN tb_action.act_customer_address IS '＊自宅住所'");
        DB::statement("COMMENT ON COLUMN tb_action.act_customer_tel IS '＊自宅電話番号'");
        DB::statement("COMMENT ON COLUMN tb_action.act_car_base_number IS '＊車両基本登録No'");
        DB::statement("COMMENT ON COLUMN tb_action.act_car_frame_number IS 'フレームＮＯ'");
        DB::statement("COMMENT ON COLUMN tb_action.act_car_name IS '車名（カナ）'");
        DB::statement("COMMENT ON COLUMN tb_action.act_syaken_times IS '車検回数'");
        DB::statement("COMMENT ON COLUMN tb_action.act_syaken_next_date IS '＊次回車検日　YYYY/MM/DD'");
        DB::statement("COMMENT ON COLUMN tb_action.act_contact_day IS '連絡日'");
        DB::statement("COMMENT ON COLUMN tb_action.act_contact_time IS '連絡時間'");
        DB::statement("COMMENT ON COLUMN tb_action.act_status IS '意向結果'");
        DB::statement("COMMENT ON COLUMN tb_action.act_action IS '活動内容'");
        DB::statement("COMMENT ON COLUMN tb_action.act_memo IS '備考'");
        DB::statement("COMMENT ON COLUMN tb_action.act_mikomi_id IS '見込みデータID'");

        DB::statement("COMMENT ON COLUMN tb_action.created_at IS '登録日時'");
        DB::statement("COMMENT ON COLUMN tb_action.updated_at IS '更新日時'");
        DB::statement("COMMENT ON COLUMN tb_action.deleted_at IS '削除フラグ'");
        DB::statement("COMMENT ON COLUMN tb_action.created_by IS '登録者'");
        DB::statement("COMMENT ON COLUMN tb_action.updated_by IS '更新者'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

}
