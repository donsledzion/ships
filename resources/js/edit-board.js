class Field {
    constructor(_x, _y) {
        this.x = _x;
        this.y = _y;
    }
    getX(){return this.x;}
    getY(){return this.y;}

    position(){
        return this.x+this.y;
    }

    inject(see){
        var X = String.fromCharCode(this.x+64);
        var Y =this.y;
        see.X.Y = "S";
    }
}

class Ship {
    constructor(size) {
        this.size = size;
        this.fields = [];
        var img;
        switch(size){
            case 1:
                img = 'mini-one-master.png' ;
                break;
            case 2:
                img = 'mini-two-master.png' ;
                break;
            case 3:
                img = 'mini-three-master.png' ;
                break;
            case 4:
                img = 'mini-four-master.png' ;
                break;
            default:
                img = 'mini-one-master.png' ;
        }
        this.avatar = img;

    }

    addField(field){
        if((this.fields.length < this.size)) { // need to insert some validation rules
            this.fields.push(field);
            $('#'+field.position()+'').append('<img id="theImg" src="'+baseUrl+'/storage/img/cross-green.png" style="width:100%; height: 100%; object-fit: cover;" />');
        } else {
            alert('ZIOMUŚ! Nie można już więcej pól dodać do tego statku!');
        }
    }

    getSize(){
        return this.size;
    }

    getAvatar(){
        return this.avatar;
    }

    launch(see){
        $.each(this.fields, function(index, value){
            value.inject(see);
        })
    }
}

let fields;

function readBoard(board_id){
    $.ajax({
        url: baseUrl + '/board/' + board_id,
        method: "get",
    }).done(function(response){
        console.log(response);
        console.log(response.fields.A[1]);
        fields = response.fields;
    }).fail(function(response){
        console.log('fail!');
        console.log(response);
    });
}

function currentShipDraw(current_ship){
    var ship;
    switch (current_ship.getSize()){
        case 4:
            ship = 'Czteromasztowiec';
            break;
        case 3:
            ship = 'Trzymasztowiec';
            break;
        case 2:
            ship = 'Dwumasztowiec';
            break;
        case 1:
            ship = 'Jednomasztowiec';
            break;
        default:
            ship = 'Coś się posypało';
    }
    $('#currently-creating').html('<img id="theImg" src="'+baseAsset+'/'+current_ship.getAvatar()+'" style="width:100%; height: 100%; object-fit: cover;" />');
}

function startPopup(){
    Swal.fire({
        title: '<strong>Przed rozpoczęciem rozgrywki stwórz swoją planszę</strong>',
        html:
            '<a href="#" class="list-group-item active">\n' +
            '    Ustaw na planszy swoje statki w kolejności:\n' +
            '  </a>' +
            '<ul class="list-group">'+
                '<li class="list-group-item justify-content-between">'+
                    'Jeden czteromasztowiec'+
                    '<span class="badge badge-default badge-pill">14</span>'+
                '</li>'+
                '<li class="list-group-item justify-content-between">'+
                    'Dwa trójmasztowce'+
                    '<span class="badge badge-default badge-pill">2</span>'+
                '</li>'+
                '<li class="list-group-item justify-content-between">'+
                    'Trzy dwumasztowce'+
                    '<span class="badge badge-default badge-pill">1</span>'+
                '</li>'+
                '<li class="list-group-item justify-content-between">'+
                    'Cztery jednomasztowce'+
                    '<span class="badge badge-default badge-pill">1</span>'+
                '</li>'+
            '</ul>',
        focusConfirm: false,
        confirmButtonText:
            'Do dzieła!',
    })
}


$(function(){
    startPopup();
    readBoard($('#save-board').data("id"))
    let four_master = new Ship(+4) ;
    let three_master = [new Ship(+3), new Ship(+3)];
    let two_master = [new Ship(+2),new Ship(+2),new Ship(+2)];
    let one_master = [new Ship(+1),new Ship(+1),new Ship(+1),new Ship(+1)];
    let current_ship = four_master;
    currentShipDraw(current_ship);
    //alert('script loaded!');
    $('.tic-box').click(function(){
        var field = new Field($(this).data("x"),$(this).data("y"));
        console.log('Dodawanie pola '+ field.position() + " do statku " + current_ship.getSize()+"-masztowego");
        current_ship.addField(field);
        currentShipDraw(current_ship);
    });
    $('.ship-picker').click(function(){
        var size = $(this).data("size");
        var order = $(this).data("order");
        switch (size){
            case 4:
                current_ship = four_master;
                break;
            case 3:
                current_ship = three_master[order-1];
                break;
            case 2:
                current_ship = two_master[order-1];
                break;
            case 1:
                current_ship = one_master[order-1];
                break;
            default:
                alert("Coś nie tak :/");
        }
        console.log('Wybrano statek '+size+"-masztowy nr "+ order);
    });

    $('#save-board').click(function(){
        var board_id = $(this).data("id");
        console.log("Fields to be saved:");
        console.log(fields);
        //four_master.launch(fields);
        $.each(four_master.fields, function(index,value){
            var poziomo = value.getX();
            var pionowo = value.getY();
            console.log("poziomo: "+ poziomo + ", pionowo: "+ pionowo);
            //fields.poziomo = "S";
        })
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        console.log('zapisywanie planszy nr '+board_id);
        fields.A[1] = "X";
        $.ajax({
            method: 'put',
            url: baseUrl + '/board/'+board_id,
            dataType: 'json',
            data:{
                "fields": JSON.stringify(fields),
                "four_master": JSON.stringify(four_master),
                "three_master": JSON.stringify(three_master),
                "two_master": JSON.stringify(two_master),
                "one_master": JSON.stringify(one_master),

            }
        }).done(function(response){
            console.log("Well done! " + response.message);
            console.log("Board:");
            /*console.log(response.board.fields);*/

            Swal.fire(response.message).then((result) => { if(result.isConfirmed) {
                if (response.status === 'fail') {
                    location.reload();
                }
                    window.location.replace(baseUrl + '/table/' + response.board.table.id);
                }
            });
        }).fail(function(response){
            Swal.fire(response.message).then((result) => { if(result.isConfirmed){
                location.reload();
            }});
            console.log("Shit happened! " + response.responseText.message);
        });
    });
})
