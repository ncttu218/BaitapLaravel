{{-- 下側（横並び）--}}
<table width="100%" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td>
@include('v2.common.admin.hobbs.column.comment')
            </td>
        </tr>
        <tr>
            <td>
                <table>
                    <tbody>
                        <tr>
                            <td>
@include('v2.common.admin.hobbs.column.file1')
                            </td>
                            <td>
@include('v2.common.admin.hobbs.column.file2')
                            </td>
                            <td>
@include('v2.common.admin.hobbs.column.file3')
                            </td>
                        </tr>
                        <tr>
                            <td>
@include('v2.common.admin.hobbs.column.caption1')
                            </td>
                            <td>
@include('v2.common.admin.hobbs.column.caption2')
                            </td>
                            <td>
@include('v2.common.admin.hobbs.column.caption3')
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
{{-- 問い合わせ方法 --}}
@include('v2.common.admin.hobbs.column.inquiry')

