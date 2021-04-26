@foreach ($blogs as $i => $item)
<article{{ $item['new_fig'] ? ' class=new' : '' }}>
    <a href="home/218_sr.html?shop={{ $item['shop_code'] }}">
        <figure>
            <img src="{{ $item['image'] }}" alt="">
        </figure>
        <h4><i>{{ $item['time'] }}</i>{{ $item['shop_name'] }}</h4>
        <p>{{ $item['title'] }}</p>
    </a>
</article>
@endforeach
