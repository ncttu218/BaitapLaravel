<td valign="top"{{ $row->pos == 0 ? ' align=right' : '' }} bgcolor="#FFFFFF">
    <font style="font-size:10px;"> 
        @if ($imageData['hasData'])
            <font style="font-size:8px;">画像をクリックすると拡大表示できます</font>
        @endif
        @for ($i = 1; $i <= 3; $i++)
            <br>
            @if (isset($imageData[$i]))
                <a href="{{ asset_auto($imageData[$i]['url']) }}" target="_blank">
                    <img src="{{ asset_auto($imageData[$i]['url']) }}" width="200" border="0">
                </a>
                <br>{!! $imageData[$i]['caption'] ?? '' !!}
                <br> 
            @endif
        @endfor
    </font>
</td>
