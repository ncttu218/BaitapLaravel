@if($errors->any())
  <div class="alert alert-danger block-center text-center">
      @foreach($errors->all() as $error)
          {{ $error }}<br/>
      @endforeach
  </div>
@endif

@if (session('error'))
  <tr>
    <td colspan="5">
      <div id="entry_error">
        {{ session('error') }}
      </div>
    </td>
  </tr>
@endif
