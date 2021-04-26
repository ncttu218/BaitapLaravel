<table width="100%" border="0" cellspacing="0" cellpadding="0" class="SE-mb20">
    <tbody><tr>
    <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody><tr> 
        <td nowrap="" class="infobbs_title02">
           <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tbody><tr>
           <td><div class="font_black" align="left">[{{ $blog->base_name }}]&nbsp;{{ $blog->title }}</div></td>
           <td>
               <div class="font_black font10" align="right">
               <?php
                $time = strtotime($blog->updated_at);
                ?>
                {{ date('Y/m/d', $time) }}
               </div>
           </td>
           </tr>
           </tbody></table>
        </td>
        </tr>
        </tbody></table>
    </td>
    </tr>
    <tr> 
        <td> 
           <table width="100%" border="0" cellspacing="0" cellpadding="3" class="blogInner">
           <tbody>
               <tr> 
                <td valign="top" bgcolor="#FFFFFF" align="left" class="InfobbsArticlesText">
                  <font size="2">
                  <?php
                  // 記事が改行が必要かの判定
                  $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $blog->comment);
                  ?>
                  @if ($hasNoBr)
                    {!! nl2br( $blog->comment ) !!}
                  @else
                    {!! $blog->comment !!}
                  @endif
                  @include($templateDir . '.images', ['item' => $blog])
                  </font>
                </td>
               </tr>
           </tbody>
           </table>
           {{-- SNS共有 --}}
           @include($templateDir . '.sns', ['item' => $blog])
        </td>
    </tr>
    </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
