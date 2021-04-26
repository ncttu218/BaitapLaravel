<meta http-equiv="Content-Type" content="text/html; charset=Shift-JIS" />
<?php
// 販社名の設定パラメータを取得
$para_list = ( Config('original.para')[$hanshaCode] );
?>

<script language="JavaScript" src="/common-js/opendcs.js"></script>
<link rel="stylesheet" href="/common-css/infobbs_style.css" type="text/css">
<link rel="stylesheet" href="/common-css/cgi_common.css" type="text/css">

<a name="0"></a>

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')

<font style="font-size :12px; lineheight :12px;">

{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="SE-mb20">
<tbody><tr>
<td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody><tr> 
    <td nowrap="" class="infobbs_title02">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tbody><tr>
       <td><div class="font_black" align="left">[{{ $item->base_name }}]&nbsp;{{ $item->title }}</div></td>
       <td>
           <div class="font_black font10" align="right">
           <?php
            $time = strtotime($item->updated_at);
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
              $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
              ?>
              @if ($hasNoBr)
                {!! nl2br( $item->comment ) !!}
              @else
                {!! $item->comment !!}
              @endif
              @include($templateDir . '.images')
              </font>
            </td>
           </tr>
       </tbody>
       </table>
       {{-- SNS共有 --}}
       @include($templateDir . '.sns')
    </td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
@endforeach

</font>

{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')
