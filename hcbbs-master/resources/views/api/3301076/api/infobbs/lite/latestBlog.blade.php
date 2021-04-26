@foreach ($blogs as $i => $item)
<article{{ $item['new_fig'] ? ' class=new' : '' }}>
    <a href="home/blog{{ $item['shop_code'] }}.html">
        <figure>
            <img src="{{ $item['image'] }}" alt="">
        </figure>
        <h4><i>{{ $item['time'] }}</i>{{ $item['shop_name'] }}</h4>
        <p>{{ $item['title'] }}</p>
    </a>
</article>
@endforeach
