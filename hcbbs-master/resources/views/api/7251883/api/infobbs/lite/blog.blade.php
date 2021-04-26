<script language="JavaScript" src="/common-js/opendcs.js"></script>
<link rel="stylesheet" href="/common-css/infobbs_style.css" type="text/css" />
<link rel="stylesheet" href="/common-css/cgi_common.css" type="text/css" />
<a name="0"></a>
<font style="font-size: 12px; lineheight: 12px;">
    {{-- 記事データが存在するとき --}}
    @if (count($blogs) > 0)
    @foreach ($blogs as $item)
    <article>
        <div class="blog__header">
            <p class="blog__title">
                {{ $item->title }}
            </p>
            <p class="blog__date">
                <?php
                // 日付
                $time = strtotime($item->updated_at);
                ?>
                {{ date('Y/m/d', $time) }}
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
            </div>
            {{-- 画像 --}}
            @include($templateDir . '.images')
            <div>
                <font style="font-size:10px;">   
                </font> 
            </div>
            <div style="clear: both;">
                {{-- コメント --}}
                @include($templateDir . '.comment')
            </div>
        </div>
    </article>    
    @endforeach
    @else
    ただいま準備中です。
    @endif
    <!-- ZERO END -->
</font>
{{-- ページネーション --}}
@include($templateDir . '.pagination')
<font style="font-size: 12px; lineheight: 12px;"></font>
