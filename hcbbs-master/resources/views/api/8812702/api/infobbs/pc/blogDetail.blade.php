<?php
// 販社名の設定パラメータを取得
$para_list = ( Config('original.para')[$hanshaCode] );
?>

<script language="JavaScript" src="/common-js/opendcs.js"></script>
<link rel="stylesheet" href="/common-css/infobbs_style.css" type='text/css'>
<link rel="stylesheet" href="/common-css/cgi_common.css" type='text/css'>
<?php
// タイトル
$blog->title = $convertEmojiToHtmlEntity($blog->title);
// 本文
$blog->comment = $convertEmojiToHtmlEntity($blog->comment);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr> 
    <td nowrap class="infobbs_title02">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
        {{-- タイトル --}}
        <td>
            <div class="font_black" align="left">[{{ $blog->base_name }}]&nbsp;{{ $blog->title }}</div>
        </td>

        {{-- 掲載日時 --}}
        <td>
            <div class="font_black font10" align="right">
            <?php
            $time = strtotime($blog->updated_at);
            if (!empty($blog->from_date)) {
                $time = strtotime($blog->from_date);
            }
            ?>
            {{ date('Y/m/d', $time) }}
            </div>
        </td>
        </tr>
    </table>
    </td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="3" class="infobbs_article">
{{-- 画像 --}}
@include($templateDir . '.images', ['item' => $blog])

{{-- 本文 --}}
<tr> 
    <td valign="top" bgcolor="#FFFFFF" align="left"><font size="2">
    <?php
    // 記事が改行が必要かの判定
    $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $blog->comment);
    ?>
    @if ($hasNoBr)
        {!! nl2br( $blog->comment ) !!}
    @else
        {!! $blog->comment !!}
    @endif
    </td>
</tr>

{{-- 設定ファイルのコメント機能NOのとき --}}
@if( $para_list['comment'] === '1' )
    <tr>
    <td>
        <table width="100%">
        <tr>
            <td align="right" valign="middle">
                @if (isset($blog->category) && !empty($blog->category))
                <tr>
                    <td align="right" valign="middle">
                        <font style="font-size:8px;">カテゴリ:{{ $blog->category }}</font>&nbsp;
                    </td>
                </tr>
                @endif
            </td>
        </tr>
        <tr>
            <td align="right" valign="middle">
            <div class="hakusyu font10">
                この記事の感想：{{ $CodeUtil::getBlogCommentCountTotal( $hanshaCode, $blog->number  ) }}件 
            </div>
                
            {{-- 感想の一覧を取得 --}}
            <?php
            $commentList = $CodeUtil::getBlogCommentCountList( $hanshaCode, $blog->number );
            ?>
            {{-- 感想の一覧にデータが存在するとき --}}
            @if( !$commentList->isEmpty() )
                @foreach ( $commentList as $commentValue )
                <div class="hakusyu">
                    <img src="{{ asset_auto( 'img/hakusyu/' . $commentValue->mark . '.png' ) }}" width="20px">{{ $commentValue->comment_count }}&nbsp;
                </div>
                @endforeach
            @endif
            
            <div class="hakusyu font10">
                <button onClick="window.open( '{{ url_auto('/api/comment_post') }}?hansha_code={{ $hanshaCode }}&blog_data_id={{ $blog->number }}','_blank','width=300,height=550,scrollbars=yes');return false;">感想を送る</button>
            </div>
            </td>
        </tr>
        </table>
    </td>
    </tr>
@endif
</table>
