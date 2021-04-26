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

<form action="{{ $urlSaveDesign ?? '' }}" method="POST" name="form1">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="shop" value="<?php echo $shopCode;?>">
    <h2><?php echo $shopName;?> 背景デザインおよび写真フレームの選択</h2>
    <div id="layout-pattern">
        <h3>背景デザインを選択</h3>
        <?php
        $layout = $design['layout'];
        ?>
        <p class="inputValue"><?php echo $codes['layout'][$layout] ?? '';?></p>
        <h3>写真フレームを選択</h3>
        <?php
        $pattern = $design['pattern'];
        ?>
        <p class="inputValue"><?php echo $codes['pattern'][$pattern] ?? '';?></p>
    </div>
    
    <h2>画像の選択・コメントの登録</h2>
    <div id="layout-pattern">
    <table>
        <tr>
            <td valign="top" colspan="2">
                <h3>メイン画像</h3>
                <h4>現在の画像</h4>
                @isset($design['main_photo'])
                <div class="photo">
                    <img src="<?php echo $design['main_photo_url'];?>?<?php echo $now;?>" width="800">
                </div>
                @endisset
            </td>
        </tr>
        <tr>
            <td valign="top" width="50%">
                <h3>画像１枚目</h3>
                <h4>現在の画像</h4>
                @isset($staff[1])
                @isset($staff[1]['photo2'])
                <div class="photo">
                    <img src="<?php echo $staff[1]['photo2_url'];?>?<?php echo $now;?>" width="400">
                </div>
                @endisset
                <h4>コメント</h4>
                <p><?php echo $staff[1]['comment'];?></p>
                <h4>スタッフ</h4>
                <p>
                    @isset($staff[1]['photo'])
                    <div class="staff_photo">
                        <?php if($staff[1]['photo']){?>
                        <img src="<?php echo $staff[1]['photo_url'];?>?<?php echo $now;?>" width="122" class="staff_photo"><br>
                        <?php } ?>
                    </div>
                    @endisset
                    <div class="staff_data">
                        氏名：<?php echo $staff[1]['name'];?><br>
                        肩書：<?php echo $staff[1]['department'];?>
                    </div>
                <p>
                @endisset
            </td>
            <td valign="top" width="50%">
                <h3>画像２枚目</h3>
                <h4>現在の画像</h4>
                @isset($staff[2])
                @isset($staff[2]['photo2'])
                <div class="photo">
                    <img src="<?php echo $staff[2]['photo2_url'];?>?<?php echo $now;?>" width="400">
                </div>
                @endisset
                <h4>コメント</h4>
                <p><?php echo $staff[2]['comment'];?></p>
            
                <h4>スタッフ</h4>
                <p>
                    @isset($staff[2]['photo'])
                    <div class="staff_photo">
                        <?php if($staff[2]['photo']){?>
                        <img src="<?php echo $staff[2]['photo_url'];?>?<?php echo $now;?>" width="122" class="staff_photo"><br>
                        <?php } ?>
                    </div>
                    @endisset
                    <div class="staff_data">
                        氏名：<?php echo $staff[2]['name'];?><br>
                        肩書：<?php echo $staff[2]['department'];?>
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
                @isset($staff[3]['photo2'])
                <div class="photo">
                    <img src="<?php echo $staff[3]['photo2_url'];?>?<?php echo $now;?>" width="400">
                </div>
                @endisset
                <h4>コメント</h4>
                <p><?php echo $staff[3]['comment'];?></p>
            
                <h4>スタッフ</h4>
                <p>
                    @isset($staff[3]['photo'])
                    <div class="staff_photo">
                        <?php if($staff[3]['photo']){?>
                        <img src="<?php echo $staff[3]['photo_url'];?>?<?php echo $now;?>" width="122" class="staff_photo"><br>
                        <?php } ?>
                    </div>
                    @endisset
                    <div class="staff_data">
                        氏名：<?php echo $staff[3]['name'];?><br>
                        肩書：<?php echo $staff[3]['department'];?>
                    </div>
                <p>
                @endisset
            </td>
            <td valign="top">
                <h3>画像４枚目</h3>
                <h4>現在の画像</h4>
                @isset($staff[4])
                @isset($staff[4]['photo2'])
                <div class="photo">
                    <img src="<?php echo $staff[4]['photo2_url'];?>?<?php echo $now;?>" width="400">
                </div>
                @endisset
                <h4>コメント</h4>
                <p><?php echo $staff[4]['comment'];?></p>
            
                <h4>スタッフ</h4>
                <p>
                    @isset($staff[4]['photo'])
                    <div class="staff_photo">
                        <?php if($staff[4]['photo']){?>
                        <img src="<?php echo $staff[4]['photo'];?>?<?php echo $now;?>" width="122" class="staff_photo"><br>
                        <?php } ?>
                    </div>
                    @endisset
                    <div class="staff_data">
                        氏名：<?php echo $staff[4]['name'];?><br>
                        肩書：<?php echo $staff[4]['department'];?>
                    </div>
                <p>
                @endisset
            </td>
        </tr>
        </table>
    </div>
    <div class="submit">
    <a href="{{ $urlEditDesign }}" class="retutnBtn Btn">修正</a>
    <a href="javascript:void(0);" onClick="window.open('https://www.hondacars-aichi.com/home/sr.html?shop=<?php echo $shopCode;?>&dispmode=preview','_blank');" class="PreviewBtn Btn">プレビュー</a>
    <input type="submit" value="ホームページへ反映" class="writeBtn Btn">
    </div>
</form>

<div id="footer">
</div>
</body>
</html>
    