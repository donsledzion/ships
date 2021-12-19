$(function(){
    $('.single-box').click(function(){
        shot($(this));
    })


    $('.chat-send').click(function(){
        sendChatMessage();
    });

    $('.player').click(function(){
        var targetURL = baseUrl + '/board/' + $(this).data("board-id");
        console.log('BaseUrl: '+targetURL);
        $.ajax({
            url: targetURL,
            method: "get",
        }).done(function(response){
            console.log(response);
            console.log(response.fields.A[1]);
        }).fail(function(response){
            console.log('fail!');
            console.log(response);
        });
    })
})

var message_input = $('#chat-input-text');
var message_button = $('.chat-send');
message_input.bind("keyup", function(event){
    if(event.key === 'Enter'){
        event.preventDefault();
        message_button.click();
    }
});

window.Echo.channel('game.' + tableId)
    .listen('PlayerMoved', function(response){
        console.log("Echo engaged!");
        $('#log-list').append("<li>"+response.log+"</li>");
        $('#game-log').animate({
            scrollTop: $('#log-list li:last-child').offset().top + 'px'
        },100);

        updateCurrentPlayer(response.table.current_player);
        uncoverField(response.shot_field);
        if(response.table.winner != null){
            $('#log-list').append("<li>Wygrywa "+response.winner+"</li>");
            $('#game-log').animate({
                scrollTop: $('#log-list li:last-child').offset().top + 'px'
            },100);
            Swal.fire(response.winner + ' '+alert_winner).then((result)=>{
                if(result.isConfirmed){
                    location.reload();
                }
            });
        }
    });


window.Echo.channel('creating-table.' + tableId)
    .listen('BoardCreated',function(response){
        Swal.fire(response.message).then(function(result){
            if(result.isConfirmed) {
                location.reload();
            }
    });
});

window.Echo.channel('game.' + tableId + '.chat')
    .listen('ChatMessage',function(response){
        $('#chat-log').append("<li><b>" + response.author + "</b>: " + response.message + "</li>");
        $('#chat-box').animate({
            scrollTop: $('#chat-log li:last-child').offset().top-20 + 'px'
        },100);
    });

function updateCurrentPlayer(currentPlayer){

    var player_1 = $('#player_1');
    var player_2 = $('#player_2');
    if(player_1.data("id")===currentPlayer){
        player_1.attr("class","current-player");
        player_2.attr("class","");
    } else {
        player_2.attr("class","current-player");
        player_1.attr("class","");
    }
}

function uncoverField(shot_field){

    var field = $('#'+shot_field.board+'_'+shot_field.x+'_'+shot_field.y);
    if(shot_field.result === "hit"){
        field.html('<img id="theImg" src="'+redCrossImg+'" style="width:100%; height: 100%; object-fit: cover;" />');
    } else if(shot_field.result === "missed"){
        field.html('<img id="theImg" src="'+missedImg+'" style="width:100%; height: 100%; object-fit: cover;" />');

    } else if(shot_field.result === 'sunk'){
        updateBoard(shot_field.board);
    }
}

function updateField(board, column, row, value){
    let field = $('#'+board+"_"+column+"_"+row);

    if(value === "#"){
        field.html('<img id="theImg" src="'+redCrossImg+'" style="width:100%; height: 100%; object-fit: cover;" />');
    } else if(value === "*"){
        field.html('<img id="theImg" src="'+missedImg+'" style="width:100%; height: 100%; object-fit: cover;" />');
    }
}

function updateBoard(board_id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: baseUrl + '/board/' + board_id
    }).done(function(response){
        $.each(response.fields, function(key, value){
            $.each(value, function(deeper_key, deeper_value){
                updateField(board_id,key,deeper_key,deeper_value);
            });
        });
    }).fail(function(response){
        console.log(response);
    })

}

function sendChatMessage(){

    let input_field = $('#chat-input-text');
    let message =input_field.val();
    input_field.val('');
    if(message !== ''){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: baseUrl + '/table/' + tableId + '/chat',
            method: 'post',
            data:{
                message: message,
            }
        }).done(function(response){
            console.log(response.message);
        }).fail(function(response){
            console.log(response);
        });
    } else {
        console.log(warning_enter_message);
    }
}

function shot(field){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var board = field.data("board_id");
    var column = field.data("x");
    var row = field.data("y");
    $.ajax({
        url: baseUrl + '/board/' + board + "/shot/" + column + "/" + row,
        method: "post",
    }).done(function(response){
        Swal.fire(response.message);
    }).fail(function(response){
        Swal.fire(response.message);
    });
}
