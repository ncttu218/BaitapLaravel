@foreach ($blogs as $i => $item)
<article class="top-blog-card top-blog-card--gray">
   <a href="home/sr03.html">
      <div class="top-blog-inner">
         <h3 class="top-blog-sr">前橋問屋町店</h3>
         <!-- .top-blog-card-sr -->
         <figure class="top-blog-fig">
            <div class="top-blog-fig__inner">
               <img src="https://image.hondanet.co.jp/cgi/1651901/infobbs/data/image/1651901_infobbs_20200214175105_E99D92FIT.JPG" alt="">
            </div>
            <!-- .top-blog-fig__inner -->
         </figure>
         <!-- .top-blog-fig -->
         <h4 class="top-blog-title">新型FITはココが違...</h4>
         <!-- .top-blog-title -->
         <p class="top-blog-text">みなさまこんにちは。大好評の新型FIT！みな...</p>
         <!-- .top-blog-text -->
      </div>
      <!-- .top-blog-card-inner -->
   </a>
</article>
<!-- .top-blog-card -->
@endforeach
