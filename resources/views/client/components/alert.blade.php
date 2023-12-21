<div>
    @if(session()->has('status'))
    <div class="alert alert-success">
        @if(is_array(session()->get('status')))
        @foreach (session()->get('status') as $message)
        <p>{{ $message }}</p>
        @endforeach
        @else
        <p>{{ session()->get('success') }}</p>
        @endif
    </div>
    @endif
    @if(session()->has('statuss'))
    <div class="alert alert-danger">
      @if(is_array(session()->get('statuss')))
      @foreach (session()->get('statuss') as $message)
          <p>{{ $message }}</p>
      @endforeach
      @else
          <p>{{ session()->get('success') }}</p>
      @endif
    </div>
@endif
    <div>
        <ul>
            @foreach ($errors->all() as $e)
            <li style="color:red;">{{$e}}</li>
            @endforeach
        </ul>
    </div></div>