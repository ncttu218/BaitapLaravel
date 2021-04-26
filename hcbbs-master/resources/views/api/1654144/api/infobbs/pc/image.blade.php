<div class="COMMON-BBS-detail-photo-list">
    <ul>
        <?php
        $imgFiles = [];
        // 1 から 3 まで繰り返す 設定ファイルで最大値を変更したほうが良いかも
        for( $i=1; $i<= 3; $i++ ){
          $imgFiles[$i]['file'] = $item->{'file' . $i};
          $caption = $convertEmojiToHtmlEntity($item->{'caption' . $i});
          $caption = str_replace('<', '&lt;', $caption);
          $caption = str_replace('>', '&gt;', $caption);
          $imgFiles[$i]['caption'] = $caption;
          echo '<li><p>';
          if (!empty($imgFiles[$i]['file'])) {
            // PDFファイルの対応
            if( strtolower( $fileinfo['extension'] ) === "pdf" ){
              ?>
              <a href="{{ asset_auto( $imgFiles[$i]['file']) }}" target="_blank">
                  <img src="{{ $CodeUtil::getPdfThumbnail(  $imgFiles[$i]['file'] ) }}" width="200">
              </a>
              <?php
            }else{
              $imgFiles[$i]['file'] = str_replace('thumb/thu_', '', $imgFiles[$i]['file']);
              echo '<img src="' . url_auto( $imgFiles[$i]['file'] ) . '" style="width:200px !important;" border="0">';
            }
            if (!empty($imgFiles[$i]['caption'])) {
              echo '<br/>' . $imgFiles[$i]['caption'];
            }
          }
          echo '</p></li>';
        }
        ?>
    </ul>
</div>
