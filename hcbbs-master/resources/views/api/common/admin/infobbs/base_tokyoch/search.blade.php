{{-- 画像サイズ指定 --}}
<?php $img_width = "200px" ?>

{{-- タイトル --}}
<table width="100%" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td style="padding: 5px;background-color: #ccc;">
                @include('api.common.admin.infobbs.column.title')
            </td>
            <td style="padding: 5px;background-color: #ccc;" align ="right">
                @include('api.common.admin.infobbs.column.date')
            </td>
        </tr>
    </tbody>
</table>
{{-- ブログ 左側（縦並び）--}}
<table width="100%" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td>
                <figure>
                    @include('api.common.admin.infobbs.column.file1')
                    <figcaption>
                        @include('api.common.admin.infobbs.column.caption1')
                    </figcaption>
                </figure>
                <figure>
                    @include('api.common.admin.infobbs.column.file2')
                    <figcaption>
                        @include('api.common.admin.infobbs.column.caption2')
                    </figcaption>
                </figure>
                <figure>
                    @include('api.common.admin.infobbs.column.file3')
                    <figcaption>
                        @include('api.common.admin.infobbs.column.caption3')
                    </figcaption>
                </figure>
                <figure>
                    @include('api.common.admin.infobbs.column.file4')
                    <figcaption>
                        @include('api.common.admin.infobbs.column.caption4')
                    </figcaption>
                </figure>
                <figure>
                    @include('api.common.admin.infobbs.column.file5')
                    <figcaption>
                        @include('api.common.admin.infobbs.column.caption5')
                    </figcaption>
                </figure>
                <figure>
                    @include('api.common.admin.infobbs.column.file6')
                    <figcaption>
                        @include('api.common.admin.infobbs.column.caption6')
                    </figcaption>
                </figure>
            </td>
            <td valign="top">
                @include('api.common.admin.infobbs.column.comment')
            </td>
        </tr>
    </tbody>
</table>
{{-- 問い合わせ方法 --}}
@include('api.common.admin.infobbs.column.inquiry')
