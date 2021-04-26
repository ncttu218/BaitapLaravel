<tr> 
    <td valign="top" bgcolor="#FFFFFF" nowrap="" colspan="3"> 
        <table border="0" cellspacing="0" cellpadding="1">
            <tbody>
                <tr valign="bottom">
                    @for ($i = 1; $i <= 3; $i++)
                    <td bgcolor="#FFFFFF">
                        <font style="font-size:10px;">
                        @if (isset($imageData[$i]))
                            @if ($imageData['hasData'])
                                <font style="font-size:8px;">画像をクリックすると拡大表示できます</font>
                                <br>
                            @endif
                            <a href="{{ asset_auto($imageData[$i]['url']) }}" target="_blank">
                                <img src="{{ asset_auto($imageData[$i]['url']) }}" width="200" border="0">
                            </a>
                        @endif
                        </font>
                    </td>
                    @endfor
                </tr>
                <tr>
                    @foreach ($imageData as $image)
                    <td valign="top" bgcolor="#FFFFFF">
                        <font style="font-size:10px;">{!! $image['caption'] ?? '' !!}</font>
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </td>
</tr>