<dl class="c-control-edit__item">
    <dt class="c-control-edit__head">コメント</dt>
    <dd class="c-control-edit__body">
        <table style="margin:0px;width:100%;">
        <?php $style = '';?>
        @foreach($comment[$row->number] as $com)
            <tr style="{{ $style }}">
            <td style="font-size:10px;">{{ $com['date'] }}</td>
            @if($com['mark'])
            <td style="padding: 0 5px;"><img src="{{ asset_auto($com['mark']) }}" width="25%" ></td>
            @else
            <td style="padding: 0 5px;">  </td>
            @endif
            <td style="font-size:10px;">{{ $com['comment'] }}</td>
            </tr>
            <?php $style = "border-top:1px solid #aaa;"; ?>
        @endforeach
        </table>
    </dd>
</dl>