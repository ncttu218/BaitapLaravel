{{-- カテゴリーレイアウトを継承 --}}
@extends('master._master_ja_blank')

{{-- CSSの定義 --}}
@section('css')
@parent
<style type="text/css">
.p-entrylist-box__images img{
    width: 240px;
    height: auto;
}
</style>
@stop

{{-- JSの定義 --}}
@section('js')
@parent
@stop

{{-- メイン部分の呼び出し --}}
@section('content')
@include('infobbs.attention')
<section class="c-section-container _both-space">
    <h2 class="c-section-title">{{ $shopName }} 記事の編集・削除</h2>
    
    <form action="{{ $urlAction }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="shop" value="{{ $shopCode  }}">
        
        @if (!empty($shopName))
        <div class="c-frame-box _no-shadow">
            <div class="c-frame-box__head">新規投稿</div>
            <div class="c-frame-box__body">
                <a href="{{ $urlNew }}" class="c-entry-button _color-1">新しく記事を書く</a>
                @if ($mailReg == '1')
                <small>
                    <a href="#" onClick="window.open('{{ $urlMailRegister }}',
                            'KTAI','width=400,height=300,scrollbars=yes');">
                        携帯投稿用アドレス管理ページへ</a>
                </small>
                @endif
            </div>
        </div>
        <!-- /.c-frame-box -->
        @endif
        
        @if ($blogs->count() > 0)
        <div class="c-frame-box _no-shadow">
            <div class="c-frame-box__head">一括編集：記事を公開/非公開・削除できます</div>
            <div class="c-frame-box__body">
                <label href="#" class="c-entry-button _color-2"><input type="submit" value="一括編集">チェックした記事を一括編集</label>
                <p class="c-warning c-frame-box__warning">【注意】一度削除した記事は元に戻せません。</p>
            </div>
        </div>
        <!-- /.c-frame-box -->
        
        {{-- ページ表示 --}}
        @include('infobbs.pagination')
        
        {{-- 複数ブログ表示 --}}
        <?php $num = 0; ?>
        @foreach($blogs as $row)
        <?php
        $disp_span = '';
        if(!empty($row->from_date)){
            $from_date = date('Y/m/d', strtotime($row->from_date));
            $disp_span .= "{$from_date}から";
        }
        if(!empty($row->to_date)){
            $to_date = date('Y/m/d', strtotime($row->to_date));
            $disp_span .= "{$to_date}まで";
        }
        if (empty($disp_span)) {
            $disp_span .= '----/--/--';
        }
        
        // リリースのステータス
        $editflag_release = $row->editflag == 'release' ? ' checked="checked"' : '';
        // ドラフトのステータス
        $editflag_draft = $row->editflag == 'draft' ? ' checked="checked"' : '';
        // 本社リリースのステータス
        switch ($row->published) {
            case 'ON': $release_honsya = '◯公開';
                break;
            case 'NG': $release_honsya = '✖掲載不可';
                break;
            case 'OFF': $release_honsya = '◇掲載処理待ち';
                break;
        }
        // 店舗からのメッセージ
        $row->msg1 = str_replace('<', '&lt;', $row->msg1);
        $row->msg1 = str_replace('>', '&gt;', $row->msg1);
        // 本社からのメッセージ
        $row->msg2 = str_replace('<', '&lt;', $row->msg2);
        $row->msg2 = str_replace('>', '&gt;', $row->msg2);
        $row->msg2 = nl2br($row->msg2);
        
        $num++;
        ?>
        <div class="p-entrylist-box">
            {{-- 拠点ごとテンプレート  --}}
            @include($template)
            
            <div class="p-entrylist-box__body">
                <div class="p-entrylist-box__summary">
                    <div style="background:#fff; padding:30px">
                        <?php if(isset($row->file1) || isset($row->file2) || isset($row->file3) || isset($row->file4) || isset($row->file5) || isset($row->file6) ){?> 
                        <div class="p-entrylist-box__images">
                            <table>
                                <tr>
                                    @if (!empty($row->file1))
                                        <td style="font-size:10px;padding:5px;">
                                            <?php
                                            // ファイルパスの情報を取得する
                                            $fileinfo1 = pathinfo( $row->file1 );
                                            ?>
                                            {{-- PDFファイルの対応 --}}
                                            @if( strtolower( $fileinfo1['extension'] ) === "pdf" )
                                                <a href="{{ asset_auto($row->file1) }}" target="_blank">
                                                    <img src="{{ $CodeUtil::getPdfThumbnail( $row->file1 ) }}" width="200" alt="{{ $row->caption1 }}">
                                                </a>
                                            @else
                                                <img src="{{ asset_auto($row->file1) }}" alt="{{ $row->caption1 }}">
                                            @endif
                                            <br>
                                            {!! $row->caption1 ?? '' !!}
                                        </td>
                                    @endif
                                    @if (!empty($row->file2))
                                        <td style="font-size:10px;padding:5px;">
                                            <?php
                                            // ファイルパスの情報を取得する
                                            $fileinfo2 = pathinfo( $row->file2 );
                                            ?>
                                            {{-- PDFファイルの対応 --}}
                                            @if( strtolower( $fileinfo2['extension'] ) === "pdf" )
                                                <a href="{{ asset_auto($row->file2) }}" target="_blank">
                                                    <img src="{{ $CodeUtil::getPdfThumbnail( $row->file2 ) }}" width="200" alt="{{ $row->caption2 }}">
                                                </a>
                                            @else
                                                <img src="{{ asset_auto($row->file2) }}" alt="{{ $row->caption2 }}">
                                            @endif
                                            <br>
                                            {!! $row->caption2 ?? '' !!}
                                        </td>
                                    @endif
                                    @if (!empty($row->file3))
                                        <td style="font-size:10px;padding:5px;">
                                            <?php
                                            // ファイルパスの情報を取得する
                                            $fileinfo3 = pathinfo( $row->file3 );
                                            ?>
                                            {{-- PDFファイルの対応 --}}
                                            @if( strtolower( $fileinfo3['extension'] ) === "pdf" )
                                                <a href="{{ asset_auto($row->file3) }}" target="_blank">
                                                    <img src="{{ $CodeUtil::getPdfThumbnail( $row->file3 ) }}" width="200" alt="{{ $row->caption3 }}">
                                                </a>
                                            @else
                                                <img src="{{ asset_auto($row->file3) }}" alt="{{ $row->caption3 }}">
                                            @endif
                                            <br>
                                            {!! $row->caption3 ?? '' !!}
                                        </td>
                                    @endif
                                    @if (!empty($row->file4))
                                        <td style="font-size:10px;padding:5px;">
                                            <?php
                                            // ファイルパスの情報を取得する
                                            $fileinfo4 = pathinfo( $row->file4 );
                                            ?>
                                            {{-- PDFファイルの対応 --}}
                                            @if( strtolower( $fileinfo4['extension'] ) === "pdf" )
                                                <a href="{{ asset_auto($row->file4) }}" target="_blank">
                                                    <img src="{{ $CodeUtil::getPdfThumbnail( $row->file4 ) }}" width="200" alt="{{ $row->caption4 }}">
                                                </a>
                                            @else
                                                <img src="{{ asset_auto($row->file4) }}" alt="{{ $row->caption4 }}">
                                            @endif
                                            <br>
                                            {!! $row->caption4 ?? '' !!}
                                        </td>
                                    @endif
                                    @if (!empty($row->file5))
                                        <td style="font-size:10px;padding:5px;">
                                            <?php
                                            // ファイルパスの情報を取得する
                                            $fileinfo5 = pathinfo( $row->file5 );
                                            ?>
                                            {{-- PDFファイルの対応 --}}
                                            @if( strtolower( $fileinfo5['extension'] ) === "pdf" )
                                                <a href="{{ asset_auto($row->file5) }}" target="_blank">
                                                    <img src="{{ $CodeUtil::getPdfThumbnail( $row->file5 ) }}" width="200" alt="{{ $row->caption5 }}">
                                                </a>
                                            @else
                                                <img src="{{ asset_auto($row->file5) }}" alt="{{ $row->caption5 }}">
                                            @endif
                                            <br>
                                            {!! $row->caption5 ?? '' !!}
                                        </td>
                                    @endif
                                    @if (!empty($row->file6))
                                        <td style="font-size:10px;padding:5px;">
                                            <?php
                                            // ファイルパスの情報を取得する
                                            $fileinfo6 = pathinfo( $row->file6 );
                                            ?>
                                            {{-- PDFファイルの対応 --}}
                                            @if( strtolower( $fileinfo6['extension'] ) === "pdf" )
                                                <a href="{{ asset_auto($row->file6) }}" target="_blank">
                                                    <img src="{{ $CodeUtil::getPdfThumbnail( $row->file6 ) }}" width="200" alt="{{ $row->caption6 }}">
                                                </a>
                                            @else
                                            <img src="{{ asset_auto($row->file6) }}" alt="{{ $row->caption6 }}">
                                            @endif
                                            <br>
                                            {!! $row->caption6 ?? '' !!}
                                        </td>
                                    @endif
                                </tr>
                            </table>
                        </div>
                        <br>
                        <?php }
                        
                        // 記事が改行が必要かの判定
                        $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $row->comment);
                        ?>
                        @if ($hasNoBr)
                            {!! nl2br( $row->comment ) !!}
                        @else
                            {!! $row->comment !!}
                        @endif
                    </div>
                </div>

                <div class="p-entrylist-box__date">
                    <dl class="p-entrylist-date">
                        <dt>編集日時</dt>
                        <dd>{{ str_replace('-', '/', $row->updated_at) }}</dd>
                    </dl>
                    <dl class="p-entrylist-date">
                        <dt>掲載期間</dt>
                        <dd><?php echo $disp_span;?></dd>
                    </dl>
                </div>
                <div class="p-entrylist-box__button">
                    <a href="{{ $urlAction . "?action=edit&shop={$row->shop}&number=" . $row->number }}" class="c-entry-button _color-1">この投稿を編集する</a>
                </div>

                <div class="c-control-container p-entrylist-box__control">
                    <div class="c-control-container__head">一括編集設定</div>
                    <div class="c-control-container__input">
                        <div class="c-control-edit">
                            <?php if($row->editflag == 'draft' || $row->editflag == 'release'){ //本社承認機能アリの場合（申請方式） ?>
                            <dl class="c-control-edit__item">
                                <dt class="c-control-edit__head">公開設定</dt>
                                <dd class="c-control-edit__body">
                                    <table>
                                        <tr>
                                            <td style="vertical-align:middle" colspan="2">公開申請：
                                                <p class="c-control-radio">
                                                    <input type="radio" name="{{ $row->number }}[editflag]" value="release" id="editflag_<?php echo $num; ?>_release" <?php echo $editflag_release;?>>
                                                    <label for="editflag_<?php echo $num; ?>_release">申請中</label>
                                                </p>
                                                <p class="c-control-radio">
                                                    <input type="radio" name="{{ $row->number }}[editflag]" value="draft" id="editflag_<?php echo $num; ?>_draft" <?php echo $editflag_draft;?>>
                                                    <label for="editflag_<?php echo $num; ?>_draft">申請前</label>
                                                </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align:middle">お店から：</td>
                                            <td>
                                                <textarea name="{{ $row->number }}[msg1]" style="width:550px;height:50px;"
                                                    placeholder="いつ公開希望かをお書きください（本社業務時間内のみ対応）"><?php echo $row->msg1; ?></textarea>
                                            </td>
                                        </tr>
                                        <tr><td style="vertical-align:middle" colspan="2">本社から：<?php echo $row->msg2; ?></td></tr>
                                        <tr><td style="vertical-align:middle" colspan="2">本社処理：<?php echo $release_honsya;?></td></tr>
                                    </table>
                                </dd>
                            </dl>
                            <?php } elseif($row->editflag == 'honsya') { //本社承認機能アリの場合（本社一任） ?>
                            <dl class="c-control-edit__item">
                                <dt class="c-control-edit__head">公開設定</dt>
                                <dd class="c-control-edit__body">
                                    <table>
                                        <tr><td style="vertical-align:middle" colspan="2">本社処理：<?php echo $release_honsya;?></td></tr>
                                    </table>
                                </dd>
                            </dl>
                            <?php } else { ?> 
                            <dl class="c-control-edit__item">
                                <dt class="c-control-edit__head">公開設定</dt>
                                <dd class="c-control-edit__body">
                                    <p class="c-control-radio">
                                        <input type="radio" name="{{ $row->number }}[published]" value="ON" id="display_<?php echo $num;?>_ON" {{ $row->published == 'ON' ? 'checked' : null }}>
                                        <label for="display_<?php echo $num;?>_ON">公開</label>
                                    </p>
                                    <p class="c-control-radio">
                                        <input type="radio" name="{{ $row->number }}[published]" value="OFF" id="display_<?php echo $num;?>_OFF" {{ $row->published != 'ON' ? 'checked' : null }}>
                                        <label for="display_<?php echo $num;?>_OFF">非公開</label>
                                    </p>
                                </dd>
                            </dl>
                            <?php } ?>

                            <dl class="c-control-edit__item">
                                <dt class="c-control-edit__head">削除</dt>
                                <dd class="c-control-edit__body">
                                    <p class="c-control-checkbox"><input type="checkbox" name="{{ $row->number }}[del]" value="<?php echo $num;?>" id="ListDelete_<?php echo $num;?>"><label for="ListDelete_<?php echo $num;?>">この記事を削除する</label></p>
                                </dd>
                            </dl>

                            <!-- CATEGORY -->
                            {{-- 設定にカテゴリがあれば表示 --}}
                            @if(count($category) <> 0)
                            <?php 
                                // チェックされたカテゴリを配列に入れる
                                $cat_val = explode(',', $row->category);
                            ?>
                            <dl class="c-control-edit__item">
                                <dt class="c-control-edit__head">カテゴリ</dt>
                                <dd class="c-control-edit__body">
                                @foreach($category as $cat_num => $cat_name)
                                    <?php
                                        // カテゴリがあればチェックを付ける
                                        $cat_checked = '';
                                        if(in_array($cat_name,$cat_val)){
                                            $cat_checked = 'checked';
                                        }
                                    ?>
                                    <p class="c-control-checkbox">
                                    <input type="checkbox" name="{{ $row->number }}[category][{{ $cat_num }}]" value="<?php echo $cat_name;?>" id="category_<?php echo $num;?>_<?php echo $cat_num ?>" {{ $cat_checked }}>
                                    <label for="category_<?php echo $num;?>_<?php echo $cat_num ?>">{{ $cat_name }}</label>
                                    </p>
                                    <br>
                                @endforeach
                                </dd>
                            </dl>
                            @endif

                            <?php if (count($comment) <> 0) { ?>
                            <dl class="c-control-edit__item">
                                <dt class="c-control-edit__head">コメント</dt>
                                <dd class="c-control-edit__body">
                                    <table style="margin:0px;width:100%;">
                                    <?php $style = '';?>
                                    @foreach($comment[$row->number] as $com)
                                        <tr style="{{ $style }}">
                                        <td style="font-size:10px;">{{ $com['date'] }}</td>
                                        @if($com['mark'])
                                        <td style="padding: 0 5px;"><img src="{{ asset_auto($com['mark']) }}" width="25%" ></td>
                                        @else
                                        <td style="padding: 0 5px;">  </td>
                                        @endif
                                        <td style="font-size:10px;">{{ $com['comment'] }}</td>
                                        </tr>
                                        <?php $style = "border-top:1px solid #aaa;"; ?>
                                    @endforeach
                                    </table>
                                </dd>
                            </dl>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="c-control-container__order">
                        <ul class="c-control-order">
                            <li class="c-control-order__item">
                                <a class="c-control-order__anchor _up" href="{{ $urlAction . "?action=up" ."&number=" . $row->number . "&shop=" . $shopCode }}">1つ上へ</a>
                            </li>
                            <li class="c-control-order__item">
                                <a class="c-control-order__anchor _down" href="{{ $urlAction . "?action=down" ."&number=" . $row->number . "&shop=" . $shopCode }}">1つ下へ</a>
                            </li>
                            <li class="c-control-order__item">
                                <a class="c-control-order__anchor _topmost" href="{{ $urlAction . "?action=upper" ."&number=" . $row->number . "&shop=" . $shopCode }}">最上部へ</a>
                            </li>
                            <li class="c-control-order__item">
                                <a class="c-control-order__anchor _bottommost" href="{{ $urlAction . "?action=lower" ."&number=" . $row->number . "&shop=" . $shopCode }}">最下部へ</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
        {{-- ページ表示 --}}
        @include('infobbs.pagination')
        
        <div class="c-frame-box _no-shadow">
            <div class="c-frame-box__head">一括編集：記事を公開/非公開・削除できます</div>
            <div class="c-frame-box__body">
                <label href="#" class="c-entry-button _color-2"><input type="submit" value="一括編集">チェックした記事を一括編集</label>
                <p class="c-warning c-frame-box__warning">【注意】一度削除した記事は元に戻せません。</p>
            </div>
        </div>
        <!-- /.c-frame-box -->
         @endif
    </form>
</section>
@stop
