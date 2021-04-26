<?php
$jpDays = ['日', '月', '火', '水', '木', '金', '土'];
?>
<!doctype html>
<html lang="ja">
<head>
  <meta charset="shift_jis">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $title }} ｜ 各店情報掲示板 店舗別集計ツール</title>
  <script src="https://www.hondanet.co.jp/mut_system/blog_aggregate/js/pace.min.js"></script>
  <link rel="stylesheet" href="https://www.hondanet.co.jp/mut_system/blog_aggregate/css/style_aggregate.css">
</head>
<body>
  <div class="pageLoader"></div>

  <div class="pageContainer">
    <h1 class="pageTitle"><span class="hondacars">{{ $title }}</span><span class="title">各店情報掲示板 店舗別集計ツール</span></h1>
      <section class="sectionInner">

        <div class="aggregateTool">
        
          <div class="aggregateTool__formWrapper">
            <form class="aggregateTool__form" action="">
              <input type="hidden" name="hansha_code" value="{{ $hanshaCode }}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input class="year" type=text size=4 name=year value="{{ $year }}">
              <span>年</span>
              <select class="mon" name="month">
                @for ($i = 1; $i <= 12; $i++)
                    <option{{ (int)$month == $i ? ' selected="selected"' : '' }}>{{ sprintf("%02d", $i) }}</option>
                @endfor
              </select>
              <span>月</span>
              <input type=hidden value="{{ $hanshaCode }}">
              <input type=submit value="集計">
              <input type=submit name=sort value="アクセス順で集計">
            </form>
          </div>
         
          <div class="aggregateTool__tableWrapper">
            <table class="table aggregateTool__table">
              <thead>
                <tr>
                  <th><span class="aggregateTool__date">店舗 / 日付</span></th>
                  <th><span class="aggregateTool__date">合計</span></th>
                  @for ($day = 1; $day <= $lastDay; $day++)
                    <?php
                    $time = strtotime("{$year}-{$month}-{$day}");
                    ?>
                    <th><span class="aggregateTool__date"><span class="date">{{ $month }}/{{ $day }}</span><span class="week">（{{ $jpDays[date('w', $time)] }}）</span></span></th>
                  @endfor
                </tr>
              </thead>
              <tbody>
                @foreach ($baseList as $baseCode => $baseName)
                <tr>
                    <th>
                        <span class="aggregateTool__shop">
                            <?php
                            // ブログ公開API
                            if (isset($urlBlogIndexApi)) {
                                $url = $urlBlogIndexApi . '&shop=' . $baseCode;
                            } else {
                                $url = '';
                            }
                            ?>
                            <a href="{{ $url }}" target="_blank">{{ $baseName }}</a>
                        </span>
                    </th>
                    <td>{{ $counterData['totalByBase'][$baseCode] ?? 0 }}</td>
                    @for ($day = 1; $day <= $lastDay; $day++)
                        <?php
                        $time = strtotime("{$year}-{$month}-{$day}");
                        $numberOfDay = date('w', $time);
                        $day = sprintf("%02d", $day);
                        $bgColor = '';
                        if ($numberOfDay == 0) {
                            $bgColor = ' class=week_sun';
                        } else if ($numberOfDay == 6) {
                            $bgColor = ' class=week_sat';
                        }
                        ?>
                        <td{{ $bgColor }}>{{ isset($counterData['daily'][$baseCode]) ? $counterData['daily'][$baseCode][$day] : 0 }}</td>
                    @endfor
                </tr>
                @endforeach
                <tr>
                  <th><span class="aggregateTool__shop">合計</span></th>
                  <td>{{ $counterData['total'] }}</td>
                  @for ($day = 1; $day <= $lastDay; $day++)
                    <?php
                    $time = strtotime("{$year}-{$month}-{$day}");
                    $numberOfDay = date('w', $time);
                    $day = sprintf("%02d", $day);
                    $bgColor = '';
                    if ($numberOfDay == 0) {
                        $bgColor = ' class=week_sun';
                    } else if ($numberOfDay == 6) {
                        $bgColor = ' class=week_sat';
                    }
                    ?>
                    <td{{ $bgColor }}>{{ $counterData['totalByDay'][$day] }}</td>
                  @endfor
                </tr>
              </tbody>
            </table>
          </div>
  
      </div>
    </section>
  </div>

  <script src="{{ asset_auto('js/ranking/jquery-3.4.1.min.js') }}"></script>
</body>
</html>