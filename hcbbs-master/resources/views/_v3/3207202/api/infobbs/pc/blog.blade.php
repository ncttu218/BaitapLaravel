<script language="JavaScript" src="/common-js/opendcs.js"></script>
<link rel="stylesheet" href="/common-css/infobbs_style.css" type="text/css">
<link rel="stylesheet" href="/common-css/cgi_common.css" type="text/css">
<a name="0"></a>
<?php
// ログイン販社の拠点一覧を取得する
$shopList = App\Models\Base::getShopOptions( $hanshaCode, true );
?>
{{-- 拠点選択プルダウンの表示 --}}
<div style="float:left;" align="left">
   <form action="?SortField=DATE" method="get" style="margin:0em;">
      <font style="font-size :10px; lineheight :10px;">お近くのお店を選んで「検索」ボタンをクリックして下さい</font>
      <font size="2">
         <br>
         <select name="shop" id="AutoSelect_27">
            <option value=""></option>
            <option value="">全店</option>
            @foreach( $shopList as $base_code => $base_name )
                <option value="{{ $base_code }}"{{ $shopCode == $base_code ? ' selected' : '' }}>{{ $base_name }}</option>
            @endforeach
         </select>
         <input type="submit" value="検索"> 
      </font>
   </form>
</div>
<div style="clear:both;"></div>

{{-- ページネーション --}}
@include($templateDir . '.pagination')

{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="SE-mb20">
      <tr>
         <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
                <td nowrap="" class="infobbs_title02">
                   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                       <td>
                          <div class="font_black" align="left">[{{ $item->base_name }}]&nbsp;{{ $item->title }}</div>
                       </td>
                       <td>
                           <div class="font_black font10" align="right">
                               <?php
                               $time = strtotime($item->updated_at);
                               if (!empty($item->from_date)) {
                                   $time = strtotime($item->from_date);
                               }
                               ?>
                               {{ date('Y/m/d', $time) }}
                           </div>
                       </td>
                    </tr>
                   </table>
                </td>
             </tr>
            </table>
         </td>
      </tr>
      <tr>
         <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="3">
                  <tr>
                     <td valign="top" bgcolor="#FFFFFF" align="left" class="InfobbsArticlesText">
                        <font size="2">
                           <?php
                             // 記事が改行が必要かの判定
                             $item->comment = str_replace('[NOW_TIME]', time(), $item->comment);
                             $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
                             ?>
                             @if ($hasNoBr)
                               {!! nl2br( $item->comment ) !!}
                             @else
                               {!! $item->comment !!}
                             @endif
                           <br>
                           <div class="infobbs_inquiry"><br></div>
                        </font>
                     </td>
                  </tr>
                  <tr>
                     <td valign="top" bgcolor="#FFFFFF">
                        <table border="0" cellspacing="0" cellpadding="1">
                              <tr valign="bottom">
                                 <td bgcolor="#FFFFFF"><font style="font-size:10px;"></font></td>
                                 <td bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                                    </font>
                                 </td>
                                 <td bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                                    </font>
                                 </td>
                              </tr>
                              <tr align="left">
                                 <td valign="top" bgcolor="#FFFFFF" class="SE-w200"><font style="font-size:10px;">
                                    </font>
                                 </td>
                                 <td valign="top" bgcolor="#FFFFFF" class="SE-w200"><font style="font-size:10px;">
                                    </font>
                                 </td>
                                 <td valign="top" bgcolor="#FFFFFF" class="SE-w200"><font style="font-size:10px;">
                                    </font>
                                 </td>
                              </tr>
                        </table>
                     </td>
                  </tr>
            </table>
         </td>
      </tr>
</table>
@endforeach
<!-- ZERO END -->
{{-- ページネーション --}}
@include($templateDir . '.pagination')
