
<html>
    <head>
        <title>Honda Cars 愛知　各店情報掲示板</title>
        <link rel="stylesheet" href="/css/colorbox.css" />
        <link rel="stylesheet" href="{{ asset_auto('jquery-ui/jquery-ui.css') }}">
        <link rel="stylesheet" href="{{ asset_auto('datetimepicker/jquery.datetimepicker.css') }}">
        <link rel="stylesheet" href="{{ asset_auto('css/style.css') }}">
    </head>
    <body bgcolor="#ffffff" text="#000000" onLoad="top_img();">
    <center>
        <form name=upload ENCTYPE=multipart/form-data action="{{ $urlAction }}" method=post>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type=hidden name=action value=upload>
            <table cellpadding=3 cellspacing=0 border=0 width=600>
                <tr>
                    <td bgcolor="#000055" align=center>
                        <font color="#ffffff" style="font-size :12px; lineheight :12px;">
                            @if ($mode == 'new')
                                <b>新規データ追加画面</b>
                            @else
                                <b>Honda Cars 青山　各店情報掲示板 ／掲載データ編集画面</b>
                            @endif
                            <br>
                            <br>
                        </font>
                    </td>
                </tr>
            </table>

            <table width=600 cellpadding=1 cellspacing=0 border=0>
                <tr>
                    <td bgcolor="#000055"> 
                        <table width=100%>
                            <tr> 
                                <td bgcolor="#EEEEFF">
                                    <font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                    タイトル </font>
                                </td>
                                <td bgcolor="#ffffff">
                                    <font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                    <input type=text name="title" size=50 value="{{ $data['title'] }}">
                                    <br>
                                    <input type=checkbox name=display value="ディスプレイコンテスト参加記事">ディスプレイコンテスト参加記事&nbsp;
                                    <br>
                                    </font>
                                    <font color="#ff00000" style="font-size :10px; lineheight :10px;">※タイトル部分にはタグは使えません。</font><font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                    </font>
                                </td>
                            </tr>
                            <tr> 
                                <td bgcolor="#EEEEFF"> <font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                    掲載写真 </font> </td>
                                <td bgcolor="#ffffff"> <font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                    </font>
                                    @if ($mode == 'new')
                                    <table width="100%" border="0" cellspacing="2" cellpadding="2">
                                        <tr> 
                                            <td>写真１</td>
                                            <td><font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                                <input type=file name="file1">
                                                </font></td>
                                        </tr>
                                        <tr> 
                                            <td>写真１のコメント</td>
                                            <td> 
                                                <input type="text" name="caption1" size="40">
                                            </td>
                                        </tr>
                                        <tr> 
                                            <td>写真２</td>
                                            <td><font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                                <input type=file name="file2">
                                                </font></td>
                                        </tr>
                                        <tr> 
                                            <td>写真２のコメント</td>
                                            <td> 
                                                <input type="text" name="caption2" size="40">
                                            </td>
                                        </tr>
                                        <tr> 
                                            <td>写真３</td>
                                            <td><font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                                <input type=file name="file3">
                                                </font></td>
                                        </tr>
                                        <tr> 
                                            <td>写真３のコメント</td>
                                            <td> 
                                                <input type="text" name="caption3" size="40">
                                            </td>
                                        </tr>
                                    </table>
                                    @else
                                    <table width="100%" border="0" cellspacing="2" cellpadding="2">
                                        <tbody>
                                            @for ($i = 1;$i <= 3; $i++)
                                            <?php
                                            $imageColumnName = "file{$i}";
                                            $captionColumnName = "caption{$i}";
                                            ?>
                                            <tr>
                                                <td>
                                                    <font color="#000000" style="font-size :12px; lineheight :12px;">
                                                        <font color="#000099" style="font-size :10px; lineheight :10px;">
                                                            @if (!empty($data[$imageColumnName]))
                                                            <font style="font-size:8px;">画像をクリックすると拡大表示できます</font>
                                                            <br>
                                                            <a href="{{ asset_auto($data[$imageColumnName]) }}" target="_blank">
                                                                <img src="{{ asset_auto($data[$imageColumnName]) }}" width="200" border="0">
                                                            </a>
                                                            @endif
                                                        </font>
                                                    </font>
                                                </td>
                                                <td>
                                                    <font color="#000000" style="font-size :12px; lineheight :12px;" size="1"> 
                                                    写真の変更<br>
                                                    <input type="file" name="{{ $imageColumnName }}">
                                                    </font><font size="1"><br>
                                                    コメント<br>
                                                    <input type="text" name="{{ $captionColumnName }}" size="40" value="{{ $data[$captionColumnName] ?? '' }}">
                                                    <br>
                                                    </font><font color="#000000" style="font-size :12px; lineheight :12px;"><font color="#000099" style="font-size :10px; lineheight :10px;">
                                                    <input type="checkbox" name="file1_del" value="del" id="fileDelete_{{ $i }}">
                                                    この画像を削除</font> </font><font size="1"> </font>
                                                </td>
                                            </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                    @endif
                                    <font color="#ff0000" style="font-size :10px; lineheight :10px;"> 
                                    注意・ファイル名に日本語（半角カナ・全角文字）は使えません！ </font><br>
                                    <font color="#000099" style="font-size :10px; lineheight :10px;"> 
                                    半角英数字のファイル名を使用して下さい。 <br>
                                    一覧ページでの掲載写真は横幅２００ピクセルになります。</font><br>
                                    写真の位置
                                    <select name="pos" size="1">
                                        <option></option>
                                        <option value="0" <?php if($data['pos'] == '0'){echo 'selected';}?>>右側(縦並び)</option>
                                        <option value="1" <?php if($data['pos'] == '1'){echo 'selected';}?>>左側(縦並び)</option>
                                        <option value="2" <?php if($data['pos'] == '2'){echo 'selected';}?>>上側(横並び)</option>
                                        <option value="3" <?php if($data['pos'] == '3'){echo 'selected';}?>>下側(横並び)</option>
                                    </select>
                                </td>
                            </tr>
                            <tr> 
                                <td bgcolor="#EEEEFF"> <font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                    コメント </font><br>

                                    <a href="//image.hondanet.co.jp/cgi/image_tmp.cgi?id=2153801/infobbs" target="_blank"><font size=1>コメント内に画像を貼る場合こちらからアップロード</a></font><br>
                                    <font size=1 color=red>※レイアウトからはみ出さないよう、最大600ピクセルで使用してください。</font> </td>
                                <td bgcolor="#ffffff"> <font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                    入力モード切り替え
                                    <select onChange="wysi();" name="wyg">
                                        <option value="text">通常モード</option>
                                        <option value="wysiwyg">リッチテキストモード</option>
                                    </select>
                                    <?php
                                    // 記事が改行が必要かの判定
                                    $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $data['comment']);

                                    if ($hasNoBr) {
                                        $data['comment'] = nl2br( $data['comment'] );
                                    }
                                    ?>
                                    <textarea name="comment" style="width:500px;height:300px;" id="myArea2">{!! $data['comment'] !!}</textarea>
                                    </font>
                                </td>
                            </tr>
                            <tr> 
                                <td bgcolor="#EEEEFF">
                                    <font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                    お問い合わせ方法 </font>
                                </td>
                                <td bgcolor="#ffffff">
                                    <font color="#000000" style="font-size :12px; lineheight :12px;">
                                    <?php $inquiryMethodCodes = $inquiryMethodCodes ?? [] ?>
                                    @if ($mode == 'new')
                                        @foreach ($inquiryMethodCodes as $key => $value)
                                        <input type=radio 
                                               name="inquiry_method" 
                                               value="{{ $key }}"{{ $key == $data['inquiry_method'] ? ' checked=checked' : '' }}>{{ $value }}<br>
                                        @endforeach
                                    @else
                                        <select name="inquiry_method" size="1">
                                            <option></option>
                                            @foreach ($inquiryMethodCodes as $key => $value)
                                            <option value="{{ $key }}"{{ $key == $data['inquiry_method'] ? ' selected=selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                    </font>
                                </td>
                            </tr>
                            <tr> 
                                <td bgcolor="#EEEEFF"> <font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                    お問い合わせ先メールアドレス </font> </td>
                                <td bgcolor="#ffffff"> <font color="#000000" style="font-size :12px; lineheight :12px;">
                                    <input type=text name="mail_addr" value="{{ $data['mail_addr'] ?? '' }}"  size=50><br>
                                    お問い合わせ方法が「メール」の場合のみ記入してください。
                                    </font> </td>
                            </tr>
                            <tr> 
                                <td bgcolor="#EEEEFF"> <font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                    お問い合わせ先URL </font> </td>
                                <td bgcolor="#ffffff"> <font color="#000000" style="font-size :12px; lineheight :12px;">
                                    <input type=text name="form_addr" value="{{ $data['form_addr'] ?? '' }}"  size=50><br>
                                    お問い合わせ方法が「指定のURLへリンク」の場合のみ記入してください。
                                    </font> </td>
                            </tr>
                            <tr> 
                                <td bgcolor="#EEEEFF" height="35"> <font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                    お問い合わせ先リンクの表記 </font> </td>
                                <td bgcolor="#ffffff" height="35"> 
                                    <input type=text name="inquiry_inscription" value="{{ $data['inquiry_inscription'] ?? '' }}" size=50 placeholder="お問い合わせはこちら"><br>
                                    <font color="#ff00000" style="font-size :10px; lineheight :10px;"> 
                                    ※表記を変更したい場合は編集して下さい。
                                    </font> </td>
                            </tr>
                            <tr>
                                <td bgcolor="#EEEEFF">
                                    <font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                    店舗</font>
                                </td>
                                <td bgcolor="#ffffff">
                                    <font color="#000000" style="font-size :18px; lineheight :18px;">
                                    @if ($mode == 'new')
                                        <input type="hidden" name="shop" value="{{ $data['shop'] }}">
                                        {{ $shopName }}
                                    @else
                                        @include('elements.shop.shop_select', ['id' => 'shop', 'value' => $data['shop']])
                                    @endif
                                    </font>
                                </td>
                            </tr>
                            <tr> 
                                <td bgcolor="#EEEEFF"> <font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                    掲載期間</font> </td>
                                <td bgcolor="#ffffff"> 
                                    <font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                    開始日、終了日のみの入力も可能です。期間を設けない場合は入力しないで下さい。
                                    </font><br>
                                    <font color="#000000" style="font-size :12px; lineheight :12px;"> 
                                    <input class="c-control-input datetimepicker" name="from_date" autocomplete="off" style="width: 100px;" value="{{ $data['from_date'] }}">
                                    日0時から<br>
                                    <input class="c-control-input datetimepicker" name="to_date" autocomplete="off" style="width: 100px;" value="{{ $data['to_date'] }}">
                                    日24時まで
                                    </font><br>

                                </td>
                            </tr>		  
                        </table>
                        @if ($mode == 'new')
                            <input type=hidden name="published" value="OFF">
                            <input type=reset value="内容をクリア">
                        @else
                            <input type="submit" name="delete" value="このデータを削除"
                                   onclick="location.href = '{{ $urlDeleteConfirm ?? '' }}';return false;">
                        @endif
                        <input type=submit value="次へ">
                        <br>
                    </td>
                </tr>
            </table>
        </form>
    </center>
    <script src="{{ asset_auto('js/vendor/jquery.min.js') }}"></script>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
    <!--<script src="/js/jquery.colorbox-min.js"></script>-->
    <!--<script type="text/javascript">
    function top_img() {
        $.colorbox({href: "./2153801/infobbs/aichi_bbstop.png", open: true});
    }
    </script>-->
    <script src="{{ asset_auto('jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset_auto('jquery-ui/jquery.ui.datepicker-ja.js') }}"></script>
    <script src="{{ asset_auto('js/flat-ui.min.js') }}"></script>
    <script src="{{ asset_auto('js/application.js') }}"></script>
    <script src="{{ asset_auto('datetimepicker/build/jquery.datetimepicker.full.js') }}"></script>
    <script type="text/javascript" src="{{ asset_auto('nicEdit_ja/nicEdit.js') }}"></script>
    <script type="text/javascript" src="{{ asset_auto('nicEdit_ja/load.js') }}"></script>
    <script>
    $(function(){
        $('.datetimepicker').datetimepicker({
            timepicker : false,
            closeOnDateSelect : true,
            scrollMonth : false,
            scrollInput : false,
            format: 'Y/m/d'
        });
    });
    var area2;
    function wysi(){
      obj = document.upload.wyg;
      index = obj.selectedIndex;
      val = obj.options[index].value;
      if(val == 'text'){removeArea2();}
      else if(val == 'wysiwyg'){addArea2();}
    }
    function addArea2() {
        area2 = new nicEditor({fullPanel : true}).panelInstance('myArea2');

    }
    function removeArea2() {
        area2.removeInstance('myArea2');
    }

    var chkval = document.upload.nicEdit_check.value;
    re = new RegExp("w3.org/1999", "i");
    if (chkval.match(re)) {
      addArea2();
      obj = document.upload.wyg;
      obj.options[1].selected = true;
    }
    </script>
</body>
</html>
