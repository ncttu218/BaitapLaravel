<?php
// 販社名の設定パラメータを取得
$para_list = (config('original.para')[$hanshaCode]);
// 店舗除外
$categoryCounterOptions = ['shopExclusion' => $shopExclusion];

?>
{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')

@foreach ($blogs as $item)
    <article>
        <div class="blog__header">
            <p class="blog__title"><span>【{{$item->base_name}}】</span>
                {{ $item->title }}
            </p>
            <p class="blog__date">
                <?php
                $time = strtotime($item->updated_at);
                /*if (!empty($item->from_date)) {
                   $time = strtotime($item->from_date);
                }*/
                ?>
                {{ date('Y/m/d', $time) }}
            </p>
        </div>
        <div class="blog__body" style="overflow: hidden">
            @include('api.common.api.infobbs.image_list_default')
            <?php
            // 記事が改行が必要かの判定
            $item->comment = str_replace('[NOW_TIME]', time(), $item->comment);
            $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
            if (strtotime($item->created_at) < strtotime('2020-05-01')) {
                $item->comment = preg_replace('/<p>[\r\n]+?<\/p>/', '<p><br /></p>', $item->comment);
            }
            ?>
            @if ($hasNoBr)
                {!! nl2br( $item->comment ) !!}
            @else
                {!! $item->comment !!}
            @endif
            <div style="clear:both;"></div>
        </div>
    </article>
@endforeach
@include($templateDir . '.pagination')