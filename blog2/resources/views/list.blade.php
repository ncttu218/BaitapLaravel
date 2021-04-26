<h1> Danh sach bai viet</h1>
<form method="POST" action="{{route('articles.edit')}}">
    @csrf
@foreach($articles as $article )
    <div>
        {{$article->title}}

        <button type="Submit">Edit</button>



    </div>
@endforeach
</form>


