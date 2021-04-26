
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
      {!! Form::open( ['method' => 'POST', 'url' => action_auto( 'Api\StaffCommentPostController@postCreate' )] ) !!}
        {!! Form::hidden( 'hansha_code', $hansha_code ) !!}
        {!! Form::hidden( 'blog_data_id', $blog_data_id ) !!}

        <p class="commentTitle">コメント投稿</p>
        <ul class="commentEmoji">
          <li class="commentEmoji__item"><input type="radio" name="mark" value="001"><img src="{{ asset_auto( 'img/hakusyu/001.png' ) }}"><span>面白かった</span></li>
          <li class="commentEmoji__item"><input type="radio" name="mark" value="002"><img src="{{ asset_auto( 'img/hakusyu/002.png' ) }}"><span>驚いた</span></li>
          <li class="commentEmoji__item"><input type="radio" name="mark" value="003"><img src="{{ asset_auto( 'img/hakusyu/003.png' ) }}"><span>楽しかった</span></li>
          <li class="commentEmoji__item"><input type="radio" name="mark" value="004"><img src="{{ asset_auto( 'img/hakusyu/004.png' ) }}"><span>おいしそう</span></li>
          <li class="commentEmoji__item"><input type="radio" name="mark" value="005"><img src="{{ asset_auto( 'img/hakusyu/005.png' ) }}"><span>悲しかった</span></li>
          <li class="commentEmoji__item"><input type="radio" name="mark" value="006"><img src="{{ asset_auto( 'img/hakusyu/006.png' ) }}"><span>悔しい</span></li>
          <li class="commentEmoji__item"><input type="radio" name="mark" value="007"><img src="{{ asset_auto( 'img/hakusyu/007.png' ) }}"><span>キレイだった</span></li>
          <li class="commentEmoji__item"><input type="radio" name="mark" value="008"><img src="{{ asset_auto( 'img/hakusyu/008.png' ) }}"><span>感動した</span></li>
          <li class="commentEmoji__item"><input type="radio" name="mark" value="009"><img src="{{ asset_auto( 'img/hakusyu/009.png' ) }}"><span>かわいかった</span></li>
          <li class="commentEmoji__item"><input type="radio" name="mark" value="010"><img src="{{ asset_auto( 'img/hakusyu/010.png' ) }}"><span>怒った</span></li>
          <li class="commentEmoji__item"><input type="radio" name="mark" value="011"><img src="{{ asset_auto( 'img/hakusyu/011.png' ) }}"><span>ワクワクした</span></li>
          <li class="commentEmoji__item"><input type="radio" name="mark" value="012"><img src="{{ asset_auto( 'img/hakusyu/012.png' ) }}"><span>怖かった</span></li>
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
