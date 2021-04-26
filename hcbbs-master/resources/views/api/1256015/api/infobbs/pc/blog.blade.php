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

@include($templateDir . '.category')
<a name="0"></a>

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')

<br clear="all">


<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td>
         {{-- 記事データが存在するとき --}}
         @foreach ($blogs as $item)


         <table width="100%" border="0" cellspacing="0" cellpadding="0" class="SE-mb20">
            <tr>
               <td nowrap="" class="infobbs_title02">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                        <td>
                           <div class="font_black font12" align="left">[{{ $item->base_name }}]&nbsp;{{ $item->title }}</div>
                        </td>
                        <td>
                           <div class="font_black font10" align="right">
                              <?php
                              $time = strtotime($item->updated_at);
                              /*if (!empty($item->from_date)) {
                                 $time = strtotime($item->from_date);
                              }*/
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
               <td valign="top" bgcolor="#FFFFFF" align="left">
                  <font size="2">
                        {{-- ページネーションの読み込み --}}
                        @include('api.common.api.infobbs.image_list_default')
                        
                        <?php
                        // 記事が改行が必要かの判定
                        $item->comment = str_replace('[NOW_TIME]', time(), $item->comment);
                        $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
                        if (strtotime($item->created_at) < strtotime('2020-05-01')) {
                           $item->comment = preg_replace('/<p>[\r\n]+?<\/p>/', '<p><br /></p>', $item->comment);
                        }
                        ?>
                        @if ($hasNoBr)
                        {!! nl2br( $item->comment ) !!}
                        @else
                        {!! $item->comment !!}
                        @endif
                        
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
                  </table>
               </td>
            </tr>
            
            {{-- 設定ファイルのコメント機能NOのとき --}}
            @if( $para_list['comment'] === '1' )
               <tr>
                  <td align="right">
                     <table>
                        @if (!empty($item->category))
                        <tr>
                           <td align="right" valign="middle">
                                 <font style="font-size:8px;">カテゴリ:{{ $item->category }}</font>&nbsp;
                           </td>
                        </tr>
                        @endif
                        <tr>
                           <td align="left" valign="middle">
                                 <div class="hakusyu font10">
                                    この記事の感想：{{ $CodeUtil::getBlogCommentCountTotal( $hanshaCode, $item->number  ) }}件 
                                 </div>
   
                                 {{-- 感想の一覧にデータが存在するとき --}}
                                 <?php
                                 // コメント件数
                                 $commentCount = $CodeUtil::getBlogCommentCountTotal( $hanshaCode, $item->number  );
                                 // 感想の一覧を取得
                                 $commentList = $CodeUtil::getBlogCommentCountList( $hanshaCode, $item->number );
                                 $formUrl = $CodeUtil::getV2Url('Api\CommentPostController@getIndex', $hanshaCode);
                                 $formUrl .= "?hansha_code={$hanshaCode}&blog_data_id={$item->number}&style=default";
                                 ?>
                                 @if( !$commentList->isEmpty() )
                                    @foreach ( $commentList as $commentValue )
                                    @if (empty($commentValue->mark))
                                          @continue
                                    @endif
                                    <div class="hakusyu">
                                          <img src="{{ asset_auto( 'img/hakusyu/' . $commentValue->mark . '.png' ) }}" style="width: 20px !important;">{{ $commentValue->comment_count }}
                                    </div>
                                    @endforeach
                                 @endif

                                 <div class="hakusyu font10">
                                    <button onClick="window.open( '{{ $formUrl }}','_blank','width=300,height=550,scrollbars=yes');return false;">感想を送る</button>
                                 </div>
                           </td>
                        </tr>
                     </table>
                  </td>
               </tr>
            @endif
            </table>
         @endforeach

         <!-- ZERO END -->

         {{-- ページネーションの読み込み --}}
         @include($templateDir . '.pagination')
         
      </td>
   </tr>
</table>

</font>

