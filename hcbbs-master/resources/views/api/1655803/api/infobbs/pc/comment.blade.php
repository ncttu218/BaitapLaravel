@if( $para_list['comment'] === '1' )
<ul>
    <li></li>
    <?php
    $commentList = $CodeUtil::getBlogCommentCountList( $hanshaCode, $item->number );
    $commentFormUrl = isset($commentFormUrl) ?
                  str_replace('{ITEM_NUMBER}', $item->number, $commentFormUrl) : '';
    $commentFormUrl = str_replace('&style=style1', '&style=style_default', $commentFormUrl);
    ?>
    {{-- 感想の一覧にデータが存在するとき --}}
    @if( !$commentList->isEmpty() )
    <li>
        @foreach ( $commentList as $commentValue )
        <div class="hakusyu">
        <img src="{{ asset_auto( 'img/hakusyu/' . $commentValue->mark . '.png' ) }}" width="20px">{{ $commentValue->comment_count }}&nbsp;
        </div>
        @endforeach
    </li>
    @endif
    {{-- 感想の一覧を取得 --}}
    <li>この記事の感想：{{ $CodeUtil::getBlogCommentCountTotal( $hanshaCode, $item->number  ) }}件 </li>
    <li><a href="#" onClick="window.open( '{{ $commentFormUrl }}','_blank','width=300,height=550,scrollbars=yes');return false;">感想を送る</a></li>
</ul>

@endif
