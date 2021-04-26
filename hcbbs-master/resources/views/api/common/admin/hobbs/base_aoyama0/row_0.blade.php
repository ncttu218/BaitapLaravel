{{-- 右側（縦並び）--}}
<table width="100%" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td valign="top">
@include('api.common.admin.hobbs.column.comment')
            </td>
            <td align="right">
@include('api.common.admin.hobbs.column.file1')
                <br>
@include('api.common.admin.hobbs.column.caption1')
                <br>
@include('api.common.admin.hobbs.column.file2')
                <br>
@include('api.common.admin.hobbs.column.caption2')
                <br>
@include('api.common.admin.hobbs.column.file3')
                <br>
@include('api.common.admin.hobbs.column.caption3')
            </td>
	</tr>
    </tbody>
</table>
{{-- 問い合わせ方法 --}}
@include('api.common.admin.hobbs.column.inquiry')
