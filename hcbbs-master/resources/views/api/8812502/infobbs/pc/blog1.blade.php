{{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination1')

<?php
// 販社名の設定パラメータを取得
$para_list = ( Config('original.para')[$hanshaCode] );
?>

{{-- 設定ファイルのカテゴリー機能NOのとき --}}
@if( isset( $para_list['category'] ) && $para_list['category'] !== '' )
<?php
// カテゴリーの配列を取得
$categoryList = explode(",", $para_list['category']);
?>

<div align="left">
    <a href="?category=">全て({{ $CodeUtil::getBlogTotalSum( $hanshaCode, $shopCode ) }})</a>&nbsp;

    {{-- カテゴリー一覧を表示するループ --}}
    @foreach ( $categoryList as $category )
    <?php
    $count = $CodeUtil::getBlogTotalSum($hanshaCode, $shopCode, $category);
    ?>
    <a href="?shop={{ $shopCode }}&category={{ $category }}">
        {{ $category }}({{  ( isset( $count ) )? $count: 0 }})
    </a>&nbsp;
    @endforeach
</div>

@endif

{{-- 記事データが存在するとき --}}
<div class="container">
    <div class="blogList">
        @foreach ($blogs as $item)
        <table width="100%" border="0" cellspacing="0" cellpadding="3">
            <tbody><tr> 

                    <td> 
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody><tr> 
                                    <td bgcolor="#FFFFFF"> 
                                        <table width="100%" border="0" cellspacing="1" cellpadding="0">
                                            <tbody><tr> 
                                                    <td> 
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tbody><tr> 
                                                                    <td align="left" nowrap="" bgcolor="#000066"> 
                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                                            <tbody><tr> 
                                                                                    <td bgcolor="#dddddd" class="m"><b>{{ $item->title }}</b></td>
                                                                                    <td bgcolor="#dddddd" align="right">
                                                                                        <font style="font-size:10px;">
                                                                                        <?php
                                                                                        $time = strtotime($item->updated_at);
                                                                                        if (!empty($item->from_date)) {
                                                                                            $time = strtotime($item->from_date);
                                                                                        }
                                                                                        ?>
                                                                                        {{ date('Y/m/d', $time) }}
                                                                                        </font>
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
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="3">
                                                            <tbody><tr> 
                                                                    <td valign="top" bgcolor="#FFFFFF">
                                                                        <?php
                                                                        // 記事が改行が必要かの判定
                                                                        $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $item->comment);
                                                                        ?>
                                                                        @if ($hasNoBr)
                                                                        {!! nl2br( $item->comment ) !!}
                                                                        @else
                                                                        {!! $item->comment !!}
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr> 
                                                                    <td valign="top" bgcolor="#FFFFFF" nowrap=""> 
                                                                        <table border="0" cellspacing="0" cellpadding="1">
                                                                            <tbody>
                                                                                <tr valign="bottom"> 
                                                                                    <td bgcolor="#FFFFFF"><font style="font-size:10px;"></font></td>
                                                                                    <td bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                                                                                        </font></td>
                                                                                    <td bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                                                                                        </font></td>
                                                                                </tr>
                                                                                <tr> 
                                                                                    <td valign="top" bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                                                                                        </font></td>
                                                                                    <td valign="top" bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                                                                                        </font></td>
                                                                                    <td valign="top" bgcolor="#FFFFFF"><font style="font-size:10px;"> 
                                                                                        </font></td>
                                                                                </tr>
                                                                            </tbody></table>
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                    </td>
                                </tr>
                            </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        @endforeach
    </div>
</div>
