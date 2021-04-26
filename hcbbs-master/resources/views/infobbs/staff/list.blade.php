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
    <h2 class="c-section-title">{{ $shopName }} スタッフ一覧</h2>
    
    <div class="p-staff-list">
        <?php $num = 0; ?>
        @foreach($blogs as $num => $row)
        <?php
        $num++;
        ?>
        <div class="p-staff-card p-staff-list__item">
            <form action="" method="POST" autocomplete="off">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="shop" value="{{ $shopCode }}">
                <div class="p-staff-card__head">
                    <a class="p-staff-card__name" href="#" target="_blank">
                        {{ $row->name }}
                        @if (!empty($row->name_furi))
                            （{{ $row->name_furi }}）
                        @endif
                    </a>
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
                    <p class="p-staff-card__date">{{ date('Y/m/d', strtotime($row->updated_at)) }} 更新</p>
                    <div class="c-control p-staff-card__control">
                        <div class="c-control__input">
                            <dl class="c-control-edit _password">
                                <dt class="c-control-edit__head">編集用パスワード</dt>
                                <dd class="c-control-edit__body">
                                    <input class="c-control-password" type="password" name="editpass" autocomplete="off">
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="p-staff-card__button">
                        <label class="c-entry-button _color-1"><input type="submit" name="number" value="{{ $row->number }}">このデータを編集する</label>
                    </div>
                </div>
            </form>
        </div>
        @endforeach
    </div>
</section>
@stop
