{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
<?php
$imgFiles = [];

// 1 から 3 まで繰り返す 設定ファイルで最大値を変更したほうが良いかも
for( $i=1; $i <= 3; $i++ ){
  $imgFiles[$i]['file'] = $i > 1 ? $item->{'file' . $i} : $item->file;
  $imgFiles[$i]['caption'] = $i > 1 ? $item->{'caption' . $i} : $item->caption;
}
?>
<article>
    <div class="blog__header">
        <p class="blog__title"><span>【青山店】</span>{{ $item->title }}</p>
        <p class="blog__date">
            {{ date('Y/m/d', strtotime($item->updated_at)) }}
        </p>
    </div>
    <div class="blog__body">
        {{-- 定形画像が入力されていれば、画面に出力する。 --}}
        @if( !empty( $imgFiles ) == True )

          <div>
            <font> 
              {{-- 定形画像の数分繰り返す --}}
              @foreach( $imgFiles as $imgFile )
                @if( !empty( $imgFile['file'] ) == True )
                  <br>
                  <a href="{{ url_auto( $imgFile['file'] ) }}"  target="_blank">
                    <img src="{{ url_auto( $imgFile['file'] ) }}" width="160" border=0  f7>
                  </a>
                  {{-- 画像の説明文が存在するとき --}}
                  @if( !empty( $imgFile['caption'] ) == True )
                    <p>{{ $imgFile['caption'] }}</p>
                  @endif
                @endif
              @endforeach
            </font> 
          </div>
        @endif
        
        {!! $item->comment !!}
    </div>
</article>
@endforeach

@include($templateDir . '.pagination')