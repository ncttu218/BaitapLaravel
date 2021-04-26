{{-- カテゴリーレイアウトを継承 --}}
@extends('master._master_ja_blank')

{{-- CSSの定義 --}}
@section('css')
@parent
<style type="text/css">
    .p-edit-section__item img{
        max-width: 100%;
        height: auto;
    }
</style>
@stop

{{-- JSの定義 --}}
@section('js')
@parent
<script type="text/javascript" src="{{ asset_auto('js/upload.js') }}"></script>
<script>
var submit_val;
function valSet(v){
    submit_val = v;
}
$(window).on('beforeunload', function() {
    if(submit_val != 'send'){
        return "入力が完了していません。このページを離れますか？";
    }
});
</script>
@stop

{{-- メイン部分の呼び出し --}}
@section('content')
@include('infobbs.attention')

<section class="c-section-container _both-space">
    <h2 class="c-section-title">プロフィール編集</h2>
    
    <div class="p-edit">
        <form class="p-edit-form" enctype="multipart/form-data" action="{{ $urlAction }}" method="post" name="upload">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="p-edit-frame _highlight">
                    <div class="p-edit-frame__head"><em>※必須項目</em></div>
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            {{ $error }}<br/>
                        @endforeach
                    @endif
                    <div class="p-edit-frame__body p-edit-section">

                        <div class="p-edit-section__item">
                            <div class="p-edit-section__head">ふりがな</div>
                            <div class="p-edit-section__body">
                                <input class="c-control-input" type="text" name="name_furi" size="50" value="{{ $data['name_furi'] }}" placeholder="ふりがな">
                            </div>
                        </div>

                        <div class="p-edit-section__item">
                            <div class="p-edit-section__head">氏名<em>※</em></div>
                            <div class="p-edit-section__body">
                                <input class="c-control-input" type="text" name="name" size="50" value="{{ $data['name'] }}" placeholder="氏名">
                            </div>
                        </div>

                        <div class="p-edit-section__item">
                            <div class="p-edit-section__head">役職</div>
                            <div class="p-edit-section__body">
                                <input class="c-control-input" type="text" name="position" size="50" value="{{ $data['position'] }}" placeholder="役職">
                            </div>
                        </div>

                        <div class="p-edit-section__item">
                            <div class="p-edit-section__head">店舗<em>※</em></div>
                            <div class="p-edit-section__body">
                                @include('elements.shop.shop_select', ['id' => 'shop', 'value' => $data['shop']])
                            </div>
                        </div>

                        <div class="p-edit-section__item">
                            <div class="p-edit-section__head">リスト用画像</div>
                            <div class="p-edit-section__body">
                                <!-- 画像差込用ソース -->
                                @if (!empty($data['photo']))
                                <img src="{{ asset_auto($data['photo']) }}" alt="画像">
                                @endif
                                <!-- 画像差込用ソース -->
                                <input type="file" name="photo" accept="image/*">
                                <p class="c-control-checkbox"><input type="checkbox" name="photo1_del" id="この画像を削除する_リスト用"><label for="この画像を削除する_リスト用">この画像を削除する</label></p>
                            </div>
                        </div>

                        <div class="p-edit-section__item">
                            <div class="p-edit-section__head">個人ページ用<br>掲載画像</div>
                            <div class="p-edit-section__body">
                                <!-- 画像差込用ソース -->
                                @if (!empty($data['photo2']))
                                <img src="{{ asset_auto($data['photo2']) }}" alt="画像">
                                @endif
                                <input type="file" name="photo2" accept="image/*">
                                <!-- 画像差込用ソース -->
                                <p class="c-control-checkbox"><input type="checkbox" name="photo2_del" id="この画像を削除する_個人ページ用"><label for="この画像を削除する_個人ページ用">この画像を削除する</label></p>
                            </div>
                        </div>

                        <div class="p-edit-section__item">
                            <div class="p-edit-section__head">スタッフから一言</div>
                            <div class="p-edit-section__body">
                                <textarea class="c-control-textarea" name="msg" rows="5">{{ $data['msg'] }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.p-edit-frame -->

                <div class="p-edit-frame">
                    <div class="p-edit-frame__head">▼以下は必要な部分のみ入力してください。空欄の部分は省略されます。</div>
                    <div class="p-edit-frame__body p-edit-section">
                        <div class="p-edit-section__item">
                            <div class="p-edit-section__head">資格</div>
                            <div class="p-edit-section__body">
                                <textarea class="c-control-textarea" name="lisence" rows="3">{{ $data['lisence'] }}</textarea>
                            </div>
                        </div>
                        <div class="p-edit-section__item">
                            <div class="p-edit-section__head">趣味</div>
                            <div class="p-edit-section__body">
                                <textarea class="c-control-textarea" name="hobby" rows="3">{{ $data['hobby'] }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="p-edit-frame__head">
                        <p>▼以下の入力欄は項目名を自由に編集できます。上記の項目に書きたい項目がない場合ご使用ください。</p>
                        <small>例：尊敬する人・好きな言葉・おすすめの本・おすすめの映画...など</small>
                    </div>
                    <div class="p-edit-frame__body p-edit-section">
                        <div class="p-edit-section__item">
                            <div class="p-edit-section__head">
                                <input class="c-control-input" type="text" name="ext_field1" size="20" value="{{ $data['ext_field1'] }}" placeholder="追加項目名1">
                            </div>
                            <div class="p-edit-section__body">
                                <input class="c-control-input" type="text" name="ext_value1" size="50" value="{{ $data['ext_value1'] }}" placeholder="ここに入力">
                            </div>
                        </div>
                        <div class="p-edit-section__item">
                            <div class="p-edit-section__head">
                                <input class="c-control-input" type="text" name="ext_field2" size="20" value="{{ $data['ext_field2'] }}" placeholder="追加項目名2">
                            </div>
                            <div class="p-edit-section__body">
                                <input class="c-control-input" type="text" name="ext_value2" size="50" value="{{ $data['ext_value2'] }}" placeholder="ここに入力">
                            </div>
                        </div>
                        <div class="p-edit-section__item">
                            <div class="p-edit-section__head">
                                <input class="c-control-input" type="text" name="ext_field3" size="20" value="{{ $data['ext_field3'] }}" placeholder="追加項目名3">
                            </div>
                            <div class="p-edit-section__body">
                                <input class="c-control-input" type="text" name="ext_value3" size="50" value="{{ $data['ext_value3'] }}" placeholder="ここに入力">
                            </div>
                        </div>
                        <div class="p-edit-section__item">
                            <div class="p-edit-section__head">
                                <input class="c-control-input" type="text" name="ext_field4" size="20" value="{{ $data['ext_field4'] }}" placeholder="追加項目名4">
                            </div>
                            <div class="p-edit-section__body">
                                <input class="c-control-input" type="text" name="ext_value4" size="50" value="{{ $data['ext_value4'] }}" placeholder="ここに入力">
                            </div>
                        </div>
                        <div class="p-edit-section__item">
                            <div class="p-edit-section__head">
                                <input class="c-control-input" type="text" name="ext_field5" size="20" value="{{ $data['ext_field5'] }}" placeholder="追加項目名5">
                            </div>
                            <div class="p-edit-section__body">
                                <input class="c-control-input" type="text" name="ext_value5" size="50" value="{{ $data['ext_value5'] }}" placeholder="ここに入力">
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.p-edit-frame -->

                <!--
                        ******************************
                        新規登録の場合はこの欄なし ここから
                        ******************************
                -->
                <div class="c-frame-box">
                    <div class="c-frame-box__head">編集用パスワードの設定・プロフィール表示設定</div>
                    <div class="c-frame-box__body">
                        <p class="c-notes">「編集用パスワード」欄に入力した文字列が個人個人の編集画面へのアクセスパスワードとなります。<br>
                        「編集用パスワード」がないと編集画面にアクセスできませんので、忘れないようにして下さい。<br>
                        また、「編集用パスワード」が漏れますと第三者に改ざんされる危険性がありますので、管理は厳重にお願いいたします。</p>
                        <div class="c-control-edit">
                            <dl class="c-control-edit__item">
                                <dt class="c-control-edit__head">編集用パスワード</dt>
                                <dd class="c-control-edit__body">
                                    <?php
                                    // 新規追加で、編集用パスワードが空の時
                                    if( $mode == "new" && empty( $data['editpass'] ) == True ){
                                        // ログインアカウントから販社コードを取得
                                        $data['editpass'] = $loginAccountObj->gethanshaCode();
                                    }
                                    ?>
                                    <input class="c-control-password" type="text" name="editpass" value="{{ $data['editpass'] }}">
                                </dd>
                            </dl>
                            <dl class="c-control-edit__item">
                                <dt class="c-control-edit__head">プロフィールの表示</dt>
                                <dd class="c-control-edit__body">
                                    <?php
                                    // 新規追加で、プロフィールの表示が空の時
                                    if( $mode == "new" && empty( $data['disp'] ) == True ){
                                        // デフォルト非公開
                                        $data['disp'] = 'nodisp';
                                    }
                                    ?>
                                    <p class="c-control-radio">
                                        <input type="radio" name="disp" value="disp" id="disp_disp"{{ isset($data['disp']) && $data['disp'] == 'disp' ? ' checked="checked"' : '' }}>
                                        <label for="disp_disp">公開</label>
                                    </p>
                                    <p class="c-control-radio">
                                        <input type="radio" name="disp" value="nodisp" id="disp_nodisp"{{ !isset($data['disp']) || empty($data['disp']) || $data['disp'] == 'nodisp' ? ' checked="checked"' : '' }}>
                                        <label for="disp_nodisp">非公開</label>
                                    </p>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <!--
                    ******************************
                    新規登録の場合はこの欄なし ここまで
                    ******************************
                -->

                <div class="p-edit-send">
                    <div class="p-edit-send__checkbox">
                        <p class="c-control-checkbox">
                            <input type="checkbox" name="comp_check" value="OK" id="comp_check"{{ isset($data['comp_check']) && $data['comp_check'] == 'OK' ? ' checked="checked"' : '' }}>
                            <label for="comp_check"><span class="required-icon">※</span>情報掲載内容について、利用規約違反はありません。</label>
                        </p>
                    </div>
                    <p class="p-edit-send__rule"><a href="{{ action_auto('Infobbs\InfobbsController@getRule') }}" target="_blank">利用規約全文を見る</a></p>
                    <div class="p-edit-send__button">
                        <!--<label class="c-entry-button _color-1"><input type="submit" value="投稿内容を確認する" onClick="valSet('send');">投稿内容を確認する</label>-->
                        <a class="c-entry-button _color-1" type="submit" onclick="valSet('send');$('.p-edit-form').submit();return false;">投稿内容を確認する</a>
                    </div>
                </div>

        </form>

    </div>
    <!-- /.p-entrylist -->
</section>
@stop