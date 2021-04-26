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
@include('api.common.admin.infobbs.attention')
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
        @include('api.common.admin.infobbs.pagination')
        
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
        
        $num++;
        ?>
        <div class="p-entrylist-box">
            {{-- 拠点ごとテンプレート  --}}
            @include($template)
            
            <div class="p-entrylist-box__body">
                <!--
                {{-- 設定にカテゴリがあれば表示 --}}
                @if($category)
                <div class="col-sm-12">
                    カテゴリ:{{ $row->category ?  $row->category:'全て' }}
                </div>
                @endif
                -->

                <div class="p-entrylist-box__summary">
                    <div style="background:#fff; padding:30px">
                        <?php if($row->file1 || $row->file2 || $row->file3 || $row->file4 || $row->file5 || $row->file6 ){?> 
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
                        <?php } ?>
                        {{-- 記事が改行が必要かの判定 --}}
                        @if (has_no_nl($row->comment))
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

                            <dl class="c-control-edit__item">
                                <dt class="c-control-edit__head">削除</dt>
                                <dd class="c-control-edit__body">
                                    <p class="c-control-checkbox"><input type="checkbox" name="{{ $row->number }}[del]" value="<?php echo $num;?>" id="ListDelete_<?php echo $num;?>"><label for="ListDelete_<?php echo $num;?>">この記事を削除する</label></p>
                                </dd>
                            </dl>

                            <!-- CATEGORY -->
                            {{-- 設定にカテゴリがあれば表示 --}}
                            @if((isset($isEmergencyBulletin) && $isEmergencyBulletin) || count($category) <> 0)
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

                            <?php if ((!isset($isEmergencyBulletin) || !$isEmergencyBulletin) && count($comment) <> 0) { ?>
                            @include('api.common.admin.comment')
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
        @include('api.common.admin.infobbs.pagination')
        
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
