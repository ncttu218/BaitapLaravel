<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Honda Cars 愛知 | 拠点ページレイアウト変更ツール</title>
  <link rel="stylesheet" href="{{ asset_auto('css/image-frame.css') }}" type="text/css" />
</head>
<body>
<form action="sr_preview.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="kcd" value="01">
<input type="hidden" name="main_photo" value="//cgi3-aws.hondanet.co.jp/cgi/2153801/photo/draft_main_photo_01.gif">
<input type="hidden" name="shop_photo1" value="//cgi3-aws.hondanet.co.jp/cgi/2153801/photo/draft_shop_photo1_01.jpg">
<input type="hidden" name="shop_photo2" value="//cgi3-aws.hondanet.co.jp/cgi/2153801/photo/draft_shop_photo2_01.gif">
<input type="hidden" name="shop_photo3" value="//cgi3-aws.hondanet.co.jp/cgi/2153801/photo/draft_shop_photo3_01.jpg">
<input type="hidden" name="shop_photo4" value="//cgi3-aws.hondanet.co.jp/cgi/2153801/photo/draft_shop_photo4_01.jpg">
<input type="hidden" name="staff_photo1" value="">
<input type="hidden" name="staff_photo2" value="//cgi3-aws.hondanet.co.jp/cgi/2153801/photo/draft_staff_photo2_01.jpg">
<input type="hidden" name="staff_photo3" value="">
<input type="hidden" name="staff_photo4" value="//cgi3-aws.hondanet.co.jp/cgi/2153801/photo/draft_staff_photo4_01.jpg">

<h2>一宮中央店 背景デザインおよび写真フレームの選択</h2>
<div class="layout-pattern">
	<h3>背景デザインを選択</h3>
	<ul>
        @foreach ($codes['backgroundDesign'] as $key => $label)
            <li>
                <label>
                    <input type="radio" name="layout" value="{{ $key }}" >{{ $label }}
                </label>
            </li>
        @endforeach
    </ul>
	<h3>写真フレームを選択</h3>
	<ul>
        @foreach ($codes['imageFrame'] as $key => $label)
            <li>
                <label>
                    <input type="radio" name="pattern" value="{{ $key }}" >{{ $label }}
                </label>
            </li>
        @endforeach
    </ul>
</div>

<h2>画像の選択・コメントの登録</h2>
<div class="layout-pattern">
<table width="100%">
	<tr>
		<td valign="top" colspan="2">
			<h3>メイン画像</h3>
			<h4>現在の画像</h4>
			<div class="photo"><img src="//cgi3-aws.hondanet.co.jp/cgi/2153801/photo/draft_main_photo_01.gif" class="main_photo"></div>
			<p>画像を変更する場合<br><input type="file" name="main_photo"></p>
		</td>
	</tr>
	<tr>
		<td valign="top" width="50%">
			<h3>画像１枚目</h3>
			<h4>現在の画像</h4>
			<div class="photo">
				<img src="//cgi3-aws.hondanet.co.jp/cgi/2153801/photo/draft_shop_photo1_01.jpg" class="shop_photo">
			</div>
			<p>画像を変更する場合<br><input type="file" name="shop_photo1"></p>
		
			<h4>コメント</h4>
			<p><textarea maxlength="102" name="shop_comment1" class="comment">店内改装を行い
よりお客様に親しみやすいお店を
スタッフ一同目指して参ります!!</textarea></p>
		
			<h4>スタッフ</h4>
			<p>
				<div class="staff_photo">
					<img src="" class="staff_photo">
					<input type="checkbox" name="staff_photo1_delete" value="del">削除
					<br>
					画像を変更する場合<br>
					<input type="file" name="staff_photo1">
				</div>
				<div class="staff_data">
					氏名：<input type="text" maxlegth="8" name="staff_name1" value="" class="staff_text"><br>
					肩書：<input type="text" maxlength="12" name="staff_position1" value="" class="staff_text">
				</div>
			<p>
		</td>
		<td valign="top" width="50%">
			<h3>画像２枚目</h3>
			<h4>現在の画像</h4>
			<div class="photo">
				<img src="//cgi3-aws.hondanet.co.jp/cgi/2153801/photo/draft_shop_photo2_01.gif" class="shop_photo">
			</div>
			<p>画像を変更する場合<br><input type="file" name="shop_photo2"></p>
		
			<h4>コメント</h4>
			<p><textarea maxlength="102" name="shop_comment2" class="comment">店内でお待ちの間に
