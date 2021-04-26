@if (count($comment[$row->number]) > 0)
<dl class="c-control-edit__item">
    <dt class="c-control-edit__head">コメント</dt>
    <dd class="c-control-edit__body">
        <table style="margin:0px;width:100%;">
        <?php $style = '';?>
        @foreach($comment[$row->number] as $com)
            <tr style="{{ $style }}">
                <td style="font-size:10px;width: 108px;">{{ $com['date'] }}</td>
                @if(preg_match('/GJ/', $com['mark']))
                    <td style="padding: 0 5px;width: 80px;"><img src="{{ asset_auto($com['mark']) }}" ></td>
                @elseif($com['mark'])
                    <td style="padding: 0 5px;width: 80px;"><img src="{{ asset_auto($com['mark']) }}" width="25%" ></td>
                @else
                    <td style="padding: 0 5px;width: 80px;">  </td>
                @endif
                <td style="font-size:10px;">{!! nl2br($com['comment']) !!}</td>
            </tr>
            <?php $style = "border-top:1px solid #aaa;"; ?>
        @endforeach
        </table>
    </dd>
</dl>
@endif
