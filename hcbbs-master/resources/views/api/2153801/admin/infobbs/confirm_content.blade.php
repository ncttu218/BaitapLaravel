<?php
// 画像データ
$imageData = [];
for ($i = 1; $i <= 3; $i++) {
    $varName = "file{$i}";
    if (empty($data[$varName])) {
        continue;
    }
    $imageData[$i] = [
        'url' => $data[$varName],
        'caption' => $data['caption' . $i]
    ];
}
$imageData['hasData'] = count($imageData) > 0;
?>
<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=613 background="2153801/infobbs/skins/image/00.gif">
    @if ($data['pos'] == 2)
    @include($templateDir . '.images.confirm_horizontal')
    @endif
    <TR>
        @if ($data['pos'] == 1)
        @include($templateDir . '.images.confirm_vertical')
        @endif
        <TD VALIGN=TOP WIDTH=408>
            {{-- 記事が改行が必要かの判定 --}}
            @if (has_no_nl($data['comment']))
            {!! nl2br( $data['comment'] ) !!}
            @else
            {!! $data['comment'] !!}
            @endif
            @if (($data['pos'] == 2 || $data['pos'] == 3) && !empty($data['inquiry_inscription']))
            <br>
            <a href="mailto:{{ $data['mail_addr'] }}?Subject={{ $data['form_addr'] }}の件">
                {{ $data['inquiry_inscription'] }}
            </a>
            @endif
        </TD>
        @if ($data['pos'] == 0)
        @include($templateDir . '.images.confirm_vertical')
        @endif
    </TR>
    @if ($data['pos'] == 3)
    @include($templateDir . '.images.confirm_horizontal')
    @endif
    <tr>
        <td colspan="3">
            @if (($data['pos'] == 0 || $data['pos'] == 1) && !empty($data['inquiry_inscription']))
            <a href="mailto:{{ $data['mail_addr'] }}?Subject={{ $data['form_addr'] }}の件">
                {{ $data['inquiry_inscription'] }}
            </a>
            @endif
        </td>
    </tr>
    <tr>
        <td valign="TOP"><br></td>
    </tr>
    <tr>
        <td valign="TOP"><br></td>
    </tr>
</TABLE>
