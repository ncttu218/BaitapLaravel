<div class="staffCard__message">
    {{-- コメント --}}
    @if (!empty($row->comment))
    <p>{{ $row->comment }}</p>
    @endif
</div>

<div style="text-align: center;font-size: 11px;margin-top: 10px;">
    <a href="?shop={{ $shopCode }}&number={{ $row->number }}&action=lowest">一番上へ移動</a> |
    <a href="?shop={{ $shopCode }}&number={{ $row->number }}&action=lower">一つ上へ移動</a> |
    <a href="?shop={{ $shopCode }}&number={{ $row->number }}&action=upper">一つ下へ移動</a> |
    <a href="?shop={{ $shopCode }}&number={{ $row->number }}&action=uppest">一番下へ移動</a>
</div>
