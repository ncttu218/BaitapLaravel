{{-- 記事データが存在するとき --}}
@foreach ($blogs as $item)
    <div class="p-index-notice__inner">
        <div class="p-index-notice__head">お知らせ</div>
        <div class="p-index-notice__body">
            <a href="./home/blog.html?shop=em&page_num=1">{{ $item->title }}</a>
        </div>
    </div>

@endforeach