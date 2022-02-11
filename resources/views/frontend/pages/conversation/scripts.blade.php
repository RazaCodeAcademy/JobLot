{{-- <script src='https://production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script><script src='https://code.jquery.com/jquery-2.2.4.min.js'></script> --}}

<script >
    $("#profile-img").click(function() {
        $("#status-options").toggleClass("active");
    });

    $(".expand-button").click(function() {
    $("#profile").toggleClass("expanded");
        $("#contacts").toggleClass("expanded");
    });

    $("#status-options ul li").click(function() {
        $("#profile-img").removeClass();
        $("#status-online").removeClass("active");
        $("#status-away").removeClass("active");
        $("#status-busy").removeClass("active");
        $("#status-offline").removeClass("active");
        $(this).addClass("active");
        
        if($("#status-online").hasClass("active")) {
            $("#profile-img").addClass("online");
        } else if ($("#status-away").hasClass("active")) {
            $("#profile-img").addClass("away");
        } else if ($("#status-busy").hasClass("active")) {
            $("#profile-img").addClass("busy");
        } else if ($("#status-offline").hasClass("active")) {
            $("#profile-img").addClass("offline");
        } else {
            $("#profile-img").removeClass();
        };
        
        $("#status-options").removeClass("active");
    });

    $('.submit').click(function() {
        sendMessage();
    });

    $(window).on('keydown', function(e) {
        if (e.which == 13) {
            sendMessage();
            return false;
        }
    });

    // send message here
    function sendMessage(){
        var message = $(".message-input input").val();
        var participant_id = 2;
        appendMessage();
        $.ajax({
            type:'POST',
            url:"{{ route('api.sendMessage') }}",
            data:{
                _token: $('meta[name="csrf-token"]').attr('content'),
                message: message,
                participant_id: participant_id,
            },
            success:function(response){
                appendMessage(response.users);
            }
        })
    }

    // append new message bottom of the field.
    function appendMessage() {
        message = $(".message-input input").val();
        if($.trim(message) == '') {
            return false;
        }
        $('<li class="sent"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
        $('.message-input input').val(null);
        $('.contact.active .preview').html('<span>You: </span>' + message);
        scrollBottom();
    };

    // search users here.
    function searchUser(){
        let search = $('#search_contacts').val();
        $.ajax({
            type:'POST',
            url:"{{ route('api.searchUser') }}",
            data:{
                _token: $('meta[name="csrf-token"]').attr('content'),
                search: search,
            },
            success:function(response){
                showUserList(response.users);
            }
        });
    }

    // users list
    function showUserList(users){
        var html = ``;
        if(users.length > 0 && users != undefined){
            html = `<ul>`;
                users.forEach(user => {
                    html += `<li class="contact active">
                        <div class="wrap">
                            <span class="contact-status busy"></span>
                            <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="">
                            <div class="meta">
                                <p class="name">${user.first_name} ${user.last_name}</p>
                                <p class="preview">Wrong. You take the gun, or you pull out a bigger one. Or, you call their bluff. Or, you do any one of a hundred and forty six other things.</p>
                            </div>
                        </div>
                    </li>`
                });
            html += `</ul>`;
            $('#contacts').html(html);

        }
    }

    // get conversation list here
    function getConversationList(){
        $.ajax({
            type:'GET',
            url:"{{ route('api.getConversationList') }}",
            success:function(response){
                showConversationList(response.conversations);
            }
        });
    }

    // users list
    function showConversationList(conversations){
        var html = ``;
        if(conversations.length > 0 && conversations != undefined){
            html = `<ul>`;
                conversations.forEach(conversation => {
                    html += `<li class="contact" id="conversation_${conversation.id}" onclick="openConversationChat(${conversation.id})">
                        <div class="wrap">
                            <span class="contact-status busy"></span>
                            <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="">
                            <div class="meta">
                                <p class="name">${conversation.recipient.first_name} ${conversation.recipient.last_name}</p>
                                <p class="preview">${conversation.message.text}</p>
                            </div>
                        </div>
                    </li>`
                });
            html += `</ul>`;
            $('#contacts').html(html);

        }
    }

    // open conversation chat
    function openConversationChat(conversationId){
        $(`#conversation_${conversationId}`).addClass('active');
        $.ajax({
            type: 'GET',
            url: "{{ route('api.getConversationChat') }}",
            data:{
                conversationId: conversationId,
            },
            success:function(response){
                showConversationMessages(response.messages)
            },
        });
    }

    // show conversation messages
    function showConversationMessages(messages){
        var html =``;
        if(messages.length > 0 && messages != undefined){
            html = `<ul id="scrollMessages">`
            messages.forEach((message)=>{
                if(message.user_id == "{{ Auth::Id() }}"){
                    html += `
                        <li class="sent">
                            <img src="http://emilcarlsson.se/assets/mikeross.png" alt="" />
                            <p>${message.text}</p>
                        </li>`
                }else{
                    html += `
                        <li class="replies">
                            <img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
                            <p>${message.text}</p>
                        </li>`
                }
            });
            html +=`</ul>`

            $('#messages').html(html);
        }else{
            $('#messages').html('');
        }

        scrollBottom();
    }

    function scrollBottom(){
        var messageWrapper = document.querySelector('#scrollMessages');
        var messageCollection = messageWrapper.children;
        var message = messageCollection[messageCollection.length - 1];
        message.scrollIntoView({
            behavior: "smooth", 
            block: "start", 
        });
    }

    //# sourceURL=pen.js
</script>