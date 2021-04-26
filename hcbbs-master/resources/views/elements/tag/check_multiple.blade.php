<?php
$options = $options ?? [];
$inline = $inline ?? false;
$selected = $selected ?? '';
$selected = explode(',', $selected);
?>
@foreach ($items as $key => $label)
    <?php
    $checked = in_array($key, $selected) ? " checked=checked" : '';
    ?>
    <label>
        <input{{ $checked }} name="{{ $id }}[]" type="checkbox" value="{{ $key }}"> {{ $label }}
    </label>
    @if ($inline)
        &nbsp;
    @else
        <br>
    @endif
@endforeach
