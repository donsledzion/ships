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
        if(response.shot_field.result === "missed"){
            if(response.table.current_player == playerId){
                Swal.fire('Twój ruch!');
            }
        }
        updateCurrentPlayer(response.table.current_player);
        updateField(response.shot_field);
        if(response.table.winner != null){
            console.log("Mamy zwycięzcę: " + response.winner);
            Swal.fire(response.winner + ' wygrywa!').then((result)=>{
                if(result.isConfirmed){
                    location.reload();
                }
            });
        }
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

function updateField(shot_field){

    var field = $('#'+shot_field.board+'_'+shot_field.x+'_'+shot_field.y);
    if(shot_field.result === "hit"){
        field.html('<img id="theImg" src="'+redCrossImg+'" style="width:100%; height: 100%; object-fit: cover;" />');
    } else if(shot_field.result === "missed"){
        field.html('<img id="theImg" src="'+missedImg+'" style="width:100%; height: 100%; object-fit: cover;" />');

    } else if(shot_field.result === 'sunk'){
        location.reload();
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
