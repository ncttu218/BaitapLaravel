<?php
$jpDays = ['日', '月', '火', '水', '木', '金', '土'];
?>
<html>
    <head>
        <title>Honda Cars 愛知　各店情報掲示板 店舗別集計ツール</title>
    </head>
    <body bgcolor="white" text="black" link="blue" vlink="blue" alink="red">
        <font size="2">
        <form action="">
                <input type="text" size="4" name="year" value="2020" />年
                    <select class="mon" name="month">
                    @for ($i = 1; $i <= 12; $i++)
                        <option{{ (int)$month == $i ? ' selected="selected"' : '' }}>{{ sprintf("%02d", $i) }}</option>
                    @endfor
                </select>
                <input type=hidden value="{{ $hanshaCode }}">
                月
                <input type="submit" value="集計" />
                <input type="submit" name="sort" value="アクセス順で集計" />
                <!-- a href=./csv/2153801.infobbs.csv target=_blank>CSVデータダウンロード</a -->
            </form>
            <table border="1" cellspacing="0" cellpadding="2" bordercolor="#000099">
                <tbody>
                    <tr>
                        <td colspan="{{ $lastDay + 3 }}"><font size="2">Honda Cars 愛知　各店情報掲示板 店舗別集計ツール</font></td>
                    </tr>
                    <tr bgcolor="#000099">
                        <td nowrap=""><font color="white" size="2">店舗／日付</font></td>
                        @for ($day = 1; $day <= $lastDay; $day++)
                        <?php
                        $time = strtotime("{$year}-{$month}-{$day}");
                        ?>
                        <td nowrap="" align="center">
                            <font color="white" size="2">
                                {{ $month }}<br>
                                /<br>
                                {{ $day }}<br>
                                ({{ $jpDays[date('w', $time)] }})
                            </font>
                        </td>
                        @endfor
                        <td><font color="white" size="2">合計</font></td>
                        <td><font color="white" size="2">店舗 </font></td>
                    </tr>
                    @foreach ($baseList as $baseCode => $baseName)
                    <?php
                    // ブログ公開API
                    if (isset($urlBlogIndexApi)) {
                        $url = $urlBlogIndexApi . '&shop=' . $baseCode;
                    } else {
                        $url = '';
                    }
                    ?>
                    <tr>
                        <td nowrap="">
                            <font size="2"><a href="{{ $url }}" target="_blank">{{ $baseName }}</a></font>
                        </td>
                        @for ($day = 1; $day <= $lastDay; $day++)
                        <?php
                        $time = strtotime("{$year}-{$month}-{$day}");
                        $numberOfDay = date('w', $time);
                        $bgColor = '';
                        if ($numberOfDay == 0) {
                            $bgColor = ' bgcolor=#ffeeee';
                        } else if ($numberOfDay == 6) {
                            $bgColor = ' bgcolor=#eeeeff';
                        }
                        ?>
                        <td align="right"{{ $bgColor }}>
                            <font size="2">{{ isset($counterData['daily'][$baseCode]) ? $counterData['daily'][$baseCode][$day] : 0 }}<br /></font>
                        </td>
                        @endfor
                        <td align="right">
                            <font size="2">{{ $counterData['totalByBase'][$baseCode] ?? 0 }}<br /></font>
                        </td>
                        <td nowrap=""><font size="2">{{ $baseName }} </font></td>
                    </tr>
                    @endforeach
                    <tr bgcolor="#000099">
                        <td><font color="white" size="2">合計</font></td>
                        @for ($day = 1; $day <= $lastDay; $day++)
                        <td align="right">
                            <font color="white" size="2">{{ $counterData['totalByDay'][$day] }}<br /></font>
                        </td>
                        @endfor
                        <td align="right">
                            <font color="white" size="2">{{ $counterData['total'] }}<br /></font>
                        </td>
                        <td><font color="white" size="2">合計 </font></td>
                    </tr>
                </tbody>
            </table>
        </font>
    </body>
</html>
