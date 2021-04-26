{{-- 感想の一覧を取得 --}}
<?php
$commentList = $CodeUtil::getBlogCommentCountList( $hanshaCode, $item->number );
$formUrl = $CodeUtil::getV2Url('Api\CommentPostController@getIndex', $hanshaCode) .
      "?blog_data_id={$item->number}&style=default";
?>
<table>
       <tr>
          <td align="right" valign="middle">
          </td>
       </tr>
       <tr>
          <td align="left" valign="middle">
             <div class="hakusyu font10">
                この記事の感想：{{ $CodeUtil::getBlogCommentCountTotal( $hanshaCode, $item->number  ) }}件 
             </div>
              
             {{-- 感想の一覧にデータが存在するとき --}}
             @if( !$commentList->isEmpty() )
                @foreach ( $commentList as $commentValue )
                <div class="hakusyu">
                  <img src="{{ asset_auto( 'img/hakusyu/' . $commentValue->mark . '.png' ) }}" width="20px">{{ $commentValue->comment_count }}&nbsp;
                </div>
                @endforeach
             @endif
             
             <div class="hakusyu font10">
                <button onClick="window.open( '{{ url_auto('/api/comment_post') }}?hansha_code={{ $hanshaCode }}&blog_data_id={{ $item->number }}','_blank','width=300,height=550,scrollbars=yes');return false;">感想を送る</button>
             </div>
          </td>
       </tr>
       <tr>
          <td align="left" valign="middle">
          </td>
       </tr>
 </table>
