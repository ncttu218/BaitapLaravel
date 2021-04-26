@extends($displayObj->tpl . '.layout')

@section('content')
<table width="1200">
    <tr valign="bottom">
        <td align="left">
            <a href="?year={{ $dateData['prevYear'] }}&month={{ $dateData['prevMonth'] }}">
                ←{{ $dateData['prevYear'] }}/{{ $dateData['prevMonth'] }}
            </a>
        </td>
        <td align="center" id="top">
            <?php
            // 販社名
            $hanshaName = Config('original.hansha_code')[$hanshaCode];
            ?>
            <font style="font-size:20; font-weight:bold;">　{{ $hanshaName }}　-拠点ブログ 更新状況-　</font>
        </td>
        <td align="right">
            <a href="?year={{ $dateData['nextYear'] }}&month={{ $dateData['nextMonth'] }}">
                {{ $dateData['nextYear'] }}/{{ $dateData['nextMonth'] }}→
            </a>
        </td>
    </tr>
</table>
<br>
<table width="1200">
    <tr>
        <!-- td><a href="#owari">■尾張地区</a>　<a href="#nagoya">■名古屋地区</a>　<a href="#chita_mikawa">■知多・三河地区</a>　<a href="#auto">■オートテラス</a></td -->
        <td align="right">
            <input type="button" value="CSVダウンロード" onClick="location = '{{ $urlDownloadCsv }}'">
            <a href="{{ $urlActionAccessCounter }}">各店舗別集計ツールへ</a> |
            <a target="_blank" href="https://cgi2-aws.hondanet.co.jp/cgi/admin/bbs_count.cgi?id=1103901/infobbs">（旧）各店舗別集計ツールへ</a>
        </td>
    </tr>
</table>
<!-- font color="#ff0000" size="2">※15日以上更新がされていない拠点は、拠点名が点滅します。</font -->
<table>
    <tr>
        <td bgcolor="#00008B">
            <table width="1200">
                <tr align="center" bgcolor="#AACCFF">
                    <td style="font-weight:bold;" nowrap>
                        {{ $dateData['thisYear'] }}/{{ $dateData['thisMonth'] }}
                    </td>
                    <td nowrap>{{ (int)$dateData['thisMonth'] }}月更新合計</td>
                    <td nowrap>未更新日数</td>
                    @for ($day = 1; $day <= $lastDay; $day++)
                        <td width="20">{{ $day }}</td>
                    @endfor
                </tr>
                @foreach ($shopList as $shopCode => $shopName)
                <?php
                $shopLast = $shopLastArr[$shopCode] ?? 0;
                $status = '';
                if ($shopLast > $updateDayLimit) {
                    $status = " background=https://cgi3-aws.hondanet.co.jp/cgi/1103901/infobbs/img/blink2.gif";
                }
                ?>
                <tr align="center" bgcolor="#ffffff">
                    <td{{ $status }} align="left" nowrap>
                        <?php
                        // ブログ公開API
                        if (isset($urlBlogIndexApi)) {
                            $url = $urlBlogIndexApi . '&shop=' . $shopCode;
                        } else {
                            $url = '';
                        }
                        ?>
                        <a href="{{ $url }}" target="_blank">
                            {{ $shopCode }}:{{ $shopName }}
                        </a>
                    </td>
                    <td style="font-weight:bold;" bgcolor="#C0C0C0">
                        {{ $totalByShopArr[$shopCode] ?? 0 }}
                    </td>
                    <td>{{ $shopLast }}</td>
                    @for ($day = 1; $day <= $lastDay; $day++)
                        <?php
                        $status = '';
                        $num = '-';
                        // 更新がある場合
                        if (isset($logArr[$day][$shopCode])) {
                            $status = ' bgcolor=#FFCC33';
                            $num = $logArr[$day][$shopCode];
                        }
                        ?>
                        <td width="20"{{ $status }}>{{ $num }}</td>
                    @endfor
                </tr>
                @endforeach
                <tr align="center" bgcolor="#AACCFF" style="font-weight:bold;">
                    <td align="left" nowrap="">全体合計</td>
                    <td>{{ $totalAll }}</td>
                    <td></td>
                    @for ($day = 1; $day <= $lastDay; $day++)
                        <td width="20">{{ $totalByDayArr[$day] ?? 0 }}</td>
                    @endfor
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection
