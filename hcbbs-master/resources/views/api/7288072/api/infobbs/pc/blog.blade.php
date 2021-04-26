<div class="COMMON-BBS">
    <div class="COMMON-BBS-inner">
        {{-- 記事データが存在するとき --}}
        @foreach ($blogs as $item)
        <div class="COMMON-BBS-detail">
            <p class="COMMON-BBS-detail-title">{{ $item->title }}</p>
            <?php
            $time = strtotime($item->updated_at);
            if (!empty($item->from_date)) {
                $time = strtotime($item->from_date);
            }
            ?>
            <p class="COMMON-BBS-detail-posted">{{ $item->base_name }}　｜　{{ date('Y/m/d', $time) }}</p>
            <div class="COMMON-BBS-detail-article">
                <div class="COMMON-BBS-detail-article-inner">
                    <div class="COMMON-BBS-detail-body">
                        <?php
                        // 記事が改行が必要かの判定
                        $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
                        ?>
                        @if ($hasNoBr)
                          {!! nl2br( $item->comment ) !!}
                        @else
                          {!! $item->comment !!}
                        @endif
                    </div>
                </div>
                {{-- 画像 --}}
                @include($templateDir . '.image')
            </div>
        </div><!-- /.COMMON-BBS-detail -->
        @endforeach
        {{-- ページネーションの読み込み --}}
        @include($templateDir . '.pagination')
    </div><!-- /.COMMON-BBS-inner -->
</div><!-- /.COMMON-BBS -->
