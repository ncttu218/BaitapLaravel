<?php
// ログイン販社の拠点一覧を取得する
$shopList = App\Models\Base::getShopOptions( $hanshaCode, true );
unset($shopList['90']);
?>
{{-- 拠点選択プルダウンの表示 --}}
<div style="float:left;" align="left">
   <form action="" method="get" style="margin:0em;">
      <input type="hidden" name="category" value="{{ urldecode($category) }}"/>
      <font style="font-size :10px; lineheight :10px;">お近くのお店を選んで「検索」ボタンをクリックして下さい</font>
      <font size="2">
         <br>
         <select name="shop" id="AutoSelect_27" style="width: 200px;height: 33px;margin-top: 10px;">
            <option value=""></option>
            <option value="">全店</option>
            @foreach( $shopList as $base_code => $base_name )
                <option value="{{ $base_code }}"{{ $shopCode == $base_code ? ' selected' : '' }}>{{ $base_name }}</option>
            @endforeach
         </select>
         <input type=submit value="検索">
      </font>
   </form>
</div>