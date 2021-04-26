<form action="{{route('articles.store')}}"method="post">
    @csrf
    <div>
        <label for="title">Tieu de</label>
        <input type="text" name="title"/>
    </div>
    <div>
        <label for="content">Noi dung</label>
        <br>
        <textarea cols="25"rows="8" name="content"></textarea>

    <div>
        <button type="Submit">dang bai</button>
    </div>
    </div>
</form>

