@if ($data['pos'] == 0)
    <TD ROWSPAN=2 WIDTH=5>
        <IMG src="2153801/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=5 HEIGHT=1>
    </TD>
@endif
<td rowspan="2" valign="TOP">
    <font style="font-size:10px;">
        @if ($imageData['hasData'])
            <font style="font-size:8px;">画像をクリックすると拡大表示できます</font>
        @endif
        <br>
        @for ($i = 1; $i <= 3; $i++)
            @if (isset($imageData[$i]))
                <a href="{{ asset_auto($imageData[$i]['url']) }}" target="_blank">
                    <img src="{{ asset_auto($imageData[$i]['url']) }}" width="200" border="0">
                </a>
            @endif
            {!! $imageData[$i]['caption'] ?? '' !!}<br>
        @endfor
    </font>
</td>
@if ($data['pos'] == 1)
    <TD ROWSPAN=2 WIDTH=5>
        <IMG src="2153801/infobbs/skins/image/0.gif" ALT="" ALIGN=BOTTOM WIDTH=5 HEIGHT=1>
    </TD>
@endif
