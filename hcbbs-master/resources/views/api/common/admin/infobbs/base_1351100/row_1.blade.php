{{-- 左側（縦並び）--}}
<table width="100%" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td align="left">
@include('api.common.admin.infobbs.column.file1')
                <br>
@include('api.common.admin.infobbs.column.caption1')
                <br>
@include('api.common.admin.infobbs.column.file2')
                <br>
@include('api.common.admin.infobbs.column.caption2')
                <br>
@include('api.common.admin.infobbs.column.file3')
                <br>
@include('api.common.admin.infobbs.column.caption3')
            </td>
            <td valign="top">
@include('api.common.admin.infobbs.column.comment')
            </td>
	</tr>
    </tbody>
</table>
{{-- 問い合わせ方法 --}}
@include('api.common.admin.infobbs.column.inquiry')
