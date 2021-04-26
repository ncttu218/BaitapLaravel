
<!doctype html>
<html lang="ja">
<head>
  <meta charset="shift_jis">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>コメント投稿</title>
  @if ($styleTag == 'style1')
  <link rel="stylesheet" href="{{ asset_auto('/') }}css/comment/style_comment_sm.css">
  @else
  <link rel="stylesheet" href="{{ asset_auto('/') }}css/comment/style_comment.css">
  @endif
</head>
<body>

  <div class="commentContainer">
    <div class="commentInner">
      {!! Form::open( ['method' => 'POST', 'url' => $urlAction ?? 'Api\CommentPostController@postCreate'] ) !!}
        {!! Form::hidden( 'hansha_code', $hansha_code ) !!}
        {!! Form::hidden( 'blog_data_id', $blog_data_id ) !!}

        <p class="commentTitle">コメント投稿</p>
        <ul class="commentEmoji">
          @foreach($emoticons as $code => $label)
          <li class="commentEmoji__item">
            <input type="radio" name="mark" value="{{ $code }}">
            <img src="{{ asset_auto( 'img/hakusyu/' . $code . '.png' ) }}">
            <span>{{ $label }}</span>
          </li>
          @endforeach
        </ul>
        <input type="hidden" name="comment">
        <div class="commentText">
          <textarea class="commentText__box" name="comment"></textarea>
          <ul class="commentText__annotation">
            <li>※コメントは掲載されません</li>
            <li>※コメントには返事ができません</li>
          </ul>
        </div>
        <div class="commentButton">
          <input class="button -default" type="submit" value="感想を送る">
        </div>

      {!! Form::close() !!}
    </div>
  </div>

  {{--<script src="{{ asset_auto( 'js/jquery-3.4.1.min.js' ) }}"></script>--}}
</body>
</html>
