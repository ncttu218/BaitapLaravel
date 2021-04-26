<?php
// 販社名の設定パラメータを取得
$para_list = (config('original.para')[$hanshaCode]);
// 店舗除外
$categoryCounterOptions = ['shopExclusion' => $shopExclusion];

?>

<script language="JavaScript" src="/common-js/opendcs.js">
</script>
<link rel="stylesheet" href="/common-css/infobbs_style.css" type="text/css">
<link rel="stylesheet" href="/common-css/cgi_common.css" type="text/css">
<a name="0"></a>

<a name="0"></a>

<br clear="all">
            {{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
    <article>
        <div class="blog__header">
            <p class="blog__title"><span>【{{$item->base_name}}】</span>
                {{$item->title}}</p>
            <p class="blog__date">
                <?php
                $time = strtotime($item->updated_at);
                /*if (!empty($item->from_date)) {
                   $time = strtotime($item->from_date);
                }*/
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
                if (strtotime($item->created_at) < strtotime('2020-05-01')) {
                    $item->comment = preg_replace('/<p>[\r\n]+?<\/p>/', '<p><br /></p>', $item->comment);
                }
                $item->comment = str_replace('<br />','',$item->comment);
                ?>
                @if ($hasNoBr)
                    {!! nl2br( $item->comment ) !!}
                @else
                    {!! $item->comment !!}
                @endif
            </div>
            @include('api.common.api.infobbs.image_list_default')
            <div style="clear:both;">
            </div>
        @if( $para_list['comment'] === '1' )
            <table>
                <tbody>
                <tr>
                    <td align="left" valign="middle">
                        <div class="hakusyu font10">
                            <div class="hakusyu font10">
                                この記事の感想：{{ $CodeUtil::getBlogCommentCountTotal( $hanshaCode, $item->number  ) }}
                                件
                            </div>
                        </div>

                        <?php
                        // コメント件数
                        $commentCount = $CodeUtil::getBlogCommentCountTotal($hanshaCode, $item->number);
                        // 感想の一覧を取得
                        $commentList = $CodeUtil::getBlogCommentCountList($hanshaCode, $item->number);
                        $formUrl = $CodeUtil::getV2Url('Api\CommentPostController@getIndex', $hanshaCode);
                        $formUrl .= "?hansha_code={$hanshaCode}&blog_data_id={$item->number}&style=default";
                        ?>
                        @if( !$commentList->isEmpty() )
                            @foreach ( $commentList as $commentValue )
                                @if (empty($commentValue->mark))
                                    @continue
                                @endif
                                <div class="hakusyu">
                                    <img src="{{ asset_auto( 'img/hakusyu/' . $commentValue->mark . '.png' ) }}"
                                         style="width: 20px !important;">{{ $commentValue->comment_count }}
                                </div>
                            @endforeach
                        @endif
                        <div class="hakusyu font10">
                            <button onClick="window.open( '{{ $formUrl }}','_blank','width=300,height=550,scrollbars=yes');return false;">
                                感想を送る
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        @endif
        </div>
    </article>
@endforeach
        <!-- ZERO END -->
            {{-- ページネーションの読み込み --}}
@include($templateDir . '.pagination')
