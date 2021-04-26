<div class="p-sr-blog">
@if (count($showData) > 0)
    @include($templateDir . '.pagination')
    @foreach ($showData as $item)
    <?php
    // タイトル
    $item->title = $convertEmojiToHtmlEntity($item->title);
    // 本文
    $item->comment = $convertEmojiToHtmlEntity($item->comment);
    // 拠点名
    $item->base_name = trim($item->base_name);
    ?>
    <article>
        <div class="blog__header">
            <p class="blog__title">
                <span>【お知らせ】</span>
                {{ $item->title }}
            </p>
            <p class="blog__date">
                {{ date($timeFormat, strtotime($item->updated_at)) }}
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
    <span>現在投稿されている記事はありません。</span>
@endif
</div>