お飲み物はフリードリンクで
雑誌も豊富に揃えております!</textarea></p>
		
			<h4>スタッフ</h4>
			<p>
				<div class="staff_photo">
					<img src="//cgi3-aws.hondanet.co.jp/cgi/2153801/photo/draft_staff_photo2_01.jpg" class="staff_photo">
					<input type="checkbox" name="staff_photo2_delete" value="del">削除
					<br>
					画像を変更する場合<br>
					<input type="file" name="staff_photo2">
				</div>
				<div class="staff_data">
					氏名：<input type="text" maxlegth="8" name="staff_name2" value="羽賀" class="staff_text"><br>
					肩書：<input type="text" maxlength="12" name="staff_position2" value="営業" class="staff_text">
				</div>
			<p>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<h3>画像３枚目</h3>
			<h4>現在の画像</h4>
			<div class="photo">
				<img src="//cgi3-aws.hondanet.co.jp/cgi/2153801/photo/draft_shop_photo3_01.jpg" class="shop_photo">
			</div>
			<p>画像を変更する場合<br><input type="file" name="shop_photo3"></p>
		
			<h4>コメント</h4>
			<p><textarea maxlength="102" name="shop_comment3" class="comment">《キッズコーナー》
キッズコーナーのおもちゃは毎月入れ替えをしています。
除菌・抗菌済みの清潔なおもちゃですので小さなお子様でも安心して遊んでいただけます。</textarea></p>
		
			<h4>スタッフ</h4>
			<p>
				<div class="staff_photo">
					<img src="" class="staff_photo">
					<input type="checkbox" name="staff_photo3_delete" value="del">削除
					<br>
					画像を変更する場合<br>
					<input type="file" name="staff_photo3">
				</div>
				<div class="staff_data">
					氏名：<input type="text" maxlegth="8" name="staff_name3" value="" class="staff_text"><br>
					肩書：<input type="text" maxlength="12" name="staff_position3" value="" class="staff_text">
				</div>
			<p>
		</td>
		<td valign="top">
			<h3>画像４枚目</h3>
			<h4>現在の画像</h4>
			<div class="photo">
				<img src="//cgi3-aws.hondanet.co.jp/cgi/2153801/photo/draft_shop_photo4_01.jpg" class="shop_photo">
			</div>
			<p>画像を変更する場合<br><input type="file" name="shop_photo4"></p>
		
			<h4>コメント</h4>
			<p><textarea maxlength="102" name="shop_comment4" class="comment">《サービス工場》
ホンダの高い専門知識を持ったサービススタッフが、皆様の大切なお車を迅速丁寧に整備させていただきます。ホンダ車のことは是非一宮中央店にお任せ下さい！！</textarea></p>
		
			<h4>スタッフ</h4>
			<p>
				<div class="staff_photo">
					<img src="//cgi3-aws.hondanet.co.jp/cgi/2153801/photo/draft_staff_photo4_01.jpg" class="staff_photo">
					<input type="checkbox" name="staff_photo4_delete" value="del">削除
					<br>
					画像を変更する場合<br>
					<input type="file" name="staff_photo4">
				</div>
				<div class="staff_data">
					氏名：<input type="text" maxlegth="8" name="staff_name4" value="木野村" class="staff_text"><br>
					肩書：<input type="text" maxlength="12" name="staff_position4" value="サービスフロント" class="staff_text">
				</div>
			<p>
		</td>
	</tr>
	</table>
</div>
<!--h2>編集パスワードの設定</h2>
※変更する場合こちらに入力してください<br>
<input type="text" name="edit_pwd" value="2153801" -->

<div class="submit">
<input type="submit" value="入力内容の確認" class="Btn">
</div>


</form>
<div id="footer">
</div>
</body>
</html>