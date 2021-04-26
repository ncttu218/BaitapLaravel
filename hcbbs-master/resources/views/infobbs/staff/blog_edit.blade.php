<?php
$textEditor = config('original.text_editor');
?>
{{-- カテゴリーレイアウトを継承 --}}
@extends('master._master_ja')

@include('infobbs.editor_script')

{{-- メイン部分の呼び出し --}}
@section('content')
@include('infobbs.attention')
<section class="c-section-container _both-space">
    <h2 class="c-section-title">{{ isset($shopName) && !empty($shopName) ? "【{$shopName}】" : '' }} {{ $staffName ?? '' }} 新規投稿</h2>

    <div class="p-edit">
        <form id="form_id" name="upload" action="{{ $urlAction }}" enctype="multipart/form-data" method="post" class="p-edit-form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="shop" value="{{ $data['shop'] }}">
            <div class="p-edit-section">

                <div class="p-edit-section__item">
                    <div class="p-edit-section__head">タイトル</div>
                    <div class="p-edit-section__body">
                        <input class="c-control-input" type="text" name="title" size="50" value="{{ $data['title'] }}" placeholder="無題">
                    </div>
                </div>
                <?php 
                    if((isset($data['file']) && !empty($data['file'])) || 
                        (isset($data['file2']) && !empty($data['file2'])) || 
                        (isset($data['file3']) && !empty($data['file3']))){
                        $filesel3_disp = '';
                        $filefree_disp = 'style="display:none;"'; 
                    }else{
                        $filesel3_disp = 'style="display:none;"';
                        $filefree_disp = ''; 
                    }
                ?> 

                <div class="p-edit-section__item" <?php echo $filesel3_disp;?> id="filesel3">
                    <div class="p-edit-section__head">画像を投稿する<br><a href="javascript:void(0);" onClick="filefree_disp();" style="font-size:12px;">本文内投稿を使用する</a></div>
                    <div class="p-edit-section__body">

                        <ul class="p-edit-section__notes">
                            <li><em>※注意・ファイル名に日本語（半角カナ・全角文字）は使えません！</em></li>
                            <li>※半角英数字のファイル名を使用して下さい。</li>
                        </ul>

                        <dl class="p-edit-date">
                            <dt class="p-edit-date__head">写真の位置</dt>
                            <dd class="p-edit-date__body">
                                <div class="c-control-select">
                                    <select name="pos" size="1" >
                                        <option value="3" <?php if($data['pos'] == '3'){echo 'selected';}?>>下側(横並び)</option>
                                        <option value="2" <?php if($data['pos'] == '2'){echo 'selected';}?>>上側(横並び)</option>
                                        <option value="0" <?php if($data['pos'] == '0'){echo 'selected';}?>>右側(縦並び)</option>
                                        <option value="1" <?php if($data['pos'] == '1'){echo 'selected';}?>>左側(縦並び)</option>
                                    </select>
                                </div>
                            </dd>
                        </dl>

                        <!-- 画像アップロード 3個並び方式 -->
                        <div class="c-control-upload">
                            <div class="c-control-upload__image">
                                @if (!empty($data['file']))
                                    <img src="{{ asset_auto($data['file']) }}" alt="{{ $data['caption'] }}">
                                @endif
                            </div>
                            <div class="c-control-upload__box">
                                <div class="c-control-upload__block">
                                    <p>写真の変更</p>
                                    <input class="c-control-file" type="file" name="file" accept="image/*">
                                </div>
                                <div class="c-control-upload__block">
                                    <p>コメント</p>
                                    <input class="c-control-input" type="text" name="caption" value="{{ $data['caption'] ?? '' }}">
                                </div>
                                <div class="c-control-upload__delete">
                                    <p class="c-control-checkbox">
                                        <input type="checkbox" name="file_del" value="del" id="fileDelete_1">
                                        <label for="fileDelete_1">この画像を削除する</label>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="c-control-upload">
                            <div class="c-control-upload__image">
                                @if (!empty($data['file2']))
                                    <img src="{{ asset_auto($data['file2']) }}" alt="{{ $data['caption2'] }}">
                                @endif
                            </div>
                            <div class="c-control-upload__box">
                                <div class="c-control-upload__block">
                                    <p>写真の変更</p>
                                    <input class="c-control-file" type="file" name="file2" accept="image/*">
                                </div>
                                <div class="c-control-upload__block">
                                    <p>コメント</p>
                                    <input class="c-control-input" type="text" name="caption2" value="{{ $data['caption2'] ?? '' }}">
                                </div>
                                <div class="c-control-upload__delete">
                                    <p class="c-control-checkbox">
                                        <input type="checkbox" name="file2_del" value="del" id="fileDelete_2">
                                        <label for="fileDelete_2">この画像を削除する</label>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="c-control-upload">
                            <div class="c-control-upload__image">
                                @if (!empty($data['file3']))
                                    <img src="{{ asset_auto($data['file3']) }}" alt="{{ $data['caption3'] }}">
                                @endif
                            </div>
                            <div class="c-control-upload__box">
                                <div class="c-control-upload__block">
                                    <p>写真の変更</p>
                                    <input class="c-control-file" type="file" name="file3" accept="image/*">
                                </div>
                                <div class="c-control-upload__block">
                                    <p>コメント</p>
                                    <input class="c-control-input" type="text" name="caption3" value="{{ $data['caption3'] ?? '' }}">
                                </div>
                                <div class="c-control-upload__delete">
                                    <p class="c-control-checkbox">
                                        <input type="checkbox" name="file3_del" value="del" id="fileDelete_3">
                                        <label for="fileDelete_3">この画像を削除する</label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- 画像アップロード部分 ここまで -->

                    </div>
                </div>

                <div class="p-edit-section__item" <?php echo $filefree_disp;?> id="filefree">
                    <div class="p-edit-section__head">画像を投稿する<br>（本文内）<br><a href="javascript:void(0);" onClick="filesel3_disp();" style="font-size:12px;">定形位置投稿を使用する</a></div>
                    <div class="p-edit-section__body">

                        <ul class="p-edit-section__notes">
                            <li><em>※注意・ファイル名に日本語（半角カナ・全角文字）は使えません！</em></li>
                            <li>※半角英数字のファイル名を使用して下さい。</li>
                        </ul>
                        <!-- 画像アップロード部分 ＝実装いただいたらあとでcss当てます＝ -->
                        <div id="my-awesome-dropzone" class="dropzone" style="height:350px;overflow:scroll;"></div>
                        <div id="upload_msg"></div>
                        <!-- 画像アップロード部分 ここまで -->

                    </div>
                </div>

                <div class="p-edit-section__item">
                    <div class="p-edit-section__head">内容</div>
                    <div class="p-edit-section__body">

                        <!-- ブログ本文部分 ＝実装いただいたらあとでcss当てます＝ -->
                        <textarea name="comment" id="text-editor" style="width:800px;height:300px;">{!! $data['comment'] !!}</textarea>
                        <!-- ブログ本文部分 ここまで -->
                        <p style="margin-top:10px;">
                            <a hred="javascript:void(0);" onClick="wysReload();" style="cursor: pointer;">
                                <img src="{{ asset_auto('img/btn_up.png') }}" alt="一括アップロードした画像がうまく表示されない場合、こちらをクリックしてください。">
                            </a>
                        </p>

                    </div>
                </div>

            </div>
            <!-- /.p-edit-section -->

            <div class="p-edit-send">
                <div class="p-edit-send__checkbox">
                    <p class="c-control-checkbox"><input type="checkbox" name="comp_check" value="OK" id="comp_check" onclick="valSet(this.value)">
                        <label for="comp_check"><span class="required-icon">※</span>情報掲載内容について、利用規約違反はありません。</label>
                    </p>
                </div>
                <p class="p-edit-send__rule"><a href="{{ action_auto('Infobbs\InfobbsController@getRule') }}" target="_blank">利用規約全文を見る</a></p>
                <div class="p-edit-send__button">
                    <label class="c-entry-button _color-1"><input type="submit" value="投稿内容を確認する">投稿内容を確認する</label>
                </div>
            </div>
            <!-- /.p-edit-send -->

        </form>
    </div>

    <p class="c-simple-button-container" style="margin-top: 2em;">
        <a href="{{ action_auto("Infobbs\StaffbbsController" . '@getBlogList') .'?'. $data['shop'] }}" class="c-simple-button">記事の編集・削除画面へ戻る</a>
    </p>
    <!-- /.p-entrylist -->
</section>
@stop
