@foreach ($blogs as $i => $item)
<img src="{{ $item['image'] }}" class="left" width="218">
<ul class="right">
    <li class="info-day">{{ $item['time'] }}</li>
    <li class="info-title">{{ $item['title'] }}</li>
    <li class="info-contents">
        <a href="/hondacars-towada/home/170_information.html">{{ $item['content'] }}</a>
    </li>
    <br>
</ul>
<br>
@endforeach
