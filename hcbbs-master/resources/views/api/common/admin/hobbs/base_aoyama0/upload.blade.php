{{-- 画像サイズ指定 --}}
<?php $img_width = "200px" ?>

@if($upflag == 'on')

{{-- 編集 --}}
写真1の変更<br>
@if($data['file1'])
@if(substr($data['file1'],0,4) == 'err/')
<span class="upload_err">
    エラー : {{ substr($data['file1'],4) }}<br>
    このファイルタイプ({{ substr($data['file1'], strrpos($data['file1'], '.') + 1) }})は対応していません。<br>
</span>
@else
<a href="{{ asset_auto($data['file1']) }}" target="_blank">
    <img width="{{ $img_width }}" src="{{ asset_auto($data['file1']) }}">
</a>
<br>
<br>
@endif
@endif
<input type="file" name="file1" value="{{ $data['file1'] }}">
コメント<br>
<input type="text" size="30" name="caption1" value="{{ $data['caption1'] }}"><br>
@if($data['file1'])
@if(substr($data['file1'],0,4) != 'err/')
<span class="upload_del">
    <input type="checkbox" name="delete1" value="delete">この画像を削除
</span>
@endif
@endif
<br><br>

写真2の変更<br>
@if($data['file2'])
@if(substr($data['file2'],0,4) == 'err/')
<span class="upload_err">
    エラー : {{ substr($data['file2'],4) }}<br>
    このファイルタイプ({{ substr($data['file2'], strrpos($data['file2'], '.') + 1) }})は対応していません。<br>
</span>
@else
<a href="{{ asset_auto($data['file2']) }}" target="_blank">
    <img width="{{ $img_width }}" src="{{ asset_auto($data['file2']) }}">
</a>
<br>
@endif
@endif
<input type="file" name="file2" value="{{ $data['file2'] }}">
コメント<br>
<input type="text" size="30" name="caption2" value="{{ $data['caption2'] }}"><br>
@if($data['file2'])
@if(substr($data['file2'],0,4) != 'err/')
<span class="upload_del">
    <input type="checkbox" name="delete2" value="delete">この画像を削除
</span>
@endif
@endif
<br>
<br>

写真3の変更<br>
@if($data['file3'])
@if(substr($data['file3'],0,4) == 'err/')
<span class="upload_err">
    エラー : {{ substr($data['file3'],4) }}<br>
    このファイルタイプ({{ substr($data['file3'], strrpos($data['file3'], '.') + 1) }})は対応していません。<br>
</span>
@else
<a href="{{ asset_auto($data['file3']) }}" target="_blank">
    <img width="{{ $img_width }}" src="{{ asset_auto($data['file3']) }}">
</a>
<br>
@endif
@endif
<input type="file" name="file3" value="{{ $data['file3'] }}">
コメント<br>
<input type="text" size="30" name="caption3" value="{{ $data['caption3'] }}"><br>
@if($data['file3'])
@if(substr($data['file3'],0,4) != 'err/')
<span class="upload_del">
    <input type="checkbox" name="delete3" value="delete">この画像を削除
</span>
@endif
@endif
<br>

@else

{{-- 新規 --}}
写真1
<br>
<input type="file" name="file1" value="{{ $data['file1'] }}">
<br>
写真1コメント
<br>
<input type="text" size="30" name="caption1" value="{{ $data['caption1'] }}">
<br>
写真2
<br>
<input type="file" name="file2" value="{{ $data['file2'] }}">
<br>
写真2コメント
<br>
<input type="text" size="30" name="caption2" value="{{ $data['caption2'] }}">
<br>
写真3
<br>
<input type="file" name="file3" value="{{ $data['file3'] }}">
<br>
写真3コメント
<br>
<input type="text" size="30" name="caption3" value="{{ $data['caption3'] }}">
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
<br>
写真の位置
{!! Form::select('pos',['3' => '下側(横並び)','2' => '上側(横並び)','0' => '右側(縦並び)','1' => '左側(縦並び)'],$data['pos']) !!}
