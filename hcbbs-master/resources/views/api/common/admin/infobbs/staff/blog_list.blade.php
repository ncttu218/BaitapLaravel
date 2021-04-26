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
    <h2 class="c-section-title">{{ $staffName }} 記事の編集・削除</h2>

    <div class="p-entrylist">
        <form action="" name="adminForm" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="c-frame-box _no-shadow">
                <div class="c-frame-box__head">新規投稿</div>
                <div class="c-frame-box__body">
                    <a href="{{ $urlActionNew }}" class="c-entry-button _color-1">新しく記事を書く</a>
                </div>
            </div>

            @if ($blogs->count() > 0)
            <div class="c-frame-box _no-shadow">
                <div class="c-frame-box__head">一括編集：選択した記事を一括で削除できます</div>
                <div class="c-frame-box__body">
                    <label href="#" class="c-entry-button _color-2"><input type="submit" value="一括編集">チェックした記事を一括編集</label>
                    <p class="c-warning c-frame-box__warning">【注意】一度削除した記事は元に戻せません。</p>
                </div>
            </div>
            <!-- /.c-frame-box -->
            @endif
            
            <!-- /.p-entrylist-navigation -->

            <div class="p-entrylist-box">
                <?php $num = 0; ?>
                @foreach($blogs as $row)
                <?php
                $num++;
                $time = strtotime($row->updated_at);
                ?>
                <div class="p-entrylist-box__head">
                    <h3 class="p-entrylist-box__title">{{ $row->title }}</h3>
                    <div class="p-entrylist-box__sign">{{ date('Y/m/d', $time) }}</div>
                </div>
                <div class="p-entrylist-box__body">
                    <?php if($row->file || $row->file2 || $row->file3){?> 
                    <div class="p-entrylist-box__images">
                        <table>
                            <tr>
                                @if (isset($row->file) && !empty($row->file))
                                    <td style="font-size:10px;padding:5px;">
                                        <img src="{{ asset_auto($row->file) }}" alt="{{ $row->caption }}">
                                        <br>
                                        {{ $row->caption ?? '' }}
                                    </td>
                                @endif
                                @if (isset($row->file2) && !empty($row->file2))
                                    <td style="font-size:10px;padding:5px;">
                                        <img src="{{ asset_auto($row->file2) }}" alt="{{ $row->caption2 }}">
                                        <br>
                                        {{ $row->caption2 ?? '' }}
                                    </td>
                                @endif
                                @if (isset($row->file3) && !empty($row->file3))
                                    <td style="font-size:10px;padding:5px;">
                                        <img src="{{ asset_auto($row->file3) }}" alt="{{ $row->caption3 }}">
                                        <br>
                                        {{ $row->caption3 ?? '' }}
                                    </td>
                                @endif
                            </tr>
                        </table>
                    </div>
                    <br>
                    <?php } ?>
                    <div class="p-entrylist-box__summary">{!! $row->comment !!}</div>
                    <div class="p-entrylist-box__date">
                        <dl class="p-entrylist-date">
                            <dt>編集日時</dt>
                            <dd>{{ date('Y/m/d H:i:s', $time) }}</dd>
                        </dl>
                    </div>
                    <div class="p-entrylist-box__button">
                        <a href="{{ $urlAction . "?action=edit&shop={$row->shop}&number=" . $row->number . "&treepath=" . $row->treepath }}" class="c-entry-button _color-1">この投稿を編集する</a>
                    </div>
                    <div class="c-control-container p-entrylist-box__control">
                        <div class="c-control-container__head">一括編集設定</div>
                        <div class="c-control-container__input">
                            <div class="c-control-edit">
                                <dl class="c-control-edit__item">
                                    <dt class="c-control-edit__head">削除</dt>
                                    <dd class="c-control-edit__body">
                                        <p class="c-control-checkbox">
                                            <input type="checkbox" name="{{ $row->number }}[del]" value="{{ $row->number }}" id="ListDelete_{{ $row->number }}">
                                            <label for="ListDelete_{{ $row->number }}">この記事を削除する</label>
                                        </p>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- /.p-entrylist-navigation -->

            @if ($blogs->count() > 0)
            <div class="c-frame-box _no-shadow">
                <div class="c-frame-box__head">一括編集：選択した記事を一括で削除できます</div>
                <div class="c-frame-box__body">
                    <label href="#" class="c-entry-button _color-2">
                    <input type="submit" value="一括編集">チェックした記事を一括編集</label>
                    <p class="c-warning c-frame-box__warning">【注意】一度削除した記事は元に戻せません。</p>
                </div>
            </div>
            <!-- /.c-frame-box -->
            @endif

        </form>

    </div>
    <!-- /.p-entrylist -->
</section>
@stop
