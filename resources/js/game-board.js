$(function(){
    $('.single-box').click(function(){
        shot($(this));
    })

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

window.Echo.channel('game.' + tableId)
    .listen('PlayerMoved', function(response){
        console.log("Echo engaged!");
        console.log("Winner: " + response.table.winner);
        $('#log_list').append("<li>"+response.log+"</li>");
        $('#game_log').animate({
            scrollTop: $('#log_list li:last-child').offset().top-20 + 'px'
        },100);
        if(response.shot_field.result === "missed"){
            if(response.table.current_player == playerId){
                Swal.fire('Twój ruch!');
            }
        }
        updateCurrentPlayer(response.table.current_player);
        uncoverField(response.shot_field);
        if(response.table.winner != null){
            console.log("Mamy zwycięzcę: " + response.winner);
            Swal.fire(response.winner + ' wygrywa!').then((result)=>{
                if(result.isConfirmed){
                    location.reload();
                }
            });
        }
    });


window.Echo.channel('creating-table.' + tableId)
    .listen('BoardCreated',function(response){
        console.log("Board has been created!");
        Swal.fire(response.message).then(function(result){
            if(result.isConfirmed) {
                location.reload();
            }
    });
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
        /*location.reload();*/
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
/*
    var board1_id = $('#player_1').data("board-id");
    var board2_id = $('#player_2').data("board-id");*/

    $.ajax({
        url: baseUrl + '/board/' + board_id
    }).done(function(response){
        $.each(response.fields, function(key, value){
            //console.log("key: " + key);
            $.each(value, function(deeper_key, deeper_value){
                updateField(board_id,key,deeper_key,deeper_value);
                console.log("key: " + key+ ", deeper_key: " + deeper_key + ", deeper_value: " + deeper_value);
            });

        });
    }).fail(function(response){
        console.log(response.fields);
    })

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
