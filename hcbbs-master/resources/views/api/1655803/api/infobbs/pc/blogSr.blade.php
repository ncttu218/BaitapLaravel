<?php
// 販社名の設定パラメータを取得
$para_list = ( Config('original.para')[$hanshaCode] );
?>

<div class="p-sr-blog">
  <table>
    <tbody>
      <tr>
        <td>
          <style type="text/css">
            div.hakusyu{float:left;}
          </style>

          
          <div id="showroomBlogInfo">
            {{-- 設定ファイルのカテゴリー機能NOのとき --}}
            @if( isset( $para_list['category'] ) && $para_list['category'] !== '' )
              <?php
              // カテゴリーの配列を取得
              $categoryList = explode( ",", $para_list['category'] );
              ?>

              <ul>
                <li>
                  <a href="?category=">全て({{ $CodeUtil::getBlogTotalSum( $hanshaCode, $shopCode ) }})</a>
                </li>

                {{-- カテゴリー一覧を表示するループ --}}
                @foreach ( $categoryList as $category )
                  <?php
                  $count = $CodeUtil::getBlogTotalSum( $hanshaCode, $shopCode, $category );
                  ?>

                  <li>
                    <a href="?shop={{ $shopCode }}&category={{ $category }}">{{ $category }}({{  ( isset( $count ) )? $count: 0 }})</a>
                  </li>
                @endforeach

              </ul>
            @endif
            
            {{-- ページングの読み込み --}}
            @include($templateDir . '.pagination')
          </div><!-- #showroomBlogInfo -->

          {{-- 記事データが存在するとき --}}
          @foreach ($blogs as $item)

            <div class="showroomEntryBox">
              {{-- 店舗・タイトル --}}
              <h2>[{{ $item->base_name }}]&nbsp;{{ $item->title }}</h2>

              {{-- 掲載日時 --}}
              <p class="showroomEntryDate">
                <?php
                  $time = strtotime($item->updated_at);
                  if (!empty($item->from_date)) {
                      $time = strtotime($item->from_date);
                  }
                  ?>
                  {{ date('Y/m/d', $time) }}
              </p>

              {{-- 本文 --}}
              <div class="showroomEntryBody">
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

                {{-- 定形画像が入力されていれば、画面に出力する。 --}}
                @include($templateDir . '.image')

              </div><!-- #showroomEntryBody -->

              {{-- 設定ファイルのコメント機能NOのとき --}}
              @include($templateDir . '.comment')

            </div><!-- #showroomEntryBox -->

          @endforeach
          <!-- ZERO END -->
          {{-- ページングの読み込み --}}
          @include($templateDir . '.pagination')

        </td>
      </tr>
    </tbody>
  </table>
</div>

