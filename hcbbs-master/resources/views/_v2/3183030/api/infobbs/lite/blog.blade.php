<script language="JavaScript" src="/common-js/opendcs.js"></script>
<link rel="stylesheet" href="/common-css/infobbs_style.css" type="text/css">
<link rel="stylesheet" href="/common-css/cgi_common.css" type="text/css">
<a name="0"></a>

{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="SE-mb20">
    <tbody>
       <tr>
          <td>
             <table width="100%" border="0" cellspacing="0" cellpadding="0" class="blogTitleTable">
                <tbody>
                   <tr>
                      <td nowrap="" class="infobbs_title02">
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
             <table width="100%" border="0" cellspacing="0" cellpadding="3" class="blogContentsTable">
                <tbody>
                
                {{-- 画像 --}}
                <?php
                $imgFiles = [];
                // 1 から 3 まで繰り返す 設定ファイルで最大値を変更したほうが良いかも
                for( $i=1; $i<= 3; $i++ ){
                  if (empty($item->{'file' . $i})) {
                      continue;
                  }
                  $imgFiles[$i]['thumbnail'] = $item->{'file' . $i};
                  $imgFiles[$i]['caption'] = $item->{'caption' . $i};
                  $imgFiles[$i]['file'] = str_replace('data/image/thumb/thu_', 'data/image/', $item->{'file' . $i});
                }
                ?>
                {{-- 定形画像が入力されていれば、画面に出力する。 --}}
                @if( !empty( $imgFiles ) == True )
                <tr>
                    <td valign="top" bgcolor="#FFFFFF" colspan="3">
                       <table border="0" cellspacing="0" cellpadding="1" class="blogContentsTable">
                          <tbody>
                             <tr valign="bottom">
                                  <div>
                                    <font> 
                                      {{-- 定形画像の数分繰り返す --}}
                                      @for( $i=1; $i<= 3; $i++ )
                                        @if( !empty( $imgFiles[$i]['file'] ) == True )
                                          <td bgcolor="#FFFFFF">
                                            <font style="font-size:10px;">
                                            <br>
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
                                                <img src="{{ url_auto( $imgFiles[$i]['file'] ) }}" width="200" border=0  f7>
                                                @endif
                                             </a>
                                            </font>
                                          </td>
                                        
                                          {{-- 画像の説明文が存在するとき --}}
                                          @if( !empty( $imgFiles[$i]['caption'] ) == True )
                                            <p>{{ $imgFiles[$i]['caption'] }}</p>
                                          @endif
                                        @endif
                                      @endfor
                                    </font> 
                                  </div>
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
                          </tbody>
                       </table>
                    </td>
                   </tr>
                   @endif
                   
                   <tr>
                      <td valign="top" bgcolor="#FFFFFF" align="left">
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
                      <td valign="top" bgcolor="#FFFFFF" nowrap="">
                         <table border="0" cellspacing="0" cellpadding="1" class="blogContentsTable">
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
                            </tbody>
                         </table>
                      </td>
                   </tr>
                </tbody>
             </table>
          </td>
       </tr>
    </tbody>
 </table>
 @endforeach
 <!-- ZERO END -->

{{-- ページネーション --}}
@include($templateDir . '.pagination')
