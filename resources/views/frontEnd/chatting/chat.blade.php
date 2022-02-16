<style>
  .chatting-panel{min-height: 100vh; max-height: 100%; overflow: hidden;overflow-y: auto; }
  .online-signal{ right: 0px; width: 7px; border-radius: 150px; height:7px; background:#5bc0de; float: right; margin-top: 20px;}
  .chatting-window{ position: fixed; bottom: 0px; right: 350px; z-index: 1000; width: 300px; margin-bottom:1px;}
  .chat-open{height: 350px;}
  .chat-minimize{height: 30px;}
  .send-text .text {margin: 0px; padding: 0px; width:100%;float: left;}
  .send-text .send {width:0%;position: absolute; right:15px;}
  .emoji {position: absolute; right: -42px; top:8px; cursor: pointer;}
  .emoji-btn{padding: 0px; margin: 0px; background: transparent; border: none;}
  .send-text .form-control{ border:0px;}
  .chat-body{ max-height: 250px; overflow: hidden; overflow-y: auto; font-size:14px;}
  .from-bottom{ bottom: 1px;position: absolute;left: 15px; right: 55px;}
  @media only screen and (max-width: 650px) {
    .chatting-window{ right: 0px;}
  }
  .sender-self, .sender-other{padding: 8px 10px; background:#eee; border-radius: 5px; margin: 0px; margin-top: 8px;}
  .sender-self{ background:rgba(14, 64, 217, 0.19); }
  .chat-message{ background: #ddd;}
  .send .btn-default{background: #ddd;border:none; padding:10px 12px; border-left: 1px solid #fff;}
  .emoji-list{font-size: 23px; margin: 5px 0px 0px 1px;}
  .emoji-list:hover{cursor: pointer; opacity: .7;}

</style>

<!-- Connected User List -->
<div class="row chatting-panel">
    <ul class="list-group">
      @foreach($chatList as $profile)        
        <a class="list-group-item chat-list" href=":javascript;" data-name="MMBD-{{$profile->id}}" data-to_id="{{$profile->id}}"  >
          <img src="{{ isset($profile->profilePic->image_path) && file_exists($profile->profilePic->image_path) ? asset($profile->profilePic->image_path) : asset('dummy-user.png') }}" width="50" height="50" class="img-circle"> &nbsp; 
              MMBD-{{ $profile->id }}
            @if($profile->is_online)
              <div class="online-signal"></div>
            @endif          
          <div class="clearfix"></div>
        </a>        
      @endforeach       
    </ul>
</div>

<!-- Chatting Window -->
<div class="chatting-window panel panel-info hidden" >
    <div class="panel-heading">
      <div class="row">
        <div class="col-xs-10 profile-name"></div>
        <div class="col-xs-2 text-right">
          <button class="btn btn-danger btn-xs close-chat">&times;</button>
        </div>
      </div>
    </div>

    <div class="panel-body">
      <input type="hidden" id="to_id">      
      <!-- Chat -body -->
      <div class="chat-body">
        <!-- This data will be load by ajax -->
      </div>
    </div>

    <!-- Send Message -->
    <form class="from-bottom chat-form" method="GET">
      <div class="send-text">
        <div class="text">
          <input class="form-control chat-message" type="text" placeholder="Write your message" >
        </div>
        <div class="send">
          <button class="btn btn-default" type="submit" title="Send Message" > <span class="fa fa-share"></span> </button>
        </div>
        <div class="emoji dropup">              
              <button class="emoji-btn dropdown-toggle" type="button" id="emoji-panel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-smile"></i>
              </button>
              <div class="dropdown-menu emoji-panel text-center" aria-labelledby="emoji-panel">
                <span class="emoji-list" data-code="{{ emoji(':smile:') }}" > {!! emoji(':smile:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':laughing:') }}" > {!! emoji(':laughing:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':blush:') }}" > {!! emoji(':blush:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':smirk:') }}" > {!! emoji(':smirk:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':heart_eyes:') }}" > {!! emoji(':heart_eyes:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':kissing:') }}" > {!! emoji(':kissing:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':kissing_heart:') }}" > {!! emoji(':kissing_heart:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':kissing_closed_eyes:') }}" > {!! emoji(':kissing_closed_eyes:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':flushed:') }}" > {!! emoji(':flushed:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':satisfied:') }}" > {!! emoji(':satisfied:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':wink:') }}" > {!! emoji(':wink:') !!} </span>                
                <span class="emoji-list" data-code="{{ emoji(':stuck_out_tongue_winking_eye:') }}" > {!! emoji(':stuck_out_tongue_winking_eye:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':stuck_out_tongue:') }}" > {!! emoji(':stuck_out_tongue:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':sleeping:') }}" > {!! emoji(':sleeping:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':confused:') }}" > {!! emoji(':confused:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':open_mouth:') }}" > {!! emoji(':open_mouth:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':sweat:') }}" > {!! emoji(':sweat:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':cry:') }}" > {!! emoji(':cry:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':sob:') }}" > {!! emoji(':sob:') !!} </span>                
                <span class="emoji-list" data-code="{{ emoji(':joy:') }}" > {!! emoji(':joy:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':sunglasses:') }}" > {!! emoji(':sunglasses:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':angry:') }}" > {!! emoji(':angry:') !!} </span>
                <span class="emoji-list" data-code="{{ emoji(':rage:') }}" > {!! emoji(':rage:') !!} </span>                
              </div>
            </div>
        </div>
      </div>
    </form>
</div>



<script>
  let user_id;
  let auto_load;
  $(document).on('click','.chat-list', function(e){
    e.preventDefault();
    $('.chatting-window').removeClass('hidden');
    $('.chatting-window').addClass('chat-open');

    user_id = $(this)[0].dataset.to_id;
    var profile_link = `<a href="profile/`+user_id+`/MMBD-`+user_id+`/view">`+$(this)[0].dataset.name+`</a>`;
    $('.profile-name').html(profile_link);

    
    $('#to_id').val(user_id);    
    loadchat();    
  });

  $(document).on('submit','.chat-form', function(e){
    e.preventDefault();
    let text = $('.chat-message').val();
    let to_id = $('#to_id').val();
    if(!text.match(/^\s*$/)) { 
      sendNewMessage(to_id, text);
      $('.chat-message').val(null); 
    }
  });

  $(document).on('click', '.emoji-list', function(){
    $('.chat-message').val( this.dataset.code );
    $('.chat-form').submit();
  });

  // Load all Chat
  function loadchat(){
    $.ajax({
      url : '{{ url('load/chat') }}',
      data : { 'user_id' : user_id},
      success : function(output){
        if(output.status){
          $('.chat-body').html(output.data);
          $('.chat-body').scrollTop($('.chat-body')[0].scrollHeight);
          auto_load = setInterval(loadUnseenchat, 3000);
        }else{
          clearInterval(auto_load);
          $('.chat-body').html(output.message); 
          $('.chat-body').scrollTop($('.chat-body')[0].scrollHeight);                   
        }        
      },
      error : function(response){
        errorMessage(getError(response));
      }
    });
  }

  // Send Message
  function sendNewMessage(to_id, text){
    $.ajax({
      url : '{{ url('message/send') }}',
      method : 'get',
      data : { 'user_id' : to_id, 'message' : text },
      success : function(output){
        if(output.status){  
          $('.chat-body').append(getLastMessage(output));
          $('.chat-body').scrollTop($('.chat-body')[0].scrollHeight);
        }else{
          clearInterval(auto_load);
          $('.chat-body').append(output.message);
          $('.chat-body').scrollTop($('.chat-body')[0].scrollHeight);                    
        }
      },
      error : function(response){
        errorMessage(getError(response));
      }
    });
  }

  // Get Last Message
  function getLastMessage(output){
    let text = `<div class="row sender-self">
            <div class="col-xs-2 pull-right">
                <img src="{{ isset($user->profilePic->image_path) && file_exists($user->profilePic->image_path) ? asset($user->profilePic->image_path) : asset('dummy-user.png') }}" class="img-circle" width="25">
            </div>
            <div class="col-xs-10 text-right">`;
            if( output.data.substring(0,2) == "&#" ){
              text += `<span style="font-size: 25px">`+ output.data + `</span>`;
            }else{
              text += output.data;
            }
        text += `</div>
        </div>`;
    return text;
  }

  function loadUnseenchat(){
    $.ajax({
      url : '{{ url('load/unload/chat')}}',
      data : { 'user_id' : user_id},
      success : function(output){
        if(output.status){  
          // console.log(output.data);
          $('.chat-body').append(output.data);      
          if(output.data.length > 0){            
            $('.chat-body').scrollTop($('.chat-body')[0].scrollHeight);
          } 
        }else{
          clearInterval(auto_load);
          $('.chat-body').append(output.message);
          $('.chat-body').scrollTop($('.chat-body')[0].scrollHeight);          
        }               
      },
      error : function(response){
        errorMessage(getError(response));
      }
    });
  }

  $(document).on('click', '.close-chat', function(){
    clearInterval(auto_load);
    $('.chatting-window').addClass('hidden');
  });
</script>