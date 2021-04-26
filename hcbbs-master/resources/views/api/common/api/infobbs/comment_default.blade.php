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
          $formUrl = $CodeUtil::getV2Url('Api\CommentPostController@getIndex', $hanshaCode);
          $formUrl .= "?blog_data_id={$item->number}&style=default";
          ?>
          {{-- 感想の一覧にデータが存在するとき --}}
          @if( !$commentList->isEmpty() )
          <div class="hakusyu font10" style="text-align: right;">
              @foreach ( $commentList as $commentValue )
                <img src="{{ asset_auto( 'img/hakusyu/' . $commentValue->mark . '.png' ) }}" width="20px">{{ $commentValue->comment_count }}&nbsp;
              @endforeach
            </div>
          @endif
          
          <div class="hakusyu font10" style="text-align: right;">
            <button onClick="window.open( '{{ $formUrl }}','_blank','width=300,height=550,scrollbars=yes');return false;">感想を送る</button>
          </div>
        </td>
      </tr>
    </table>

  @endif