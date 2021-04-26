{{-- 設定ファイルのコメント機能NOのとき --}}
  @if( $para_list['comment'] === '1' )

    <table>
      <tbody>
      <tr>
        <td align="left" valign="middle">
          <div class="hakusyu font10">
            <p></p>
            この記事の感想：{{ $CodeUtil::getBlogCommentCountTotal( $hanshaCode, $item->number  ) }}件 
          </div>

          {{-- 感想の一覧を取得 --}}
          <?php
          $commentList = $CodeUtil::getBlogCommentCountList( $hanshaCode, $item->number );
          ?>
          {{-- 感想の一覧にデータが存在するとき --}}
          @if( !$commentList->isEmpty() )
          <div class="hakusyu font10">
              @foreach ( $commentList as $commentValue )
                <img src="{{ asset_auto( 'img/hakusyu/' . $commentValue->mark . '.png' ) }}" width="20px">{{ $commentValue->comment_count }}&nbsp;
              @endforeach
            </div>
          @endif
          
          <div class="hakusyu font10">
            <button onClick="window.open( '{{ url_auto('/api/comment_post') }}?hansha_code={{ $hanshaCode }}&blog_data_id={{ $item->number }}','_blank','width=300,height=550,scrollbars=yes');return false;">感想を送る</button>
          </div>
        </td>
      </tr>
      </tbody>
    </table>

  @endif