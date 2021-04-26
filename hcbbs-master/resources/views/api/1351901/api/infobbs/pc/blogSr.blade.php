<?php
// 販社名の設定パラメータを取得
$para_list = ( config('original.para')[$hanshaCode] );
// 店舗除外
$categoryCounterOptions = [ 'shopExclusion' => $shopExclusion ];
?>

<script language="JavaScript" src="/common-js/opendcs.js">
</script>
<link rel="stylesheet" href="/common-css/infobbs_style.css" type="text/css">
<link rel="stylesheet" href="/common-css/cgi_common.css" type="text/css">

<a name="0"></a>

<font style="font-size :12px; lineheight :12px;">
<br clear="all">

{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)

<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tbody>
      <tr>
         <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="SE-mb20">
               <tbody>
                  <tr>
                     <td nowrap="" class="infobbs_title02 blogTitle">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                           <tbody>
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
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
      <tr>
         <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="3">
               <tbody>
                  <tr>
                     <td valign="top" bgcolor="#FFFFFF" align="left">
                        <font size="2">
                            {{-- ページネーションの読み込み --}}
                            @include('api.common.api.infobbs.image_list_default')
                            
                            {!! $item->comment !!}
                            
                            <div class="infobbs_inquiry"><br></div>
                        </font>
                     </td>
                  </tr>
                  <tr>
                     <td valign="top" bgcolor="#FFFFFF">
                        <table border="0" cellspacing="0" cellpadding="1">
                           <tbody>
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
                                 <td valign="top" bgcolor="#FFFFFF">
                                    <div class="SE-w200" style="font-size:10px;"> 
                                    </div>
                                 </td>
                                 <td valign="top" bgcolor="#FFFFFF">
                                    <div class="SE-w200" style="font-size:10px;"> 
                                    </div>
                                 </td>
                                 <td valign="top" bgcolor="#FFFFFF">
                                    <div class="SE-w200" style="font-size:10px;"> 
                                    </div>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
                  
                {{-- 設定ファイルのコメント機能NOのとき --}}
                @if( $para_list['comment'] === '1' )
                    <tr>
                        <td align="right" colspan="2" style="border-bottom-color: #ffffff;">
                            <table>
                              <tr>
                                 <td align="left" valign="middle">
                                    <div class="hakusyu font10">
                                       この記事へのコメント：{{ $CodeUtil::getBlogCommentCountTotal( $hanshaCode, $item->number  ) }}件 
                                    </div>
                                 </td>
                                 <td>
                                    {{-- 感想の一覧にデータが存在するとき --}}
                                    <div class="hakusyu font10">
                                       <button onClick="window.open( '{{ url_auto('/api/comment_post') }}?hansha_code={{ $hanshaCode }}&blog_data_id={{ $item->number }}&style=style0','_blank','width=300,height=550,scrollbars=yes');return false;">コメントする</button>
                                    </div>
                                 </td>
                              </tr>
                            </table>
                        </td>
                    </tr>
                @endif
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>

@endforeach

</font>

<!-- ZERO END -->

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')