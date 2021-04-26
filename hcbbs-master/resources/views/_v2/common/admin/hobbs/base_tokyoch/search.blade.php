{{-- 画像サイズ指定 --}}
<?php $img_width = "200px" ?>

{{-- タイトル --}}
<table width="100%" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td style="padding: 5px;background-color: #ccc;">
                @include('v2.common.admin.hobbs.column.title')
            </td>
            <td style="padding: 5px;background-color: #ccc;" align ="right">
                @include('v2.common.admin.hobbs.column.date')
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
                    @include('v2.common.admin.hobbs.column.file1')
                    <figcaption>
                        @include('v2.common.admin.hobbs.column.caption1')
                    </figcaption>
                </figure>
                <figure>
                    @include('v2.common.admin.hobbs.column.file2')
                    <figcaption>
                        @include('v2.common.admin.hobbs.column.caption2')
                    </figcaption>
                </figure>
                <figure>
                    @include('v2.common.admin.hobbs.column.file3')
                    <figcaption>
                        @include('v2.common.admin.hobbs.column.caption3')
                    </figcaption>
                </figure>
                <figure>
                    @include('v2.common.admin.hobbs.column.file4')
                    <figcaption>
                        @include('v2.common.admin.hobbs.column.caption4')
                    </figcaption>
                </figure>
                <figure>
                    @include('v2.common.admin.hobbs.column.file5')
                    <figcaption>
                        @include('v2.common.admin.hobbs.column.caption5')
                    </figcaption>
                </figure>
                <figure>
                    @include('v2.common.admin.hobbs.column.file6')
                    <figcaption>
                        @include('v2.common.admin.hobbs.column.caption6')
                    </figcaption>
                </figure>
            </td>
            <td valign="top">
                @include('v2.common.admin.hobbs.column.comment')
            </td>
        </tr>
    </tbody>
</table>
{{-- 問い合わせ方法 --}}
@include('v2.common.admin.hobbs.column.inquiry')
