{{-- 右側（縦並び）--}}
<table width="100%" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td valign="top">
@include('infobbs.column.comment')
            </td>
            <td align="right">
@include('infobbs.column.file1')
                <br>
@include('infobbs.column.caption1')
                <br>
@include('infobbs.column.file2')
                <br>
@include('infobbs.column.caption2')
                <br>
@include('infobbs.column.file3')
                <br>
@include('infobbs.column.caption3')
            </td>
	</tr>
    </tbody>
</table>
{{-- 問い合わせ方法 --}}
@include('infobbs.column.inquiry')
