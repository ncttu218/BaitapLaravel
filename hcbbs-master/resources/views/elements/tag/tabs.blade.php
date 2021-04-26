<?php
$reqData = $_GET;
if (isset($unset)) {
    foreach ($unset as $keyName) {
        unset($reqData[$keyName]);
    }
}
?>
<ul class="nav nav-tabs main-nav-tabs">
    @foreach ($tabs as $key => $value)
    <li role="presentation"{{ $key == $selected ? ' class=active' : '' }}>
        <a href="?{{ $selector }}={{ $key }}&{{ http_arg_url($reqData, [$selector]) }}"><i class="fa fa-list-alt"></i> {{ $value }}</a>
    </li>
    @endforeach
</ul>