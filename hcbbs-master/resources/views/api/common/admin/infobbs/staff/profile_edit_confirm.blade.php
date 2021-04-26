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
@include('api.common.admin.infobbs.attention')

<section class="c-section-container _both-space">
    <h2 class="c-section-title">投稿内容の確認</h2>
    <!-- p style="background:#fff; text-align:center; padding:30px">ブログの内容</p -->
    <div class="p-staff-card p-staff-list__item">
        <div class="p-staff-card__head">
            <div class="p-staff-card__name">{{ $data['name'] }}{{ $data['name_furi'] }}</div>
            <div class="p-staff-card__job">{{ $data['position'] }}</div>
        </div>
        <div class="p-staff-card__body">
            <div class="p-staff-card__image">
                @if (!empty($data['photo']))
                <img src="{{ asset_auto($data['photo']) }}" alt="画像">
                @endif
            </div>
            <div class="c-control p-staff-card__control">
                <div class="c-control__head">{{ $data['msg'] }}</div>
                <div class="c-control__input">
                    <div class="c-control-edit _left">
                        <dl class="c-control-edit__item">
                            <dt class="c-control-edit__head">資格</dt>
                            <dd class="c-control-edit__body">
                                <label class="c-control-inline">{{ $data['lisence'] }}</label>
                            </dd>
                        </dl>
                        <dl class="c-control-edit__item">
                            <dt class="c-control-edit__head">趣味</dt>
                            <dd class="c-control-edit__body">
                                <label class="c-control-inline">{{ $data['hobby'] }}</label>
                            </dd>
                        </dl>
                        <?php if (isset($data['ext_field1'])) { ?>
                            <dl class="c-control-edit__item">
                                <dt class="c-control-edit__head">{{ $data['ext_field1'] }}</dt>
                                <dd class="c-control-edit__body">
                                    <label class="c-control-inline">{{ $data['ext_value1'] }}</label>
                                </dd>
                            </dl>
                        <?php } ?>
                        <?php if (isset($data['ext_field2'])) { ?>
                            <dl class="c-control-edit__item">
                                <dt class="c-control-edit__head">{{ $data['ext_field2'] }}</dt>
                                <dd class="c-control-edit__body">
                                    <label class="c-control-inline">{{ $data['ext_value2'] }}</label>
                                </dd>
                            </dl>
                        <?php } ?>
                        <?php if (isset($data['ext_field3'])) { ?>
                            <dl class="c-control-edit__item">
                                <dt class="c-control-edit__head">{{ $data['ext_field3'] }}</dt>
                                <dd class="c-control-edit__body">
                                    <label class="c-control-inline">{{ $data['ext_value3'] }}</label>
                                </dd>
                            </dl>
                        <?php } ?>
                        <?php if (isset($data['ext_field4'])) { ?>
                            <dl class="c-control-edit__item">
                                <dt class="c-control-edit__head">{{ $data['ext_field4'] }}</dt>
                                <dd class="c-control-edit__body">
                                    <label class="c-control-inline">{{ $data['ext_value4'] }}</label>
                                </dd>
                            </dl>
                        <?php } ?>
                        <?php if (isset($data['ext_field5'])) { ?>
                            <dl class="c-control-edit__item">
                                <dt class="c-control-edit__head">{{ $data['ext_field5'] }}</dt>
                                <dd class="c-control-edit__body">
                                    <label class="c-control-inline">{{ $data['ext_value5'] }}</label>
                                </dd>
                            </dl>
                        <?php } ?>
                        <dl class="c-control-edit__item">
                            <dt class="c-control-edit__head">パスワード</dt>
                            <dd class="c-control-edit__body">
                                <label class="c-control-inline">{{ $data['editpass'] }}</label>
                            </dd>
                        </dl>
                        <dl class="c-control-edit__item">
                            <dt class="c-control-edit__head">一覧への掲載</dt>
                            <dd class="c-control-edit__body">
                                <label class="c-control-inline">
                                    @if ($data['disp'] != '')
                                    {{ $data['disp'] == 'ON' ? '公開' : '非公開' }}
                                    @endif
                                </label>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="c-section-container _bottom-space">
    <div class="c-frame-box">
        <div class="c-frame-box__head">
            @if($data['continue'] == 'ng')
                <span>未入力項目があります</span>
            @else
                <span>このデータを登録します。よろしいですか？</span>
            @endif
        </div>
        <div class="c-frame-box__body">
            <div class="c-separate">
                <div class="c-separate__item">
                    <form action="" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label class="c-entry-button _color-2"><input type="submit" name="modulate" value="修正する">修正する</label>
                    </form>
                </div>
                @if($data['continue'] != 'ng')
                <div class="c-separate__item">
                    <form action="" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label class="c-entry-button _color-1"><input type="submit" name="register" value="登録する">登録する</label>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- / .c-section-container -->
@stop
