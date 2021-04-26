<tr>
    <td valign="TOP">
        <table border="0" cellspacing="0" cellpadding="1">
            <tr valign="bottom">
                @for ($i = 1; $i <= 3; $i++)
                <td>
                    <font style="font-size:10px;">
                        @if ($imageData['hasData'])
                            <font style="font-size:8px;">画像をクリックすると拡大表示できます</font>
                            <br>
                        @endif
                        @if (isset($imageData[$i]))
                            <a href="{{ asset_auto($imageData[$i]['url']) }}" target="_blank">
                                <img src="{{ asset_auto($imageData[$i]['url']) }}" width="200" border="0">
                            </a>
                            {!! $imageData[$i]['caption'] ?? '' !!}
                        @endif
                        <br>
                    </font>
                </td>
                @endfor
            </tr>
        </table>
    </td>
</tr>
