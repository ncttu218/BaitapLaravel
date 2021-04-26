<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<title>{{ $hanshaCode ? Config('original.hansha_code')[$hanshaCode] : "" }}　スタッフ紹介</title>
</head>
<body bgcolor="#ffffff" text="#000000">
  <center>

    {{-- タイトル文 --}}
    <table cellpadding="3" cellspacing="0" border="0" width="600">
      <tbody>
        <tr>
          <td bgcolor="#0066cc" align="center">
            <font color="#ffffff" style="font-size :12px; lineheight :12px;"><b>
              {{ $hanshaCode ? Config('original.hansha_code')[$hanshaCode] : "" }}　スタッフ紹介
              ／掲載データ編集画面</b><br>
              <br>
            </font>
          </td>
        </tr>
      </tbody>
    </table>
    <br>

    {{-- フォームタグ --}}
    {!! Form::model(
        $staffInfoObj,
        ['method' => 'POST', 'url' => $urlAction, 'files' => true, 'id' => 'formInput']
    ) !!}
      {{ csrf_field() }}
      
      <table width="600" cellpadding="1" cellspacing="0" border="0">
        <tbody>
          <tr>
          <td bgcolor="#000000">
          <table width="100%">
            <tbody>
              {{-- 氏名 --}}
              <tr>
                <td bgcolor="#ccccff">
                  <font color="#000000" style="font-size :12px; lineheight :12px;">
                    氏名
                  </font>
                </td>
                <td bgcolor="#ffffff">
                  <font color="#000000" style="font-size :12px; lineheight :12px;">
                    {{ Form::text( 'name', null, ['size' => '50'] ) }}
                  </font>
                </td>
              </tr>

              {{-- 所属・役職 --}}
              <tr>
                <td bgcolor="#ccccff">
                  <font color="#000000" style="font-size :12px; lineheight :12px;">
                    所属・役職
                  </font>
                </td>
                <td bgcolor="#ffffff">
                  <font color="#000000" style="font-size :12px; lineheight :12px;">
                    <?php
                    // 肩書の一覧
                    $degreeList = collect( $CodeUtil::getDegreeList() );
                    $degreeList->prepend( "", "" );
                    ?>
                    {{ Form::select('degree', $degreeList, null, ['size' => '1'] ) }}
                  </font>
                </td>
              </tr>

              {{-- 等級 --}}
              <tr>
                <td bgcolor="#ccccff">
                  <font color="#000000" style="font-size :12px; lineheight :12px;">
                    等級
                  </font>
                </td>
                <td bgcolor="#ffffff">
                  {{ Form::text( 'grade', null, ['size' => '5'] ) }}
                  ※半角数字で入力してください
                </td>
              </tr>

              {{-- 掲載写真 --}}
              <tr>
                <td bgcolor="#ccccff">
                  <font color="#000000" style="font-size :12px; lineheight :12px;">
                    掲載写真
                  </font>
                </td>
                <td bgcolor="#ffffff">
                  <font color="#000000" style="font-size :12px; lineheight :12px;">
                    {{ Form::file('photo') }}<br>
                    <font color="#ff0000" style="font-size :10px; lineheight :10px;">
                      注意・ファイル名に日本語（半角カナ・全角文字）は使えません！
                    </font><br>
                  </font>

                  {{-- 掲載写真の表示 --}}
                  @if( !empty( $staffInfoObj->photo ) )
                    <br>
                    @if (strstr($staffInfoObj->photo, 'data/image/' . $hanshaCode))
                        <img src="{{ asset_auto( $staffInfoObj->photo ) }}" border="0" height="150" f6="">
                    @else
                        <img src="{{ asset_auto( 'data/image/' . $hanshaCode . '/' . $staffInfoObj->photo ) }}" border="0" height="150" f6="">
                    @endif
                  @endif
                  
                </td>
              </tr>

              {{-- 血液型 --}}
              <tr> 
                <td bgcolor="#CCCCFF">
                  <font color="#000000" style="font-size :12px; lineheight :12px;">
                    血液型
                  </font>
                </td>
                <td bgcolor="#ffffff">
                  <font color="#000000" style="font-size :12px; lineheight :12px;"> 
                    {{ Form::text( 'ext_value1', null, ['size' => '50'] ) }}
                  </font>
                </td>
              </tr>

              {{-- 出身 --}}
              <tr> 
                <td bgcolor="#CCCCFF">
                  <font color="#000000" style="font-size :12px; lineheight :12px;">
                    出身
                  </font>
                </td>
                <td bgcolor="#ffffff">
                  <font color="#000000" style="font-size :12px; lineheight :12px;"> 
                    {{ Form::text( 'ext_value2', null, ['size' => '50'] ) }}
                  </font>
                </td>
              </tr>

              {{-- 資格 --}}
              <tr> 
                <td bgcolor="#CCCCFF">
                  <font color="#000000" style="font-size :12px; lineheight :12px;">
                    資格
                  </font>
                </td>
                <td bgcolor="#ffffff">
                  <font color="#000000" style="font-size :12px; lineheight :12px;">
                    {{ Form::text( 'ext_value3', null, ['size' => '50'] ) }}<br>
                    {{ Form::text( 'ext_value3_2', null, ['size' => '50'] ) }}<br>
                    {{ Form::text( 'ext_value3_3', null, ['size' => '50'] ) }}<br>
                    {{ Form::text( 'ext_value3_4', null, ['size' => '50'] ) }}<br>
                    {{ Form::text( 'ext_value3_5', null, ['size' => '50'] ) }}<br>
                    {{ Form::text( 'ext_value3_6', null, ['size' => '50'] ) }}<br>
                  </font>
                </td>
              </tr>

              {{-- 愛してやまないもの --}}
              <tr> 
                <td bgcolor="#CCCCFF"> 
                  <font color="#000000" style="font-size :12px; lineheight :12px;">
                    愛してやまないもの
                  </font>
                </td>
                <td bgcolor="#ffffff">
                  <font color="#000000" style="font-size :12px; lineheight :12px;">
                    {{ Form::text( 'ext_value4', null, ['size' => '50'] ) }}<br>
                    {{ Form::text( 'ext_value4_2', null, ['size' => '50'] ) }}<br>
                    {{ Form::text( 'ext_value4_3', null, ['size' => '50'] ) }}<br>
                    {{ Form::text( 'ext_value4_4', null, ['size' => '50'] ) }}<br>
                    {{ Form::text( 'ext_value4_5', null, ['size' => '50'] ) }}<br>
                    {{ Form::text( 'ext_value4_6', null, ['size' => '50'] ) }}<br>
                  </font>
                </td>
              </tr>

              {{-- コメント --}}
              <tr>
                <td bgcolor="#ccccff">
                  <font color="#000000" style="font-size :12px; lineheight :12px;">
                    コメント
                  </font>
                </td>
                <td bgcolor="#ffffff">
                  <font color="#ff0000" style="font-size :12px; lineheight :12px;">
                    {{ Form::textarea('comment', null, ['cols' => '60', 'rows' => '15'] ) }}
                  </font>
                </td>
              </tr>

              {{-- 店舗 --}}
              <tr>
                <td bgcolor="#ccccff">
                  <font color="#000000" style="font-size :12px; lineheight :12px;">
                  店舗
                  </font>
                </td>
                <td bgcolor="#ffffff">
                  <font color="#000000" style="font-size :12px; lineheight :12px;">
                    <?php
                    // ログイン販社の拠点一覧を取得する
                    $shopList = App\Models\Base::getShopOptions( $loginAccountObj->gethanshaCode() );
                    $shopList->prepend( "", "" );
                    ?>
                    {{ Form::select('shop', $shopList, null, ['size' => '1'] ) }}
                  </font>
                </td>
              </tr>
            </tbody>
          </table><br>

          {{-- 削除・次へボタン --}}
          @if ( $type != 'create' )
            <input type="submit" name="erase" value="このデータを削除" onclick="invalidate()">
          @else
            <input type="submit" name="cancel" value="キャンセル">
          @endif
          <input type="submit" name="submit" value="次へ" onclick="invalidate()"><br>
          </td>
          </tr>
        </tbody>
      </table>
      
      @if ( $type != 'create' )
        <input type="hidden" name="id" value="{{ $staffInfoObj->id }}">
      @endif
      <input type="hidden" name="number" value="{{ $staffInfoObj->number }}">
    {!! Form::close() !!}
  </center>

<script src="{{ asset_auto('js/vendor/jquery.min.js') }}"></script>
<script type="text/javascript">
/**
 * 計画設定フォームで変わった値のチェック変数
 */
var $form = $('form#formInput'),
    origForm = $form.serialize(),
    invalidateForm = false;
    
/**
 * ページを離れる確認を外すフラグ
 * 
 * @returns {void}
 */
var invalidate = function() {
    invalidateForm = true;
}
// ページを離れる確認メッセージ
$(window).bind('beforeunload', function(e){
    if ($form.serialize() !== origForm && !invalidateForm) {
        return 'このページを離れますか？';
    }
});
</script>
</body>
</html>