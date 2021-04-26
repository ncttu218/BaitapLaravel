<div class="COMMON-BBS-detail-photo-list">
    <ul>
        <?php
        $imgFiles = [];
        // 1 から 3 まで繰り返す 設定ファイルで最大値を変更したほうが良いかも
        for( $i=1; $i<= 3; $i++ ){
          $imgFiles[$i]['file'] = $item->{'file' . $i};
          $caption = $convertEmojiToHtmlEntity($item->{'caption' . $i});
          $imgFiles[$i]['caption'] = $caption;
          echo '<li><p>';
          if (!empty($imgFiles[$i]['file'])) {
            $imgFiles[$i]['file'] = str_replace('thumb/thu_', '', $imgFiles[$i]['file']);
            echo '<img src="' . url_auto( $imgFiles[$i]['file'] ) . '" width="200" border="0">';
            if (!empty($imgFiles[$i]['caption'])) {
              echo $imgFiles[$i]['caption'];
            }
          }
          echo '</p></li>';
        }
        ?>
    </ul>
</div>
