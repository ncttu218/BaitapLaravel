<script language="JavaScript" src="/common-js/opendcs.js"></script>
{{-- ページネーション --}}
@include($templateDir . '.pagination')
{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
<article>
   <div class="blog__header">
      <p class="blog__title"><span>【{{ $item->base_name }}】</span>
         {{ $item->title }}
      </p>
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
      
      @include('v2.common.api.infobbs.image_list_default')
      <div>
         <font style="font-size:10px;">   
         </font> 
      </div>
      <div style="clear:both;">
         <table>
            <tr>
               <td align="left" valign="middle">
                  <div class="hakusyu font10">
                     <p></p>
                  </div>
               </td>
            </tr>
         </table>
      </div>
   </div>
</article>
@endforeach
<!-- ZERO END -->
{{-- ページネーション --}}
@include($templateDir . '.pagination')
