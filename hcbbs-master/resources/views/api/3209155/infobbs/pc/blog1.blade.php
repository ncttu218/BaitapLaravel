<?php
// 販社名の設定パラメータを取得
$para_list = ( Config('original.para')[$hanshaCode] );
?>

<script language="JavaScript" src="/common-js/opendcs.js"></script>
<link rel="stylesheet" href="/common-css/infobbs_style.css" type="text/css">
<link rel="stylesheet" href="/common-css/cgi_common.css" type="text/css">
<a name="0"></a>

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')

<font style="font-size :12px; lineheight :12px;">
   <div style="clear:both;"></div>
   
    {{-- 記事データが存在するとき --}}
    @foreach ($blogs as $item)

   <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tbody>
         <tr>
            <td nowrap="" class="subTitle">
               <div class="subTitle__main">
                  <div class="font_black" align="left">[{{ $item->base_name }}]&nbsp;{{ $item->title }}</div>
               </div>
               <div class="subTitle__en bbsDate">
                   <div class="font_black font10" align="right">
                        <?php
                        $time = strtotime($item->updated_at);
                        if (!empty($item->from_date)) {
                            $time = strtotime($item->from_date);
                        }
                        ?>
                        {{ date('Y/m/d', $time) }}
                   </div>
               </div>
            </td>
         </tr>
         <tr>
            <td>
               <div class="contentsFrame">
                  <table width="100%" border="0" cellspacing="0" cellpadding="3">
                     <tbody>
                        <tr>
                           <td valign="top" bgcolor="#FFFFFF" align="left">
                              <font size="2">
                              <?php
                                // 記事が改行が必要かの判定
                                $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
                                // 絵文字の変換
                                $item->comment = $convertEmojiToHtmlEntity($item->comment);
                                ?>
                                @if ($hasNoBr)
                                  {!! nl2br( $item->comment ) !!}
                                @else
                                  {!! $item->comment !!}
                                @endif
                                <?php
                                $imgFiles = [];
                                // 1 から 3 まで繰り返す 設定ファイルで最大値を変更したほうが良いかも
                                for( $i=1; $i<= 3; $i++ ){
                                  $imgFiles[$i]['file'] = $item->{'file' . $i};
                                  $imgFiles[$i]['caption'] = $item->{'caption' . $i};
                                }
                                ?>
                                {{-- 定形画像が入力されていれば、画面に出力する。 --}}
                                @if( !empty( $imgFiles ) == True )
                                  <div>
                                    <font> 
                                      {{-- 定形画像の数分繰り返す --}}
                                      @for( $i=1; $i<= 3; $i++ )
                                        @if( !empty( $imgFiles[$i]['file'] ) == True )
                                          <?php
                                          // ファイルパスの情報を取得する
                                          $fileinfo = pathinfo( $imgFiles[$i]['file'] );
                                          ?>
                                          <br>
                                          <a href="{{ url_auto( $imgFiles[$i]['file'] ) }}"  target="_blank">
                                             {{-- PDFファイルの対応 --}}
                                             @if( strtolower( $fileinfo['extension'] ) === "pdf" )
                                                <img src="{{ $CodeUtil::getPdfThumbnail( $imgFiles[$i]['file'] ) }}" width="160" border=0  f7>
                                             @else
                                                <img src="{{ url_auto( $imgFiles[$i]['file'] ) }}" width="160" border=0  f7>
                                             @endif
                                          </a>
                                          {{-- 画像の説明文が存在するとき --}}
                                          @if( !empty( $imgFiles[$i]['caption'] ) == True )
                                            <p>{{ $imgFiles[$i]['caption'] }}</p>
                                          @endif
                                        @endif
                                      @endfor
                                    </font> 
                                  </div>
                                @endif
                              </font>
                           </td>
                        </tr>
                        <tr>
                           <td valign="top" bgcolor="#FFFFFF" nowrap="">
                              <table border="0" cellspacing="0" cellpadding="1">
                                 <tbody>
                                    <tr valign="bottom" nowrap="" align="left">
                                       <td bgcolor="#FFFFFF"><font style="font-size:10px;"></font></td>
                                       <td bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                                          </font>
                                       </td>
                                       <td bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                                          </font>
                                       </td>
                                    </tr>
                                    <tr align="left" nowrap="">
                                       <td valign="top" bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                                          </font>
                                       </td>
                                       <td valign="top" bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                                          </font>
                                       </td>
                                       <td valign="top" bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                                          </font>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td align="right" colspan="2">
                              {{-- ページネーションの読み込み --}}
                              @include($templateDir . '.comment')
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </td>
         </tr>
      </tbody>
   </table>
    @endforeach
   <!-- ZERO END -->
</font>

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')
