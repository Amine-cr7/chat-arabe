@extends('app')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h2>Chat with User {{ $receiver->username }}</h2>
        <a href="/logout" class="btn btn-danger">Logout</a>
    </div>

    <div class="card">
        <div class="card-header">Chat</div>
        <div class="card-body">
            <div class="chat-box" style="height: 300px; overflow-y: scroll;">
                <div id="chat_area"></div>
            </div>
        </div>
        <div class="card-footer">
            <input type="text" id="message" name="message" class="form-control mr-2" placeholder="Type a message" required>
            <button id="send" class="btn btn-primary">Send</button>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(function() {
    console.log('Document ready');            
    Pusher.logToConsole = true;

    $("#send").click(function () {
        console.log('Send button clicked');
        $.post("/chat/{{ $receiver->id }}", {
            message: $("#message").val(),
            roomId:'{{$roomId}}',
            _token: '{{ csrf_token() }}'
        },
        function(data, status){
            console.log('Message sent:', $("#message").val());
            let senderMessage = '<div class="d-flex flex-row p-3">' +
                '<div class="chat ml-3 p-3 bg-primary text-white">' + $("#message").val() + '</div></div>';
            $("#chat_area").append(senderMessage);
            $("#message").val('');
        });
    });

    console.log('Initializing Echo');
    let receiverId = "{{ $receiver->id }}"
    window.Echo.private('privatechat.{{$roomId}}')
        .listen('.ChatSent', (event) => {
            console.log('Message received:', event.message);
            let receiverMessage = '<div class="d-flex flex-row p-3">' +
                '<div class="chat ml-3 p-3 bg-secondary text-white">' + event.message + '</div></div>';
            $("#chat_area").append(receiverMessage);
        });
});
    </script>
    @endpush
    <style>
        .chat-message {
            margin-bottom: 10px;
        }
        .chat-message strong {
            color: #007bff;
        }
    </style>
@endsection
