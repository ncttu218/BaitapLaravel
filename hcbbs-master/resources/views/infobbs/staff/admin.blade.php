{{-- カテゴリーレイアウトを継承 --}}
@extends('master._master_ja_blank')

{{-- CSSの定義 --}}
@section('css')
@parent
@stop

{{-- JSの定義 --}}
@section('js')
@parent
@stop

{{-- メイン部分の呼び出し --}}
@section('content')
@include('infobbs.attention')
<section class="c-section-container _both-space">
    <form action="{{ $urlAction }}" method="post">
        <h2 class="c-section-title">{{ $shopName }} 追加・並び順</h2>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        
        <div class="c-frame-box">
            <div class="c-frame-box__head">追加登録／一括編集（並び順・削除）</div>
            <div class="c-frame-box__body">
                <div class="c-separate">
                    <div class="c-separate__item">
                        <a class="c-entry-button _color-1" href="{{ $urlNewStaff }}">新規スタッフ追加</a>
                    </div>
                    <div class="c-separate__item">
                        <label class="c-entry-button _color-2"><input type="submit" value="一括編集（並び順・削除）">一括編集（並び順・削除）</label>
                    </div>
                </div>
                <p class="c-warning c-frame-box__warning">【注意】一度削除すると元に戻せません。</p>
            </div>
        </div>

        <div class="p-staff-list">
        <?php $num = 0; ?>
        @foreach($blogs as $num => $row)
            <?php
            $num++;
            ?>
            <input type="hidden" name="staff[{{ $num }}][number]" value="{{ $row->number }}">
            <div class="p-staff-card p-staff-list__item">
                <div class="p-staff-card__head">
                    <div class="p-staff-card__name">{{ $row->name }}</div>
                    <div class="p-staff-card__job">{{ $row->position }}</div>
                </div>
                <div class="p-staff-card__body">
                    <div class="p-staff-card__image">
                        <?php
                        // 旧システムから余計な文字列を削除
                        $row->photo = preg_replace('/,file_del$/', '', $row->photo);
                        ?>
                        @if (!empty($row->photo))
                        <img src="{{ asset_auto($row->photo) }}" alt="画像">
                        @else
                        <img src="{{ asset_auto('img/sozai/no_photo.jpg') }}" alt="画像">
                        @endif
                    </div>
                    <div class="c-control p-staff-card__control">
                        <div class="c-control__head">一括編集設定</div>
                        <div class="c-control__input">
                            <div class="c-control-edit _left">
                                <dl class="c-control-edit__item">
                                    <dt class="c-control-edit__head">並び順</dt>
                                    <dd class="c-control-edit__body">
                                        <label class="c-control-inline"><input type="number" name="staff[{{ $num }}][listing_order]" value="{{ $row->listing_order }}" maxlength="3">番目</label>
                                    </dd>
                                </dl>
                                <dl class="c-control-edit__item">
                                    <dt class="c-control-edit__head">プロフィール</dt>
                                    <dd class="c-control-edit__body">
                                        <p class="c-control-radio"><input type="radio" name="staff[{{ $num }}][disp]" value="disp" id="disp_{{ $num }}_ON"{{ $row->disp == 'disp' ? 'checked' : null }}>
                                            <label for="disp_{{ $num }}_ON">表示</label>
                                        </p>
                                        <p class="c-control-radio"><input type="radio" name="staff[{{ $num }}][disp]" value="nodisp" id="disp_{{ $num }}_OFF"{{ empty($row->disp) || $row->disp == 'nodisp' ? 'checked' : null }}>
                                            <label for="disp_{{ $num }}_OFF">非表示</label>
                                        </p>
                                    </dd>
                                </dl>
                                <dl class="c-control-edit__item">
                                    <dt class="c-control-edit__head">削除</dt>
                                    <dd class="c-control-edit__body">
                                        <p class="c-control-checkbox"><input type="checkbox" name="staff[{{ $num }}][del]" value="{{ $num }}" id="delete_{{ $num }}"><label for="delete_{{ $num }}"><em>削除する</em></label></p>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>

    </form>
</section>
@stop
