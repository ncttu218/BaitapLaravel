@foreach ( $staffs as $row)
    <?php
    // サムネール画像
    if (!empty($row->photo)) {
        $imageUrl = asset_auto($row->photo);
    } else {
        $imageUrl = asset_auto('img/5551803_staffinfo_default.gif');
    }
    ?>
    <section>
        <figure>
            <img src="{{ $imageUrl }}" border="0" width="120" f11="">
        </figure>
        <h1>{{ $row->name }}</h1>
        <p class="rub">{{ $row->name_furi }}</p>
        <p class="job">【{{ $row->department }}】</p>
        <ul>
            @if(!empty($row->ext_value6))
                <li><em>取得資格&nbsp;:&nbsp;</em>{{ $row->ext_value6 }}</li>
            @endif
            @if(!empty($row->ext_value1))
                <li><em>{{ $row->ext_field1 }}&nbsp;:&nbsp;</em>{{ $row->ext_value1 }}</li>
            @endif
            @if(!empty($row->ext_value2))
                <li><em>{{ $row->ext_field2 }}&nbsp;:&nbsp;</em>{{ $row->ext_value2 }}</li>
            @endif
            @if(!empty($row->ext_value3))
                <li><em>{{ $row->ext_field3 }}&nbsp;:&nbsp;</em>{{ $row->ext_value3 }}</li>
            @endif
            @if(!empty($row->ext_value4))
                <li><em>{{ $row->ext_field4 }}&nbsp;:&nbsp;</em>{{ $row->ext_value4 }}</li>
            @endif
            @if(!empty($row->ext_value5))
                <li><em>{{ $row->ext_field5 }}&nbsp;:&nbsp;</em>{{ $row->ext_value5 }}</li>
            @endif
        </ul>
        <p class="coment">{!! nl2br(trim($row->comment)) !!}</p>
    </section>
@endforeach
