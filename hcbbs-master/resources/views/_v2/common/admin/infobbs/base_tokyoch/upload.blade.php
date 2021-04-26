{{-- 画像サイズ指定 --}}
<?php $img_width = "200px" ?>

@if($upflag == 'on')

@if($data['file1'])
@if(substr($data['file1'],0,4) == 'err/')
<span class="upload_err">
    エラー : {{ substr($data['file1'],4) }}
    <br>
    このファイルタイプ({{ substr($data['file1'], strrpos($data['file1'], '.') + 1) }})は対応していません。
    <br>
</span>
@else
<a href="{{ asset_auto($data['file1']) }}" target="_blank">
    <img width="{{ $img_width }}" src="{{ asset_auto($data['file1']) }}">
</a>
<br>
@endif
@endif
写真1の変更
<input type="file" name="file1" value="{{ $data['file1'] }}">
コメント1<br>
<input type="text" name="caption1" size="30" value="{{ $data['caption1'] }}"><br>
@if($data['file1'])
@if(substr($data['file1'],0,4) != 'err/')
<span class="upload_del">
    <input type="checkbox" name="delete1" value="delete">この画像を削除
</span>
@endif
@endif
<br>
@if($data['file2'])
@if(substr($data['file2'],0,4) == 'err/')
<span class="upload_err">
    エラー : {{ substr($data['file2'],4) }}
    <br>
    このファイルタイプ({{ substr($data['file2'], strrpos($data['file2'], '.') + 1) }})は対応していません。
    <br>
</span>
@else
<a href="{{ asset_auto($data['file2']) }}" target="_blank">
    <img width="{{ $img_width }}" src="{{ asset_auto($data['file2']) }}">
</a>
<br>
@endif
@endif
写真2の変更
<input type="file" name="file2" value="{{ $data['file2'] }}">
コメント2<br>
<input type="text" name="caption2" size="30" value="{{ $data['caption2'] }}"><br>
@if($data['file2'])
@if(substr($data['file2'],0,4) != 'err/')
<span class="upload_del">
    <input type="checkbox" name="delete2" value="delete">この画像を削除<br>
</span>
@endif
@endif
<br>
@if($data['file3'])
@if(substr($data['file3'],0,4) == 'err/')
<span class="upload_err">
    エラー : {{ substr($data['file3'],4) }}
    <br>
    このファイルタイプ({{ substr($data['file3'], strrpos($data['file3'], '.') + 1) }})は対応していません。
    <br>
</span>
@else
<a href="{{ asset_auto($data['file3']) }}" target="_blank">
    <img width="{{ $img_width }}" src="{{ asset_auto($data['file3']) }}">
</a>
<br>
@endif
@endif
写真の変更3
<input type="file" name="file3" value="{{ $data['file3'] }}">
コメント3<br>
<input type="text" name="caption3" size="30" value="{{ $data['caption3'] }}"><br>
@if($data['file3'])
@if(substr($data['file3'],0,4) != 'err/')
<span class="upload_del">
    <input type="checkbox" name="delete3" value="delete">この画像を削除<br>
</span>
@endif
@endif
<br>
@if($data['file4'])
@if(substr($data['file4'],0,4) == 'err/')
<span class="upload_err">
    エラー : {{ substr($data['file4'],4) }}
    <br>
    このファイルタイプ({{ substr($data['file4'], strrpos($data['file4'], '.') + 1) }})は対応していません。
    <br>
</span>
@else
<a href="{{ asset_auto($data['file4']) }}" target="_blank">
    <img width="{{ $img_width }}" src="{{ asset_auto($data['file4']) }}">
</a>
<br>
@endif
@endif
写真4の変更
<input type="file" name="file4" value="{{ $data['file4'] }}">
コメント4<br>
<input type="text" name="caption4" size="30" value="{{ $data['caption4'] }}"><br>
@if($data['file4'])
@if(substr($data['file4'],0,4) != 'err/')
<span class="upload_del">
    <input type="checkbox" name="delete4" value="delete">この画像を削除<br>
</span>
@endif
@endif
<br>
@if($data['file5'])
@if(substr($data['file5'],0,4) == 'err/')
<span class="upload_err">
    エラー : {{ substr($data['file5'],4) }}
    <br>
    このファイルタイプ({{ substr($data['file5'], strrpos($data['file5'], '.') + 1) }})は対応していません。
    <br>
</span>
@else
<a href="{{ asset_auto($data['file5']) }}" target="_blank">
    <img width="{{ $img_width }}" src="{{ asset_auto($data['file5']) }}">
</a>
<br>
@endif
@endif
写真5の変更
<input type="file" name="file5" value="{{ $data['file5'] }}">
コメント5<br>
<input type="text" name="caption5" size="30" value="{{ $data['caption5'] }}"><br>
@if($data['file5'])
@if(substr($data['file5'],0,4) != 'err/')
<span class="upload_del">
    <input type="checkbox" name="delete5" value="delete">この画像を削除<br>
</span>
@endif
@endif
<br>
@if($data['file6'])
@if(substr($data['file6'],0,4) == 'err/')
<span class="upload_err">
    エラー : {{ substr($data['file6'],4) }}
    <br>
    このファイルタイプ({{ substr($data['file6'], strrpos($data['file6'], '.') + 1) }})は対応していません。
    <br>
</span>
@else
<a href="{{ asset_auto($data['file6']) }}" target="_blank">
    <img width="{{ $img_width }}" src="{{ asset_auto($data['file6']) }}">
</a>
<br>
@endif
@endif
写真6の変更
<input type="file" name="file6" value="{{ $data['file6'] }}">
コメント6<br>
<input type="text" name="caption6" size="30" value="{{ $data['caption6'] }}"><br>
@if($data['file6'])
@if(substr($data['file6'],0,4) != 'err/')
<span class="upload_del">
    <input type="checkbox" name="delete6" value="delete">この画像を削除<br>
</span>
@endif
@endif
<br>

@else

写真1<br>
<input type="file" name="file1" value="{{ $data['file1'] }}">
写真1コメント<br>
<input type="text" name="caption1" size="30" value="{{ $data['caption1'] }}">
<br>
<br>
写真2<br>
<input type="file" name="file2" value="{{ $data['file2'] }}">
写真2コメント<br>
<input type="text" name="caption2" size="30" value="{{ $data['caption2'] }}">
<br>
<br>
写真3<br>
<input type="file" name="file3" value="{{ $data['file3'] }}">
写真3コメント<br>
<input type="text" name="caption3" size="30" value="{{ $data['caption3'] }}">
<br>
<br>
写真4<br>
<input type="file" name="file4" value="{{ $data['file4'] }}">
写真4コメント<br>
<input type="text" name="caption4" size="30" value="{{ $data['caption4'] }}">
<br>
<br>
写真5<br>
<input type="file" name="file5" value="{{ $data['file5'] }}">
写真5コメント<br>
<input type="text" name="caption5" size="30" value="{{ $data['caption5'] }}">
<br>
<br>
写真6<br>
<input type="file" name="file6" value="{{ $data['file6'] }}">
写真6コメント<br>
<input type="text" name="caption6" size="30" value="{{ $data['caption6'] }}">
<br>

@endif

<span style="color :#ff0000; font-size :10px">
    注意・ファイル名に日本語（半角カナ・全角文字）は使えません！ 
</span>
<br>
<span style="color :#009; font-size :10px"> 
    半角英数字のファイル名を使用して下さい。 <br>
    一覧ページでの掲載写真は横幅{{ $img_width }}になります。
</span>
