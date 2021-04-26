<!doctype html>
<html lang="ja">
<head>
  <meta charset="shift_jis">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>コメント投稿</title>
  <link rel="stylesheet" href="https://www.hondanet.co.jp/mut_system/blog_comment/css/style_comment.css">
</head>
<body>

  <div class="commentContainer">
    <div class="commentInner">
      {!! Form::open( ['method' => 'POST', 'url' => action_auto( 'Api\CommentPostController@postCreate' )] ) !!}
        {!! Form::hidden( 'hansha_code', $hansha_code ) !!}
        {!! Form::hidden( 'blog_data_id', $blog_data_id ) !!}

        <p class="commentTitle">コメント投稿</p>
        <ul class="commentEmoji">
          <li class="commentEmoji__item"><input type="radio" name="mark" value="012"><img src="{{ asset_auto( 'img/hakusyu/1011801/012.png' ) }}"><span>ためになった</span></li>
          <li class="commentEmoji__item"><input type="radio" name="mark" value="011"><img src="{{ asset_auto( 'img/hakusyu/1011801/011.png' ) }}"><span>ワクワクした</span></li>
          <li class="commentEmoji__item"><input type="radio" name="mark" value="008"><img src="{{ asset_auto( 'img/hakusyu/1011801/008.png' ) }}"><span>感動した</span></li>
          <li class="commentEmoji__item"><input type="radio" name="mark" value="004"><img src="{{ asset_auto( 'img/hakusyu/1011801/004.png' ) }}"><span>おいしそう</span></li>
          <li class="commentEmoji__item"><input type="radio" name="mark" value="003"><img src="{{ asset_auto( 'img/hakusyu/1011801/003.png' ) }}"><span>楽しそう</span></li>
          <li class="commentEmoji__item"><input type="radio" name="mark" value="009"><img src="{{ asset_auto( 'img/hakusyu/1011801/009.png' ) }}"><span>かわいかった</span></li>
        </ul>
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

