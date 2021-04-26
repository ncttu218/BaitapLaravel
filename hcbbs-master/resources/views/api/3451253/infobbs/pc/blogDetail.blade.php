<section class="blog">
  <h2 class="borderOrange">
      <p>
          {{ $blog->title }}
          <span>
              <?php
              $time = strtotime($blog->updated_at);
              if (!empty($blog->from_date)) {
                  $time = strtotime($blog->from_date);
              }
              // 画像のパスを置換する。
              $comment = str_replace( "img.hondanet.co.jp", "image.hondanet.co.jp", $blog->comment );
              ?>
              {{ date('Y/m/d', $time) }}
          </span>
      </p>
  </h2>
  <div class="section_inner">
      <article class="blog_box">
          {!! $comment !!}
          <figure>
          <ul class="photo">
          </ul>
          </figure>
        </article>
    </div><!-- /.section_inner -->

</section>