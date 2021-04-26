<script language="JavaScript" src="/common-js/opendcs.js"></script>

{{-- ページネーション --}}
@include($templateDir . '.pagination')

{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
  <article>
    <div class="blog__header">
      {{-- タイトル --}}
      <p class="blog__title">
        <span>【{{ $item->base_name }}】</span>
        <?php
        $item->title = str_replace('<', '&lt;', $item->title);
        $item->title = str_replace('>', '&gt;', $item->title);
        ?>
        {{ $item->title }}
      </p>
      {{-- 掲載日時 --}}
      <p class="blog__date">
        <?php
        $time = strtotime($item->updated_at);
        if (!empty($item->from_date)) {
            $time = strtotime($item->from_date);
        }
        ?>
        {{ date('Y/m/d', $time) }}
      </p>
    </div>
    {{-- 本文 --}}
    <div class="blog__body">
      @if ($item->pos == 2 || $item->pos == 1)
        {{-- ページネーションの読み込み --}}
        @include($templateDir . '.images')
      @endif
      @if ($item->pos == 0 || $item->pos == 1)
        <div style="float:left;">
      @else
        <div>
      @endif
          <p class="category"></p>
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
      @if ($item->pos != 2 && $item->pos != 1)
          {{-- ページネーションの読み込み --}}
          @include($templateDir . '.images')
      @endif
      <div>
          <font style="font-size:10px;">   
          </font> 
      </div>
      <div style="clear:both;">
      </div>
  </div>
  </article>
@endforeach

{{-- ページネーション --}}
@include($templateDir . '.pagination')
