<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbOutput extends Migration {

    /**
     * tb_outputの作成コマンド
     * インポートするデータ
     * ・出荷台数.csv
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tb_output');
        Schema::create('tb_output', function(Blueprint $table) {
            $table->increments('id');
            $table->string('op_base_code')->nullable();
            $table->string('op_base_name')->nullable();
            $table->string('op_kanri_number')->nullable();
            $table->integer('op_hosyo_seikyu')->nullable();
            $table->integer('op_recall_zumi')->nullable();
            $table->integer('op_syukka_zumi_flg')->nullable();
            $table->integer('op_shincyoku_c')->nullable();
            $table->string('op_reception_date')->nullable();
            $table->string('op_registered_number')->nullable();
            $table->string('op_syuri_kubun')->nullable();
            $table->string('op_syuri_name')->nullable();
            $table->integer('op_raiten_kubun')->nullable();
            $table->string('op_mileage')->nullable();
            $table->string('op_customer_name_kanji')->nullable();
            $table->string('op_user_id')->nullable();
            $table->string('op_user_name')->nullable();
            $table->string('op_car_model')->nullable();
            $table->string('op_car_frame_number')->nullable();
            $table->string('op_first_regist_date_ym')->nullable();
            $table->string('op_cust_reg_date')->nullable();
            $table->string('op_car_name')->nullable();
            $table->integer('op_kanrinai_flg')->nullable();
            $table->string('op_total_parts')->nullable();
            $table->string('op_total_fat_and_oil')->nullable();
            $table->string('op_total_articles')->nullable();
            $table->string('op_total_wage')->nullable();
            $table->string('op_outsource_total_wage')->nullable();
            $table->string('op_genka_parts')->nullable();
            $table->string('op_genka_fat_and_oil')->nullable();
            $table->string('op_genka_articles')->nullable();
            $table->string('op_outsource_genka')->nullable();
            $table->string('op_outsource_genka_parts')->nullable();
            $table->string('op_outsource_genka_fat_and_oil')->nullable();
            $table->string('op_outsource_genka_wage')->nullable();
            $table->string('op_nouhin_total_parts')->nullable();
            $table->string('op_nouhin_total_fat_and_oil')->nullable();
            $table->string('op_nouhin_total_articles')->nullable();
            $table->string('op_nouhin_total_wage')->nullable();
            $table->string('op_nouhin_outsource_total_wage')->nullable();
            $table->string('op_nouhin_genka_parts')->nullable();
            $table->string('op_nouhin_genka_fat_and_oil')->nullable();
            $table->string('op_nouhin_genka_articles')->nullable();
            $table->string('op_nouhin_outsource_genka')->nullable();
            $table->string('op_nouhin_outsource_genka_parts')->nullable();
            $table->string('op_nouhin_outsource_genka_fat_and_oil')->nullable();
            $table->string('op_nouhin_outsource_genka_wage')->nullable();
            $table->string('op_hosyo_total_parts')->nullable();
            $table->string('op_hosyo_total_fat_and_oil')->nullable();
            $table->string('op_hosyo_total_articles')->nullable();
            $table->string('op_hosyo_total_wage')->nullable();
            $table->string('op_hosyo_outsource_total_wage')->nullable();
            $table->string('op_hosyo_genka_parts')->nullable();
            $table->string('op_hosyo_genka_fat_and_oil')->nullable();
            $table->string('op_hosyo_genka_articles')->nullable();
            $table->string('op_hosyo_outsource_genka')->nullable();
            $table->string('op_hosyo_outsource_genka_parts')->nullable();
            $table->string('op_hosyo_outsource_genka_fat_and_oil')->nullable();
            $table->string('op_hosyo_outsource_genka_wage')->nullable();
            $table->string('op_recall_total_parts')->nullable();
            $table->string('op_recall_total_fat_and_oil')->nullable();
            $table->string('op_recall_total_articles')->nullable();
            $table->string('op_recall_total_wage')->nullable();
            $table->string('op_recall_outsource_total_wage')->nullable();
            $table->string('op_genka_genka_parts')->nullable();
            $table->string('op_genka_genka_fat_and_oil')->nullable();
            $table->string('op_genka_genka_articles')->nullable();
            $table->string('op_genka_outsource_genka')->nullable();
            $table->string('op_genka_outsource_genka_parts')->nullable();
            $table->string('op_genka_outsource_genka_fat_and_oil')->nullable();
            $table->string('op_genka_outsource_genka_wage')->nullable();
            $table->string('op_syanai_total_parts')->nullable();
            $table->string('op_syanai_total_fat_and_oil')->nullable();
            $table->string('op_syanai_total_articles')->nullable();
            $table->string('op_syanai_total_wage')->nullable();
            $table->string('op_syanai_outsource_total_wage')->nullable();
            $table->string('op_syanai_genka_parts')->nullable();
            $table->string('op_syanai_genka_fat_and_oil')->nullable();
            $table->string('op_syanai_genka_articles')->nullable();
            $table->string('op_syanai_outsource_genka')->nullable();
            $table->string('op_syanai_outsource_genka_parts')->nullable();
            $table->string('op_syanai_outsource_genka_fat_and_oil')->nullable();
            $table->string('op_syanai_outsource_genka_wage')->nullable();
            $table->string('op_shipment_date')->nullable();
            $table->string('op_shipment_kessai_kubun')->nullable();
            $table->string('op_price_nebiki')->nullable();
            $table->string('op_price_kensa_tesuryo')->nullable();
            $table->string('op_price_muryo_denpyo')->nullable();
            $table->string('op_teiki_meinte_flg')->nullable();
            $table->string('op_entyo_hosyo_flg')->nullable();
            $table->string('op_price_parts')->nullable();
            $table->string('op_price_fat_and_oil')->nullable();
            $table->string('op_price_articles')->nullable();
            $table->string('op_price_wage')->nullable();
            $table->string('op_seibi_sum')->nullable();
            $table->string('op_nebiki')->nullable();
            $table->string('op_tax_seibi_sum')->nullable();
            $table->string('op_uriage')->nullable();
            $table->string('op_genka')->nullable();
            $table->string('op_arari')->nullable();
            $table->string('op_nebiki_parts_price')->nullable();
            $table->string('op_nebiki_fat_and_oil_price')->nullable();
            $table->string('op_nebiki_articles_price')->nullable();
            $table->string('op_nebiki_wage_price')->nullable();
            $table->string('op_car_manage_number_yomikomi')->nullable();
            $table->string('op_car_manage_number_sinki')->nullable();
            $table->string('op_car_manage_number')->nullable();
            $table->string('op_syaken_next_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        DB::statement("COMMENT ON COLUMN tb_output.id IS 'シリアルID'");
        DB::statement("COMMENT ON COLUMN tb_output.op_base_code IS '拠点'");
        DB::statement("COMMENT ON COLUMN tb_output.op_base_name IS '拠点略称'");
        DB::statement("COMMENT ON COLUMN tb_output.op_kanri_number IS '管理番号'");
        DB::statement("COMMENT ON COLUMN tb_output.op_hosyo_seikyu IS '保証サービス請求書'");
        DB::statement("COMMENT ON COLUMN tb_output.op_recall_zumi IS 'ﾘｺｰﾙ請求書発行済'");
        DB::statement("COMMENT ON COLUMN tb_output.op_syukka_zumi_flg IS '出荷済'");
        DB::statement("COMMENT ON COLUMN tb_output.op_shincyoku_c IS '進捗区分Ｃ'");
        DB::statement("COMMENT ON COLUMN tb_output.op_reception_date IS '* 受付日 YYYYMMDD'");
        DB::statement("COMMENT ON COLUMN tb_output.op_registered_number IS '登録番号'");
        DB::statement("COMMENT ON COLUMN tb_output.op_syuri_kubun IS '修理区分'");
        DB::statement("COMMENT ON COLUMN tb_output.op_syuri_name IS '修理区分名称'");
        DB::statement("COMMENT ON COLUMN tb_output.op_raiten_kubun IS '来店区分'");
        DB::statement("COMMENT ON COLUMN tb_output.op_mileage IS '走行距離'");
        DB::statement("COMMENT ON COLUMN tb_output.op_customer_name_kanji IS '顧客名'");
        DB::statement("COMMENT ON COLUMN tb_output.op_user_id IS '営業担当者コード'");
        DB::statement("COMMENT ON COLUMN tb_output.op_user_name IS '営業担当者氏名（漢字）'");
        DB::statement("COMMENT ON COLUMN tb_output.op_car_model IS 'フレーム型式'");
        DB::statement("COMMENT ON COLUMN tb_output.op_car_frame_number IS 'フレーム号機'");
        DB::statement("COMMENT ON COLUMN tb_output.op_first_regist_date_ym IS '* 初度登録年月日 YYYYMMDD'");
        DB::statement("COMMENT ON COLUMN tb_output.op_cust_reg_date IS '* 登録年月日'");
        DB::statement("COMMENT ON COLUMN tb_output.op_car_name IS '車名・通称名下１０桁'");
        DB::statement("COMMENT ON COLUMN tb_output.op_kanrinai_flg IS '顧客管理内外'");
        DB::statement("COMMENT ON COLUMN tb_output.op_total_parts IS '部品合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_total_fat_and_oil IS '油脂合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_total_articles IS '用品合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_total_wage IS '工賃合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_outsource_total_wage IS '外注合計工賃'");
        DB::statement("COMMENT ON COLUMN tb_output.op_genka_parts IS '部品原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_genka_fat_and_oil IS '油脂原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_genka_articles IS '用品原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_outsource_genka IS '外注原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_outsource_genka_parts IS '外注部品原価合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_outsource_genka_fat_and_oil IS '外注油脂原価合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_outsource_genka_wage IS '外注工賃原価合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_nouhin_total_parts IS '(納品請求書)部品合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_nouhin_total_fat_and_oil IS '(納品請求書)油脂合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_nouhin_total_articles IS '(納品請求書)用品合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_nouhin_total_wage IS '(納品請求書)工賃合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_nouhin_outsource_total_wage IS '(納品請求書)外注工賃合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_nouhin_genka_parts IS '(納品請求書)部品原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_nouhin_genka_fat_and_oil IS '(納品請求書)油脂原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_nouhin_genka_articles IS '(納品請求書)用品原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_nouhin_outsource_genka IS '(納品請求書)外注原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_nouhin_outsource_genka_parts IS '(納品請求書)外注部品原価合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_nouhin_outsource_genka_fat_and_oil IS '(納品請求書)外注油脂原価合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_nouhin_outsource_genka_wage IS '(納品請求書)外注工賃原価合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_hosyo_total_parts IS '(保証サービス請求書)部品合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_hosyo_total_fat_and_oil IS '(保証サービス請求書)油脂原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_hosyo_total_articles IS '(保証サービス請求書)用品合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_hosyo_total_wage IS '(保証サービス請求書)工賃合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_hosyo_outsource_total_wage IS '(保証サービス請求書)外注工賃合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_hosyo_genka_parts IS '(保証サービス請求書)部品原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_hosyo_genka_fat_and_oil IS '(保証サービス請求書)油脂原価計_2'");
        DB::statement("COMMENT ON COLUMN tb_output.op_hosyo_genka_articles IS '(保証サービス請求書)用品原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_hosyo_outsource_genka IS '(保証サービス請求書)外注原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_hosyo_outsource_genka_parts IS '(保証サービス請求書)外注部品原価合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_hosyo_outsource_genka_fat_and_oil IS '(保証サービス請求書)外注油脂原価合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_hosyo_outsource_genka_wage IS '(保証サービス請求書)外注工賃原価合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_recall_total_parts IS '(リコール請求書)部品合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_recall_total_fat_and_oil IS '(リコール請求書)油脂合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_recall_total_articles IS '(リコール請求書)用品合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_recall_total_wage IS '(リコール請求書)工賃合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_recall_outsource_total_wage IS '(リコール請求書)外注工賃合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_genka_genka_parts IS '(リコール請求書)部品原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_genka_genka_fat_and_oil IS '(リコール請求書)油脂原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_genka_genka_articles IS '(リコール請求書)用品原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_genka_outsource_genka IS '(リコール請求書)外注原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_genka_outsource_genka_parts IS '(リコール請求書)外注部品原価合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_genka_outsource_genka_fat_and_oil IS '(リコール請求書)外注油脂原価合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_genka_outsource_genka_wage IS '(リコール請求書)外注工賃原価合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_syanai_total_parts IS '(社内サービス)部品合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_syanai_total_fat_and_oil IS '(社内サービス)油脂合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_syanai_total_articles IS '(社内サービス)用品合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_syanai_total_wage IS '(社内サービス)工賃合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_syanai_outsource_total_wage IS '(社内サービス)外注工賃合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_syanai_genka_parts IS '(社内サービス)部品原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_syanai_genka_fat_and_oil IS '(社内サービス)油脂原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_syanai_genka_articles IS '(社内サービス)用品原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_syanai_outsource_genka IS '(社内サービス)外注原価計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_syanai_outsource_genka_parts IS '(社内サービス)外注部品原価合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_syanai_outsource_genka_fat_and_oil IS '(社内サービス)外注油脂原価合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_syanai_outsource_genka_wage IS ' (社内サービス)外注工賃原価合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_shipment_date IS '* 出荷報告日 YYYYMMDD'");
        DB::statement("COMMENT ON COLUMN tb_output.op_shipment_kessai_kubun IS '出荷報告決済区分'");
        DB::statement("COMMENT ON COLUMN tb_output.op_price_nebiki IS '値引金額'");
        DB::statement("COMMENT ON COLUMN tb_output.op_price_kensa_tesuryo IS '検査手続料'");
        DB::statement("COMMENT ON COLUMN tb_output.op_price_muryo_denpyo IS '無料Ｖ伝票発行日/金額'");
        DB::statement("COMMENT ON COLUMN tb_output.op_teiki_meinte_flg IS '定期ﾒﾝﾃﾌﾗｸﾞ'");
        DB::statement("COMMENT ON COLUMN tb_output.op_entyo_hosyo_flg IS '延長保証ﾌﾗｸﾞ'");
        DB::statement("COMMENT ON COLUMN tb_output.op_price_parts IS '部品代'");
        DB::statement("COMMENT ON COLUMN tb_output.op_price_fat_and_oil IS '油脂代'");
        DB::statement("COMMENT ON COLUMN tb_output.op_price_articles IS '用品代'");
        DB::statement("COMMENT ON COLUMN tb_output.op_price_wage IS '工賃'");
        DB::statement("COMMENT ON COLUMN tb_output.op_seibi_sum IS '整備代合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_nebiki IS '値引'");
        DB::statement("COMMENT ON COLUMN tb_output.op_tax_seibi_sum IS '課税対象整備代合計'");
        DB::statement("COMMENT ON COLUMN tb_output.op_uriage IS 'Ｕ(売上)'");
        DB::statement("COMMENT ON COLUMN tb_output.op_genka IS 'Ｇ(原価)'");
        DB::statement("COMMENT ON COLUMN tb_output.op_arari IS 'Ａ(粗利)'");
        DB::statement("COMMENT ON COLUMN tb_output.op_nebiki_parts_price IS '部品値引金額'");
        DB::statement("COMMENT ON COLUMN tb_output.op_nebiki_fat_and_oil_price IS '油脂値引金額'");
        DB::statement("COMMENT ON COLUMN tb_output.op_nebiki_articles_price IS '用品値引金額'");
        DB::statement("COMMENT ON COLUMN tb_output.op_nebiki_wage_price IS '工賃値引金額'");
        DB::statement("COMMENT ON COLUMN tb_output.op_car_manage_number_yomikomi IS '統合車両管理no 読込'");
        DB::statement("COMMENT ON COLUMN tb_output.op_car_manage_number_sinki IS '統合車両管理no 新規'");
        DB::statement("COMMENT ON COLUMN tb_output.op_car_manage_number IS '統合車両管理no ＩＦ'");
        DB::statement("COMMENT ON COLUMN tb_output.op_syaken_next_date IS '* 車検満了日 YYYYMMDD'");
        DB::statement("COMMENT ON COLUMN tb_output.created_at IS '登録日時'");
        DB::statement("COMMENT ON COLUMN tb_output.updated_at IS '更新日時'");
        DB::statement("COMMENT ON COLUMN tb_output.deleted_at IS '削除フラグ'");
        DB::statement("COMMENT ON COLUMN tb_output.created_by IS '登録者'");
        DB::statement("COMMENT ON COLUMN tb_output.updated_by IS '更新者'");
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
