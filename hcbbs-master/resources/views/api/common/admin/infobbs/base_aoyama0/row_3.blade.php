{{-- 下側（横並び）--}}
<table width="100%" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td>
@include('api.common.admin.infobbs.column.comment')
            </td>
        </tr>
        <tr>
            <td>
                <table>
                    <tbody>
                        <tr>
                            <td>
@include('api.common.admin.infobbs.column.file1')
                            </td>
                            <td>
@include('api.common.admin.infobbs.column.file2')
                            </td>
                            <td>
@include('api.common.admin.infobbs.column.file3')
                            </td>
                        </tr>
                        <tr>
                            <td>
@include('api.common.admin.infobbs.column.caption1')
                            </td>
                            <td>
@include('api.common.admin.infobbs.column.caption2')
                            </td>
                            <td>
@include('api.common.admin.infobbs.column.caption3')
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
{{-- 問い合わせ方法 --}}
@include('api.common.admin.infobbs.column.inquiry')

