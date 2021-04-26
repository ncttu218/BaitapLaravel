<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Honda Cars 愛知 | 拠点ページレイアウト変更ツール</title>
  <?php
  $now = date("YmdHis");
  ?>
<link rel="stylesheet" href="{{ asset_auto('css') }}/style-aichi.css?<?php echo $now;?>" type="text/css" />
</head>
<body>

<form action="{{ $urlConfirmDesign ?? '' }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="shop" value="{{ $shopCode ?? '' }}" />
    <h2><?php echo $shopName ?? ''; ?> 背景デザインおよび写真フレームの選択</h2>
    <div class="layout-pattern">
        <h3>背景デザインを選択</h3>
        @isset($design['layout'])
        <ul>
            <li><label><input type="radio" name="design[layout]" value="1" <?php if($design['layout'] == '1'){echo 'checked';}?>>プレーン</label></li>
            <li><label><input type="radio" name="design[layout]" value="2" <?php if($design['layout'] == '2'){echo 'checked';}?>>コルク</label></li>
            <li><label><input type="radio" name="design[layout]" value="3" <?php if($design['layout'] == '3'){echo 'checked';}?>>クール</label></li>
            <li><label><input type="radio" name="design[layout]" value="4" <?php if($design['layout'] == '4'){echo 'checked';}?>>シーズン</label></li>
        </ul>
        @endisset
        <h3>写真フレームを選択</h3>
        @isset($design['pattern'])
        <ul>
            <li><label><input type="radio" name="design[pattern]" value="1" <?php if($design['pattern'] == '1'){echo 'checked';}?>>プレーン</label></li>
            <li><label><input type="radio" name="design[pattern]" value="2" <?php if($design['pattern'] == '2'){echo 'checked';}?>>ピンナップ</label></li>
            <li><label><input type="radio" name="design[pattern]" value="3" <?php if($design['pattern'] == '3'){echo 'checked';}?>>クール</label></li>
            <li><label><input type="radio" name="design[pattern]" value="4" <?php if($design['pattern'] == '4'){echo 'checked';}?>>ポップ</label></li>
        </ul>
        @endisset
    </div>
    
    <h2>画像の選択・コメントの登録</h2>
    <div class="layout-pattern">
    <table width="100%">
        <tr>
            <td valign="top" colspan="2">
                <h3>メイン画像</h3>
                <h4>現在の画像</h4>
                <input type="hidden" name="design[main_photo]" value="{{ $design['main_photo'] }}" />
                <div class="photo">
                    <img src="<?php echo $design['main_photo_url'] ?? ''; ?>" class="main_photo">
                </div>
                <p>画像を変更する場合<br><input type="file" name="design_main_photo"></p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="50%">
                <h3>画像１枚目</h3>
                <h4>現在の画像</h4>
                @isset($staff[1])
                <div class="photo">
                    <input type="hidden" name="staff[1][photo2]" value="{{ $staff[1]['photo2'] }}" />
                    <img src="<?php echo $staff[1]['photo2_url']; ?>" class="shop_photo">
                </div>
                <p>画像を変更する場合<br><input type="file" name="staff_header1"></p>
            
                <h4>コメント</h4>
                <p><textarea maxlength="102" name="staff[1][comment]" class="comment"><?php echo $staff[1]['comment'];?></textarea></p>
            
                <h4>スタッフ</h4>
                <p>
                    <div class="staff_photo">
                        <input type="hidden" name="staff[1][photo]" value="{{ $staff[1]['photo'] }}" />
                        <img src="<?php echo $staff[1]['photo_url'];?>" class="staff_photo">
                        <input type="checkbox" name="staff_photo1_delete" value="del">削除
                        <br>
                        画像を変更する場合<br>
                        <input type="file" name="staff_pic1">
                    </div>
                    <div class="staff_data">
                        氏名：<input type="text" maxlegth="8" name="staff[1][name]" value="<?php echo $staff[1]['name'];?>" class="staff_text"><br>
                        肩書：<input type="text" maxlength="12" name="staff[1][department]" value="<?php echo $staff[1]['department'];?>" class="staff_text">
                    </div>
                <p>
                @endisset
            </td>
            <td valign="top" width="50%">
                <h3>画像２枚目</h3>
                <h4>現在の画像</h4>
                @isset($staff[2])
                <div class="photo">
                    <input type="hidden" name="staff[2][photo2]" value="{{ $staff[2]['photo2'] }}" />
                    <img src="<?php echo $staff[2]['photo2_url'];?>" class="shop_photo">
                </div>
                <p>画像を変更する場合<br><input type="file" name="staff_header2"></p>
            
                <h4>コメント</h4>
                <p><textarea maxlength="102" name="staff[2][comment]" class="comment"><?php echo $staff[2]['comment'];?></textarea></p>
            
                <h4>スタッフ</h4>
                <p>
                    <div class="staff_photo">
                        <input type="hidden" name="staff[2][photo]" value="{{ $staff[2]['photo'] }}" />
                        <img src="<?php echo $staff[2]['photo_url'];?>" class="staff_photo">
                        <input type="checkbox" name="staff_photo2_delete" value="del">削除
                        <br>
                        画像を変更する場合<br>
                        <input type="file" name="staff_pic2">
                    </div>
                    <div class="staff_data">
                        氏名：<input type="text" maxlegth="8" name="staff[2][name]" value="<?php echo $staff[2]['name'];?>" class="staff_text"><br>
                        肩書：<input type="text" maxlength="12" name="staff[2][department]" value="<?php echo $staff[2]['department'];?>" class="staff_text">
                    </div>
                <p>
                @endisset
            </td>
        </tr>
        <tr>
            <td valign="top">
                <h3>画像３枚目</h3>
                <h4>現在の画像</h4>
                @isset($staff[3])
                <div class="photo">
                    <input type="hidden" name="staff[3][photo2]" value="{{ $staff[3]['photo2'] }}" />
                    <img src="<?php echo $staff[3]['photo2_url'];?>" class="shop_photo">
                </div>
                <p>画像を変更する場合<br><input type="file" name="staff_header3"></p>
            
                <h4>コメント</h4>
                <p><textarea maxlength="102" name="staff[3][comment]" class="comment"><?php echo $staff[3]['comment'];?></textarea></p>
            
                <h4>スタッフ</h4>
                <p>
                    <div class="staff_photo">
                        <input type="hidden" name="staff[3][photo]" value="{{ $staff[3]['photo'] }}" />
                        <img src="<?php echo $staff[3]['photo_url'];?>" class="staff_photo">
                        <input type="checkbox" name="staff_photo3_delete" value="del">削除
                        <br>
                        画像を変更する場合<br>
                        <input type="file" name="staff_pic3">
                    </div>
                    <div class="staff_data">
                        氏名：<input type="text" maxlegth="8" name="staff[3][name]" value="<?php echo $staff[3]['name'];?>" class="staff_text"><br>
                        肩書：<input type="text" maxlength="12" name="staff[3][department]" value="<?php echo $staff[3]['department'];?>" class="staff_text">
                    </div>
                <p>
                @endisset
            </td>
            <td valign="top">
                <h3>画像４枚目</h3>
                <h4>現在の画像</h4>
                @isset($staff[4])
                <div class="photo">
                    <input type="hidden" name="staff[4][photo2]" value="{{ $staff[4]['photo2'] }}" />
                    <img src="<?php echo $staff[4]['photo2_url'];?>" class="shop_photo">
                </div>
                <p>画像を変更する場合<br><input type="file" name="staff_header4"></p>
            
                <h4>コメント</h4>
                <p><textarea maxlength="102" name="staff[4][comment]" class="comment"><?php echo $staff[4]['comment'];?></textarea></p>
            
                <h4>スタッフ</h4>
                <p>
                    <div class="staff_photo">
                        <input type="hidden" name="staff[4][photo]" value="{{ $staff[4]['photo'] }}" />
                        <img src="<?php echo $staff[4]['photo_url'];?>" class="staff_photo">
                        <input type="checkbox" name="staff_photo4_delete" value="del">削除
                        <br>
                        画像を変更する場合<br>
                        <input type="file" name="staff_pic4">
                    </div>
                    <div class="staff_data">
                        氏名：<input type="text" maxlegth="8" name="staff[4][name]" value="<?php echo $staff[4]['name'];?>" class="staff_text"><br>
                        肩書：<input type="text" maxlength="12" name="staff[4][department]" value="<?php echo $staff[4]['department'];?>" class="staff_text">
                    </div>
                <p>
                @endisset
            </td>
        </tr>
        </table>
    </div>
    <!--h2>編集パスワードの設定</h2>
    ※変更する場合こちらに入力してください<br>
    <input type="text" name="edit_pwd" value="<?php echo $staff['edit_pwd'] ?? ''; ?>" -->
    
    <div class="submit">
    <input type="submit" value="入力内容の確認" class="Btn">
    </div>
    
    
    </form>
    <div id="footer">
    </div>
    </body>
    </html>
    