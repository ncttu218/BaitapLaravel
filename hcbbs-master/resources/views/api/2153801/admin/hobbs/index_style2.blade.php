<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
        <title>Honda Cars 愛知　各店情報掲示板</title>
        <style type="text/css">
            <!--
            FORM{margin: 0em;} 
            -->
        </style>
    </head>
    <body bgcolor="#FFFFFF" text="#000000" link="#0000FF" vlink="#000066" alink="#FF0000">
        <form action="{{ $urlAction }}" name="adminForm" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <table width="100%" border="0" cellspacing="0" cellpadding="1">
                <tr>
                    <td align="center"> 
                        <table width="600" border="0" cellspacing="0" cellpadding="5">
                            <tr> 
                                <td bgcolor="#068438"><font color="#FFFFFF"><b>Honda Cars 愛知　各店情報掲示板 
                                    </b></font></td>
                            </tr>
                            <tr> 
                                <td>
                                    <input type=hidden name=AdminAction value=edit> <br>
                                    <table border="0" cellspacing="0" cellpadding="2" width="650">
                                        <tr>
                                            <td bgcolor="#FF0000"> 
                                                <table border="0" cellspacing="0" cellpadding="3" width="100%">
                                                    <tr>
                                                        <td bgcolor="#FFFFFF">「一括編集ボタン」を押すと<b>「掲載する／しない」の変更が反映されます。</b><br>
                                                            <input type=submit value="一括編集">
                                                        </td>
                                                    </tr>
                                                </table>
                                                <font style="font-size:10px;" color=white>編集日にかかわらずデータの投稿日が10日以内で、「掲載しない」になっている記事が表示されます。<br>
                                                掲載期間を終了したものは表示されません。</font>
                                            </td>
                                        </tr>
                                    </table>
                                    <hr>
                                    {{-- ページ表示 --}}
                                    @include($templateDir . '.pagination')
                                </td>
                            </tr>

                            <!-- STANDARD MODE END -->
                            <!-- STANDARD MODE END -->
                            <!-- STANDARD MODE END -->
                            <!-- STANDARD MODE END -->
                            <?php $num = 0; ?>
                            @foreach($blogs as $row)
                            <?php
                            $num++;
                            // 画像データ
                            $imageData = [];
                            for ($i = 1; $i <= 3; $i++) {
                                $varName = "file{$i}";
                                if (empty($row->{$varName})) {
                                    continue;
                                }
                                $imageData[$i] = [
                                    'url' => $row->{$varName},
                                    'caption' => $row->{'caption' . $i}
                                ];
                            }
                            $imageData['hasData'] = count($imageData) > 0;
                            ?>
                            <tr> 
                                <td> 
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr> 
                                            <td bgcolor="#068438"> 
                                                <table width="100%" border="0" cellspacing="1" cellpadding="0">
                                                    <tr> 
                                                        <td> 
                                                            <table width="100%" border="0" cellspacing="1" cellpadding="2">
                                                                <tr> 
                                                                    <td bgcolor="#068438"><b><font color="#FFFFFF">{{ $row->title }}</font></b> 
                                                                    </td>
                                                                    <td align="right" width="100" bgcolor="#CCCCCC" nowrap><font size="2">【{{ $row->base_name }}】</font>&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr> 
                                                        <td> 
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                                {{-- トップにある画像 --}}
                                                                @if ($row->pos == 2)
                                                                    @include($templateDir . '.images.list_horizontal')
                                                                @endif
                                                                <tr> 
                                                                    @if ($row->pos == 1)
                                                                        @include($templateDir . '.images.list_vertical')
                                                                    @endif
                                                                    <td valign="top" width=649 bgcolor="#FFFFFF">
                                                                        {{-- 記事が改行が必要かの判定 --}}
                                                                        @if (has_no_nl($row->comment))
                                                                        {!! nl2br( $row->comment ) !!}
                                                                        @else
                                                                        {!! $row->comment !!}
                                                                        @endif
                                                                    </td>
                                                                    <td valign="top" align="right" bgcolor="#FFFFFF" nowrap> 
                                                                        <font style="font-size:10px;">   
                                                                        </font>
                                                                    </td>
                                                                    @if ($row->pos == 0)
                                                                        @include($templateDir . '.images.list_vertical')
                                                                    @endif
                                                                </tr>
                                                                @if ($row->pos == 3)
                                                                    @include($templateDir . '.images.list_horizontal')
                                                                @endif
                                                                <tr bgcolor="#FFFFFF"> 
                                                                    <td colspan="2"> 
                                                                        <table cellpadding=0 cellspacing=0 border=0 width=100%>
                                                                            <tr> 
                                                                                <td>  </td>
                                                                            </tr>
                                                                            <tr> 
                                                                                <td>
                                                                                    <font style="font-size :10px; lineheight :10px;">掲載期間：
                                                                                    @if($row->from_date)
                                                                                        {{ $row->from_date }}から
                                                                                    @endif
                                                                                    @if($row->to_date)
                                                                                        {{ $row->to_date }}まで
                                                                                    @endif<br>
                                                                                    <font color="#0000A0">
                                                                                    編集日時： {{ $row->updated_at }}<br>
                                                                                    投稿日時： {{ $row->created_at }}
                                                                                    </font>
                                                                                    </font> 
                                                                                </td>
                                                                                <td align=right>
                                                                                    掲載 
                                                                                    <input type="radio" name="{{ $row->number}}[published]" value="ON" {{ $row->published == 'ON' ? 'checked':null }}>する 
                                                                                    <input type="radio" name="{{ $row->number}}[published]" value="OFF"  {{ $row->published == 'OFF' ? 'checked':null }}>しない <br>
                                                                                    削除<input type=checkbox name="{{ $row->number }}[del]" value="{{ $num }}"> &nbsp;&nbsp; <a href="{{ $urlInfobbsAction . "?action=edit&shop={$row->shop}&confirmation=1&number=" . $row->number }}">このデータを編集する</a> 
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            @endforeach
                            <!-- LIST MODE END -->
                            <!-- LIST MODE END -->
                            <!-- LIST MODE END -->		
                            <tr>
                                <td> 
                                    <hr>
                                    {{-- ページ表示 --}}
                                    @include($templateDir . '.pagination')
                                </td>
                            </tr>
                            <tr> 
                                <td>
                                    <table border="0" cellspacing="0" cellpadding="2" width="650">
                                        <tr>
                                            <td bgcolor="#FF0000"> 
                                                <table border="0" cellspacing="0" cellpadding="3" width="100%">
                                                    <tr>
                                                        <td bgcolor="#FFFFFF">「一括編集ボタン」を押すと<b>「掲載する／しない」の変更が反映されます。</b><br>
                                                            <input type=submit value="一括編集">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
