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
        <table width="100%" border="0" cellspacing="0" cellpadding="1">
            <tr>
                <td align="center">
                    <table width="600" border="0" cellspacing="0" cellpadding="5">
                        <tr>
                            <td bgcolor="#068438">
                                <font color="#FFFFFF">
                                    <b>Honda Cars 愛知　各店情報掲示板
                                    {{ $shopName }}</b>
                                </font>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="{{ $urlNew }}">新規データ追加</a>
                                <br>
                                <a href="{{ $urlListPreview }}">通常画面に戻る</a>
                                <br>
                                <form action="{{ $urlAction }}" name="adminForm" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="shop" value="{{ $shopCode  }}">
                                    <input type=hidden name=AdminAction value=edit>
                                    <br>
                                    <table border="0" cellspacing="0" cellpadding="2" width="650">
                                        <tr>
                                            <td bgcolor="#FF0000"> 
                                                <table border="0" cellspacing="0" cellpadding="3" width="100%">
                                                    <tr>
                                                        <td bgcolor="#FFFFFF">「一括編集ボタン」を押すと<b>「削除」にチェックしたものを一括削除します。</b><br>
                                                            <font size="1" color="ff0000">※一度削除すると元に戻せません。</font><br>
                                                            <input type=submit value="一括編集">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <hr>
                                    {{-- ページ表示 --}}
                                    @include($templateDir . '.pagination')
                                    </td>
                                    </tr>

                                    <?php $num = 0; ?>
                                    @foreach($blogs as $row)
                                    <?php
                                    $num++;
                                    
                                    // 本社リリースのステータス
                                    switch ($row->published) {
                                        case 'ON': $release_honsya = '◎承認済み';
                                            break;
                                        case 'NG': $release_honsya = '△未掲載';
                                            break;
                                        case 'OFF': $release_honsya = '△未掲載';
                                            break;
                                    }
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
                                                                            <td align="right" width="100" bgcolor="#CCCCCC" nowrap>{{ date('Y/m/d', strtotime($row->created_at)) }}</td>
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
                                                                            <td valign="top" bgcolor="#FFFFFF" width=99%>
                                                                                {{-- 記事が改行が必要かの判定 --}}
                                                                                @if (has_no_nl($row->comment))
                                                                                {!! nl2br( $row->comment ) !!}
                                                                                @else
                                                                                {!! $row->comment !!}
                                                                                @endif
                                                                                @if (($row->pos == 2 || $row->pos == 3) && !empty($row->inquiry_inscription))
                                                                                    <br>
                                                                                    <a href="mailto:{{ $row->mail_addr }}?Subject={{ $row->form_addr }}の件">
                                                                                        {{ $row->inquiry_inscription }}
                                                                                    </a>
                                                                                @endif
                                                                            </td>
                                                                            @if ($row->pos == 0)
                                                                                @include($templateDir . '.images.list_vertical')
                                                                            @endif
                                                                            @if ($row->pos == 2)
                                                                            <td valign="top" align="right" bgcolor="#FFFFFF" width=1%> 
                                                                                <font style="font-size:10px;">
                                                                                    <br><br><br><br><br>
                                                                                </font>
                                                                            </td>
                                                                            @endif
                                                                        </tr>
                                                                        @if ($row->pos == 3)
                                                                            @include($templateDir . '.images.list_horizontal')
                                                                        @endif
                                                                        <tr bgcolor="#FFFFFF"> 
                                                                            <td colspan="2"> 
                                                                                <table cellpadding=0 cellspacing=0 border=0 width=100%>
                                                                                    <tr> 
                                                                                        <td>
                                                                                            @if (($row->pos == 0 || $row->pos == 1) && !empty($row->inquiry_inscription))
                                                                                                <a href="mailto:{{ $row->mail_addr }}?Subject={{ $row->form_addr }}の件">
                                                                                                    {{ $row->inquiry_inscription }}
                                                                                                </a>
                                                                                            @endif
                                                                                        </td>
                                                                                        <td align=right> 
                                                                                            <font style="font-size :10px; lineheight :10px;">
                                                                                            削除<input type=checkbox name="{{ $row->number }}[del]" value="{{ $num }}"> &nbsp;&nbsp; <a href="{{ $urlAction . "?action=edit&shop={$row->shop}&number=" . $row->number }}">このデータを編集する</a>
                                                                                            </font> 
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr> 
                                                                                        <td>
                                                                                            <font style="font-size :10px; lineheight :10px;">
                                                                                            掲載期間：
                                                                                            @if (!empty($row->from_date))
                                                                                                {{ date('Y年m月d日', strtotime($row->from_date)) }}から
                                                                                            @endif
                                                                                            @if (!empty($row->to_date))
                                                                                                {{ date('Y年m月d日', strtotime($row->to_date)) }}まで
                                                                                            @endif
                                                                                            <br>
                                                                                            <font color="#0000A0">
                                                                                            編集日時：
                                                                                                {{ date('Y/m/d H:i:s', strtotime($row->updated_at)) }}<br>
                                                                                            投稿日時：
                                                                                                {{ date('Y/m/d H:i:s', strtotime($row->created_at)) }}
                                                                                            </font>
                                                                                            </font>
                                                                                        </td>
                                                                                        <td>{{ $release_honsya }}</td>
                                                                                    </tr>
                                                                                    <!-- tr> 
                                                                                      <td colspan=2> <button type="button" name="buttonName" onclick="location.href='https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=2153801/infobbs&mode=listswap&action=upper&target_num=data069413&shop=01'"><a href="https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=2153801/infobbs&mode=listswap&action=upper&target_num=data069413&shop=01">一番上へ移動</a></button> <button type="button" name="buttonName" onclick="location.href='https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=2153801/infobbs&mode=listswap&action=up&target_num=data069413&shop=01'"><a href="https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=2153801/infobbs&mode=listswap&action=up&target_num=data069413&shop=01">一つ上へ移動</a></button> <button type="button" name="buttonName" onclick="location.href='https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=2153801/infobbs&mode=listswap&action=down&target_num=data069413&shop=01'"><a href="https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=2153801/infobbs&mode=listswap&action=down&target_num=data069413&shop=01">一つ下へ移動</a></button> <button type="button" name="buttonName" onclick="location.href='https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=2153801/infobbs&mode=listswap&action=lower&target_num=data069413&shop=01'"><a href="https://cgi3-aws.hondanet.co.jp/cgi/grbbs3_edit.cgi?id=2153801/infobbs&mode=listswap&action=lower&target_num=data069413&shop=01">一番下へ移動</a></button> </td>
                                                                                    </tr -->
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

                                    <!-- STANDARD MODE END -->
                                    <!-- STANDARD MODE END -->
                                    <!-- STANDARD MODE END -->
                                    <!-- LIST MODE END -->
                                    <!-- LIST MODE END -->
                                    <!-- LIST MODE END -->
                                    <!-- LIST MODE END -->		<tr> 
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
                                                                <td bgcolor="#FFFFFF">「一括編集ボタン」を押すと<b>「削除」にチェックしたものを一括削除します。</b><br>
                                                                    <font size="1" color="ff0000">※一度削除すると元に戻せません。</font><br>
                                                                    <input type=submit value="一括編集">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                </form>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
