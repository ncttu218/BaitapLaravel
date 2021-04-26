@if ($blogs->count() > 0)
@foreach ($blogs as $item)
<article>
    <div class="blog__header">
        <p class="blog__title">
            <span>【{{ $item->base_name }}】</span>
            {{ $convertEmojiToHtmlEntity($item->title) }}
        </p>
        <p class="blog__date">
            {{ date('Y/m/d', strtotime($item->created_at)) }}
        </p>
    </div>
    <div class="blog__body">
        <div>
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
            
            @include('api.common.api.infobbs.image_list_default')
            <div>
                <font> 
                </font> 
            </div>
        </div>
    </div>
</article>
@endforeach

@include($templateDir . '.pagination')

@else
ただいま準備中です。
@endif
