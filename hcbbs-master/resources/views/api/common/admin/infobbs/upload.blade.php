<?php
$textEditor = config('original.text_editor');
?>
{{-- カテゴリーレイアウトを継承 --}}
@extends('master._master_ja')

@include('api.common.admin.infobbs.editor_script')

{{-- メイン部分の呼び出し --}}
@section('content')
@include('api.common.admin.infobbs.attention')
<section class="c-section-container _both-space">
    <h2 class="c-section-title">{{ $shopName }} 新規投稿</h2>

    @if($errors->any())
        <p class="alert-danger" style="margin-bottom: 20px;">
            @foreach($errors->all() as $error)
                {{ $error }}<br/>
            @endforeach
        </p>
    @endif

    <div class="p-edit">
        <form id="form_id" name="upload" action="{{ $urlAction }}" enctype="multipart/form-data" method="post" class="p-edit-form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="shop" value="02">
            <div class="p-edit-section">

                <div class="p-edit-section__item">
                    <div class="p-edit-section__head">タイトル<small>（任意）</small></div>
                    <div class="p-edit-section__body">
                        <input class="c-control-input" type="text" name="title" size="50" value="{{ $data['title'] }}" placeholder="無題">
                    </div>
                </div>
                <?php 
                    if((isset($data['file1']) && !empty($data['file1'])) || 
                        (isset($data['file2']) && !empty($data['file2'])) || 
                        (isset($data['file3']) && !empty($data['file3'])) || 
                        (isset($data['file4']) && !empty($data['file4'])) || 
                        (isset($data['file5']) && !empty($data['file5'])) || 
                        (isset($data['file6']) && !empty($data['file6']))){
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
                                @if (!empty($data['file1']))
                                    <?php
                                    // ファイルパスの情報を取得する
                                    $fileinfo1 = pathinfo( $data['file1'] );
                                    ?>
                                    {{-- PDFファイルの対応 --}}
                                    @if( strtolower( $fileinfo1['extension'] ) === "pdf" )
                                        <a href="{{ asset_auto($data['file1']) }}" target="_blank">
                                            <img src="{{ $CodeUtil::getPdfThumbnail( $data['file1'] ) }}" width="200" alt="{{ $data['caption1'] }}">
                                        </a>
                                    @else
                                        <img src="{{ asset_auto($data['file1']) }}" alt="{{ $data['caption1'] }}">
                                    @endif
                                @endif
                            </div>
                            <div class="c-control-upload__box">
                                <div class="c-control-upload__block">
                                    <p>写真の変更</p>
                                    <input class="c-control-file" type="file" name="file1" accept="image/*,.pdf">
                                </div>
                                <div class="c-control-upload__block">
                                    <p>コメント</p>
                                    <input class="c-control-input" type="text" name="caption1" value="{{ $data['caption1'] ?? '' }}">
                                </div>
                                <div class="c-control-upload__delete">
                                    <p class="c-control-checkbox">
                                        <input type="checkbox" name="file1_del" value="del" id="fileDelete_1">
                                        <label for="fileDelete_1">この画像を削除する</label>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="c-control-upload">
                            <div class="c-control-upload__image">
                                @if (!empty($data['file2']))
                                    <?php
                                    // ファイルパスの情報を取得する
                                    $fileinfo2 = pathinfo( $data['file2'] );
                                    ?>
                                    {{-- PDFファイルの対応 --}}
                                    @if( strtolower( $fileinfo2['extension'] ) === "pdf" )
                                        <a href="{{ asset_auto($data['file2']) }}" target="_blank">
                                            <img src="{{ $CodeUtil::getPdfThumbnail( $data['file2'] ) }}" width="200" alt="{{ $data['caption2'] }}">
                                        </a>
                                    @else
                                        <img src="{{ asset_auto($data['file2']) }}" alt="{{ $data['caption2'] }}">
                                    @endif
                                @endif
                            </div>
                            <div class="c-control-upload__box">
                                <div class="c-control-upload__block">
                                    <p>写真の変更</p>
                                    <input class="c-control-file" type="file" name="file2" accept="image/*,.pdf">
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
                                    <?php
                                    // ファイルパスの情報を取得する
                                    $fileinfo3 = pathinfo( $data['file3'] );
                                    ?>
                                    {{-- PDFファイルの対応 --}}
                                    @if( strtolower( $fileinfo3['extension'] ) === "pdf" )
                                        <a href="{{ asset_auto($data['file3']) }}" target="_blank">
                                            <img src="{{ $CodeUtil::getPdfThumbnail( $data['file3'] ) }}" width="200" alt="{{ $data['caption3'] }}">
                                        </a>
                                    @else
                                        <img src="{{ asset_auto($data['file3']) }}" alt="{{ $data['caption3'] }}">
                                    @endif
                                @endif
                            </div>
                            <div class="c-control-upload__box">
                                <div class="c-control-upload__block">
                                    <p>写真の変更</p>
                                    <input class="c-control-file" type="file" name="file3" accept="image/*,.pdf">
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

                        @if (array_key_exists('file4', $data))
                        <!-- 東京中央のみ６枚 -->
                        <div class="c-control-upload">
                            <div class="c-control-upload__image">
                                @if (!empty($data['file4']))
                                    <?php
                                    // ファイルパスの情報を取得する
                                    $fileinfo4 = pathinfo( $data['file4'] );
                                    ?>
                                    {{-- PDFファイルの対応 --}}
                                    @if( strtolower( $fileinfo4['extension'] ) === "pdf" )
                                        <a href="{{ asset_auto($data['file4']) }}" target="_blank">
                                            <img src="{{ $CodeUtil::getPdfThumbnail( $data['file4'] ) }}" width="200" alt="{{ $data['caption4'] }}">
                                        </a>
                                    @else
                                        <img src="{{ asset_auto($data['file4']) }}" alt="{{ $data['caption4'] }}">
                                    @endif
                                @endif
                            </div>
                            <div class="c-control-upload__box">
                                <div class="c-control-upload__block">
                                    <p>写真の変更</p>
                                    <input class="c-control-file" type="file" name="file4" accept="image/*,.pdf">
                                </div>
                                <div class="c-control-upload__block">
                                    <p>コメント</p>
                                    <input class="c-control-input" type="text" name="caption4" value="{{ $data['caption4'] ?? '' }}">
                                </div>
                                <div class="c-control-upload__delete">
                                    <p class="c-control-checkbox">
                                        <input type="checkbox" name="file4_del" value="del" id="fileDelete_4">
                                        <label for="fileDelete_4">この画像を削除する</label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if (array_key_exists('file5', $data))
                        <div class="c-control-upload">
                            <div class="c-control-upload__image">
                                @if (!empty($data['file5']))
                                    <?php
                                    // ファイルパスの情報を取得する
                                    $fileinfo5 = pathinfo( $data['file5'] );
                                    ?>
                                    {{-- PDFファイルの対応 --}}
                                    @if( strtolower( $fileinfo5['extension'] ) === "pdf" )
                                        <a href="{{ asset_auto($data['file5']) }}" target="_blank">
                                            <img src="{{ $CodeUtil::getPdfThumbnail( $data['file5'] ) }}" width="200" alt="{{ $data['caption5'] }}">
                                        </a>
                                    @else
                                        <img src="{{ asset_auto($data['file5']) }}" alt="{{ $data['caption5'] }}">
                                    @endif
                                @endif
                            </div>
                            <div class="c-control-upload__box">
                                <div class="c-control-upload__block">
                                    <p>写真の変更</p>
                                    <input class="c-control-file" type="file" name="file5" accept="image/*,.pdf">
                                </div>
                                <div class="c-control-upload__block">
                                    <p>コメント</p>
                                    <input class="c-control-input" type="text" name="caption5" value="{{ $data['caption5'] ?? '' }}">
                                </div>
                                <div class="c-control-upload__delete">
                                    <p class="c-control-checkbox">
                                        <input type="checkbox" name="file5_del" value="del" id="fileDelete_5">
                                        <label for="fileDelete_5">この画像を削除する</label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if (array_key_exists('file6', $data))
                        <div class="c-control-upload">
                            <div class="c-control-upload__image">
                                @if (!empty($data['file6']))
                                    <?php
                                    // ファイルパスの情報を取得する
                                    $fileinfo6 = pathinfo( $data['file6'] );
                                    ?>
                                    {{-- PDFファイルの対応 --}}
                                    @if( strtolower( $fileinfo6['extension'] ) === "pdf" )
                                        <a href="{{ asset_auto($data['file6']) }}" target="_blank">
                                            <img src="{{ $CodeUtil::getPdfThumbnail( $data['file6'] ) }}" width="200" alt="{{ $data['caption6'] }}">
                                        </a>
                                    @else
                                        <img src="{{ asset_auto($data['file6']) }}" alt="{{ $data['caption6'] }}">
                                    @endif
                                @endif
                            </div>
                            <div class="c-control-upload__box">
                                <div class="c-control-upload__block">
                                    <p>写真の変更</p>
                                    <input class="c-control-file" type="file" name="file6" accept="image/*,.pdf">
                                </div>
                                <div class="c-control-upload__block">
                                    <p>コメント</p>
                                    <input class="c-control-input" type="text" name="caption6" value="{{ $data['caption6'] ?? '' }}">
                                </div>
                                <div class="c-control-upload__delete">
                                    <p class="c-control-checkbox">
                                        <input type="checkbox" name="file6_del" value="del" id="fileDelete_6">
                                        <label for="fileDelete_6">この画像を削除する</label>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- 東京中央のみ６枚 ここまで -->
                        @endif

                    </div>
                </div>

                <div class="p-edit-section__item" <?php echo $filefree_disp;?> id="filefree">
                    <div class="p-edit-section__head">画像を投稿する<br>（本文内）<br><a href="javascript:void(0);" onClick="filesel3_disp();" style="font-size:12px;">定形位置投稿を使用する</a></div>
                    <div class="p-edit-section__body">

                        <!-- <ul class="p-edit-section__notes">
                            <li><em>※注意・ファイル名に日本語（半角カナ・全角文字）は使えません！</em></li>
                            <li>※半角英数字のファイル名を使用して下さい。</li>
                        </ul> -->
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
                        <?php
                        // 記事が改行が必要かの判定
                        $hasNoBr = !preg_match('/<(?:br|p)\s*?\/?>/', $data['comment']);
                        
                        if ($hasNoBr) {
                            $data['comment'] = nl2br( $data['comment'] );
                        }
                        ?>
                        <textarea name="comment" id="text-editor" style="width:800px;height:300px;">{!! $data['comment'] !!}</textarea>
                        <!-- ブログ本文部分 ここまで -->
                        <p style="margin-top:10px;">
                            <a hred="javascript:void(0);" onClick="wysReload();" style="cursor: pointer;">
                                <img src="{{ asset_auto('img/btn_up.png') }}" style="max-width: 100%;" alt="一括アップロードした画像がうまく表示されない場合、こちらをクリックしてください。">
                            </a>
                        </p>

                    </div>
                </div>

                <div class="p-edit-section__item">
                    <div class="p-edit-section__head">店舗名</div>
                    <div class="p-edit-section__body">{{ $shopName }}<input type="hidden" name="shop" value="{{ $data['shop'] }}"></div>
                </div>
                
                <div class="p-edit-section__item">
                    <div class="p-edit-section__head">
                        {!! '掲載期間' . (!isset($hanshaCode) || $hanshaCode !== '8153883' ? '<small>（任意）</small>' : '') !!}
                    </div>
                    <div class="p-edit-section__body">
                        <ul class="p-edit-section__notes">
                            <li>※無記入の場合、掲載日：即時公開／終了日：永続的に掲載</li>
                        </ul>
                        <dl class="p-edit-date">
                            <dt class="p-edit-date__head">掲載日<span>（0時～）</span></dt>
                            <dd class="p-edit-date__body">
                                <input class="c-control-input datetimepicker" name="from_date" autocomplete="off" style="width: 100px;" value="{{ $data['from_date'] }}">
                            </dd>
                        </dl>
                        <dl class="p-edit-date">
                            <dt class="p-edit-date__head">終了日<span>（～24時）</span></dt>
                            <dd class="p-edit-date__body">
                                <input class="c-control-input datetimepicker" name="to_date" autocomplete="off" style="width: 100px;" value="{{ $data['to_date'] }}">
                            </dd>
                        </dl>
                        <ul class="p-edit-section__notes">
                            <li>※開始日、終了日のみの入力も可能です。</li>
                        </ul>
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
    <!-- /.p-entrylist -->
</section>
@stop
