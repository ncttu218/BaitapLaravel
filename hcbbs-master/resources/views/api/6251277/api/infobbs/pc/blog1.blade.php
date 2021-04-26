<script language="JavaScript" src="/common-js/opendcs.js"></script>
<link rel="stylesheet" href="/common-css/infobbs_style.css" type='text/css'>
<link rel="stylesheet" href="/common-css/cgi_common.css" type='text/css'>

<a name="0"></a>
{{-- カテゴリー --}}
@include($templateDir . '.category')

@include($templateDir . '.pagination')
<font style="font-size :12px; lineheight :12px;">
<br clear="all">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tbody>
{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
<tr>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="SE-mb20">
   <tr>
      <td nowrap class="srblog_title">
         <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
               <td>
                  <div class="font_black font12" align="left"><span>{{ $item->base_name }}</span>&nbsp;{{ $item->title }}</div>
               </td>
               <td>
                   <div class="font_black font10" align="right">
                       <?php
                        $time = strtotime($item->updated_at);
                        if (!empty($item->from_date)) {
                            $time = strtotime($item->from_date);
                        }
                        ?>
                        {{ date('Y.m.d', $time) }}
                   </div>
               </td>
            </tr>
         </table>
      </td>
   </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
   <tr>
      <td valign="top" bgcolor="#FFFFFF" align="left">
         <font size="2">
            @include('api.common.api.infobbs.image_list_default')
            
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
            <br>
            <div class="infobbs_inquiry"><br /></div>
         </font>
      </td>
   </tr>
   <tr>
      <td valign="top" bgcolor="#FFFFFF">
         <table border="0" cellspacing="0" cellpadding="1">
            <tr valign="bottom">
               <td bgcolor="#FFFFFF"><font style="font-size:10px;"></font></td>
               <td bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                  </font>
               </td>
               <td bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                  </font>
               </td>
            </tr>
            <tr align="left">
               <td valign="top" bgcolor="#FFFFFF" class="SE-w220"><font style="font-size:10px;"> 
                  </font>
               </td>
               <td valign="top" bgcolor="#FFFFFF" class="SE-w220"><font style="font-size:10px;"> 
                  </font>
               </td>
               <td valign="top" bgcolor="#FFFFFF" class="SE-w220"><font style="font-size:10px;"> 
                  </font>
               </td>
            </tr>
         </table>
      </td>
   </tr>
   {{-- コメント --}}
   @include($templateDir . '.comment')
</table>
</tr>
@endforeach
</tbody>
</table>
</font>
<!-- ZERO END -->
@include($templateDir . '.pagination')
