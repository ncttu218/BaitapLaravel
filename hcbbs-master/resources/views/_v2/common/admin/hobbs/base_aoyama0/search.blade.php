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
{{-- 一覧画面 --}}
@if($dataType == 'object')
{{-- 写真位置で切替posがNULLの場合0設定 --}}
@if($row->pos == "")
@include('v2.common.admin.hobbs.base_aoyama0.row_' . '0')
@else
@include('v2.common.admin.hobbs.base_aoyama0.row_' . $row->pos)
@endif
@endif
{{-- 確認画面 --}}
@if($dataType == 'array')
{{-- 写真位置で切替 --}}
@include('v2.common.admin.hobbs.base_aoyama0.row_' . $data['pos'])
@endif
