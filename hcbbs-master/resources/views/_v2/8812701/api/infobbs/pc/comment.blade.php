<?php
// コメント件数
$commentCount = $CodeUtil::getBlogCommentCountTotal( $hanshaCode, $item->number  );
// 感想の一覧を取得
$commentList = $CodeUtil::getBlogCommentCountList( $hanshaCode, $item->number );
$formUrl = $CodeUtil::getV2Url('Api\CommentPostController@getIndex', $hanshaCode) .
        "?blog_data_id={$item->number}&style=default";
?>
{{-- 設定ファイルのコメント機能NOのとき --}}
@if( $para_list['comment'] === '1' )
<table>
    <tbody>
       <tr>
          <td align="left" valign="middle">
             <div class="hakusyu font10">
                <p></p>
                この記事の感想：{{ $commentCount }}件 
             </div>
              
             {{-- 感想の一覧にデータが存在するとき --}}
             @if( !$commentList->isEmpty() )
                @foreach ( $commentList as $commentValue )
                  @if (empty($commentValue->mark))
                      @continue
                  @endif
                  <div class="hakusyu">
                      <img src="{{ asset_auto( 'img/hakusyu/' . $commentValue->mark . '.png' ) }}" width="20px">{{ $commentValue->comment_count }}
                  </div>
                @endforeach
             @endif
              
             <div class="hakusyu font10">
                <button onclick="window.open('{{ $formUrl }}','_blank','width=300,height=550,scrollbars=yes');return false;">感想を送る</button>
             </div>
          </td>
       </tr>
    </tbody>
 </table>
  @endif