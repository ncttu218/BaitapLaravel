{{-- 設定ファイルのコメント機能NOのとき --}}
  @if( $para_list['comment'] === '1' )

    <table style="width: 100%; margin-bottom: 5px;">
      <tr>
        <td align="right" valign="middle">
          <div class="hakusyu font10" style="text-align: right;">
            <p></p>
            この記事の感想：{{ $CodeUtil::getBlogCommentCountTotal( $hanshaCode, $item->number  ) }}件 
          </div>

          {{-- 感想の一覧を取得 --}}
          <?php
          $commentList = $CodeUtil::getBlogCommentCountList( $hanshaCode, $item->number );
          $commentFormUrl = isset($commentFormUrl) ?
                  str_replace('{ITEM_NUMBER}', $item->number, $commentFormUrl) : '';
          ?>
          {{-- 感想の一覧にデータが存在するとき --}}
          @if( !$commentList->isEmpty() )
              @foreach ( $commentList as $commentValue )
                @if (empty($commentValue->mark))
                    @continue
                @endif
                <div class="hakusyu font10" style="text-align: right;">
                    <img src="{{ asset_auto( 'img/hakusyu/' . $commentValue->mark . '.png' ) }}" width="20px">{{ $commentValue->comment_count }}&nbsp;
                </div>
              @endforeach
          @endif
          
          <div class="hakusyu font10" style="text-align: right;">
            <button onClick="window.open( '{{ $commentFormUrl }}','_blank','width=300,height=550,scrollbars=yes');return false;">感想を送る</button>
          </div>
        </td>
      </tr>
    </table>

  @endif