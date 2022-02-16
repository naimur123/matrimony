
@foreach($chats as $chat)
    @if(Auth::user()->id == $chat->from_id)
        <div class="row sender-self">
            <div class="col-xs-2 pull-right">
                <img src="{{ !is_null($chat->fromUser->profilePic) && file_exists($chat->fromUser->profilePic->image_path) ? asset($chat->fromUser->profilePic->image_path) : asset('dummy-user.png') }}" class="img-circle" width="30" height="30" >
            </div>
            <div class="col-xs-10 text-right">
                @if( substr($chat->message, 0,2) == "&#")
                    <span style="font-size: 25px">{!! $chat->message !!} </span>
                @else
                    {{ $chat->message }}
                @endif
            </div>
        </div>
    @else
        <div class="row sender-other">
            <div class="col-xs-2">
                <img src="{{ !is_null($chat->fromUser->profilePic) && file_exists($chat->fromUser->profilePic->image_path) ? asset($chat->fromUser->profilePic->image_path) : asset('dummy-user.png') }}" class="img-circle" width="30" height="30" >
            </div>
            <div class="col-xs-10">
                @if(substr($chat->message, 0, 2) == "&#")
                    {!! $chat->message !!}
                @else
                    {{ $chat->message }}
                @endif
            </div>
        </div>
    @endif

@endforeach