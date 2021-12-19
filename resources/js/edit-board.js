

let fields;
let four_master;
let three_master;
let two_master;
let one_master;
let current_ship;
let nextFields = [] ;
let defaultBoxBg = '#20c997';
let highlightBoxBg = '#07faea';
let lockedBoxBg = '#b8d1bb';
let lastShip;


class Field {
    constructor(_x, _y) {
        this.x = _x;
        this.y = _y;
    }
    getX(){return this.x;}
    getXasNumber(){
        return (+this.x.charCodeAt(0)-64);
    }
    getY(){return this.y;}

    position(){
        return this.x+this.y;
    }


    inject(see){
        var X = String.fromCharCode(this.x+64);
        var Y =this.y;
        see.X.Y = "S";
    }

    markAsCompleted(field){
        $('#'+field.position()+'')
            .attr('data-status','border');
        var X = this.getXasNumber();
        var Y = this.getY();
        for(let i = -1 ; i <= 1 ; i++){
            for(let j = -1 ; j <= 1 ; j++){
                if(isFieldOnBoard(X+j,Y+i)){
                    let column = String.fromCharCode(+X+j+64);
                    let row = Y+i;
                    let fieldToSwitchOff = $('#'+column+row);
                    if(fieldToSwitchOff.attr('data-status')==='free'){
                        fieldToSwitchOff
                            .attr('data-status','border').css('background',lockedBoxBg);
                    }
                }
            }
        }


    }

    pointNeighbours(){
        let neighbours = [] ;
        //top
        if(this.getY()>1){
            neighbours.push(new Field(this.getX(), this.getY()-1));
        }
        //bottom
        if(this.getY()<10){
            neighbours.push(new Field(this.getX(), this.getY()+1));
        }
        //left
        if(this.getXasNumber()>1){
            neighbours.push(new Field(String.fromCharCode(this.getXasNumber()+63), this.getY()));
        }
        //right
        if(this.getXasNumber()<10){
            neighbours.push(new Field(String.fromCharCode(this.getXasNumber()+65), this.getY()));
        }
        return neighbours;
    }

    getStatus(){

        return $('#'+this.x+this.y).attr("data-status");
    }

    hintNeighbours(){
        let neighbours = this.pointNeighbours();
        $.each(neighbours, function(key, value){
            if(value.getStatus() === "free"){
                $('#'+value.position()).attr("data-hinted","true").css('background',highlightBoxBg);
                nextFields.push.value;
                /*value.hintField();*/
            }
        })
    }
}


class Ship {
    constructor(size, index) {
        this.size = size;
        this.index = index;
        this.fields = [];
        this.completed = false;
        var img;
        var name;
        var sequences;
        switch(size){
            case 1:
                img = 'mini-one-master.png' ;
                name = nameOneMaster;
                sequences = 'sequences-one-master.png';
                break;
            case 2:
                img = 'mini-two-master.png' ;
                name = nameTwoMaster;
                sequences = 'sequences-two-master.png';
                break;
            case 3:
                img = 'mini-three-master.png' ;
                name = nameThreeMaster;
                sequences = 'sequences-three-master.png';
                break;
            case 4:
                img = 'mini-four-master.png' ;
                name = nameFourMaster;
                sequences = 'sequences-four-master.png';
                break;
            default:
                img = 'mini-one-master.png' ;
                name = nameOneMaster;
                sequences = 'sequences-one-master.png';
        }
        this.name = name;
        this.avatar = img;
        this.sequences = sequences;
    }

    addField(field){
        if(this.fields.length < this.size) { // need to insert some validation rules
            this.fields.push(field);
            $('#'+field.position()+'')
                .html('<img id="theImg" src="'+baseUrl+'/storage/img/cross-green.png" style="width:100%; height: 100%; object-fit: cover;" />')
                .attr('data-status','ship')
                .attr('data-hinted','false')
                .css('background',defaultBoxBg);
            if(this.fields.length == this.size){
                this.setCompleted();
                this.markAsCompleted();
            }
        } else {
            console.log(__('messages.warning.ship_is_complete'));
        }
    }

    getSize(){
        return this.size;
    }

    getIndex(){
        return this.index;
    }

    getAvatar(){
        return this.avatar;
    }

    getSequences(){
        return this.sequences;
    }

    getName(){
        return this.name;
    }

    launch(see){
        $.each(this.fields, function(index, value){
            value.inject(see);
        })
    }

    setCompleted(){
        this.completed = true;
    }

    isCompleted(){
        return this.completed;
    }

    markAsCompleted(){
        $.each(this.fields,function(key,value){
            value.markAsCompleted(value);
        });
    }

    getFields(){
        return this.fields;
    }
}

function isFieldOnBoard(x, y){
    if(x<1){
        return false;
    }
    if(x>10){
        return false;
    }
    if(y<1){
        return false;
    }
    if(y>10){
        return false;
    }
    return true;
}

function clearHinted(){
    for(let col = 1 ; col <= 10 ; col++){
        for(let row = 1 ; row <= 10 ; row++){
            let column = String.fromCharCode(col+64);
            $('#'+column+row).attr("data-hinted","false");
        }
    }
}

function readBoard(board_id){
    $.ajax({
        url: baseUrl + '/board/' + board_id,
        method: "get",
    }).done(function(response){
        console.log(response);
        fields = response.fields;
    }).fail(function(response){
        console.log('fail!');
        console.log(response);
    });
}

function currentShipDraw(current_ship){
    $('#currently-creating').html('<div class="h3 center">'+current_ship.getName()+'</div><img id="theImg" src="'+baseAsset+'/'+current_ship.getAvatar()+'" style="width:100%; height: 100%; object-fit: cover;" />');
    $('#available-sequences').html('<div class="h3 center">'+availableSequences+'</div><img id="theImg" src="'+baseAsset+'/'+current_ship.getSequences()+'" style="margin-left: auto; margin-right: auto;height: 100%; object-fit: cover;" />');

}

function startPopup(){
    Swal.fire({
        title: '<strong>'+before_start+'</strong>',
        html:
            '<a href="#" class="list-group-item active">\n' +
            '    '+set_ships_in_order+':\n' +
            '  </a>' +
            '<ul class="list-group">'+
                '<li class="list-group-item justify-content-between">'+
                    ''+one_single_master+''+
                    '<span class="badge badge-default badge-pill">14</span>'+
                '</li>'+
                '<li class="list-group-item justify-content-between">'+
                    ''+two_three_masters+''+
                    '<span class="badge badge-default badge-pill">2</span>'+
                '</li>'+
                '<li class="list-group-item justify-content-between">'+
                    ''+three_two_masters+''+
                    '<span class="badge badge-default badge-pill">1</span>'+
                '</li>'+
                '<li class="list-group-item justify-content-between">'+
                    ''+four_one_masters+''+
                    '<span class="badge badge-default badge-pill">1</span>'+
                '</li>'+
            '</ul>',
        focusConfirm: false,
        confirmButtonText:
            fight,
    })
}

function pickNextShip(current_ship){
    return getShipByIndex(current_ship.getIndex()+1);
}

function getShipByIndex(index){
    switch(index){
        case 1:
            return four_master;
        case 2:
            return three_master[0];
        case 3:
            return three_master[1];
        case 4:
            return two_master[0];
        case 5:
            return two_master[1];
        case 6:
            return two_master[2];
        case 7:
            return one_master[0];
        case 8:
            return one_master[1];
        case 9:
            return one_master[2];
        case 10:
            return one_master[3];
        default:
            return null;
    }
}

$(function(){
    for(let col = 1 ; col <= 10 ; col++){
        console.log(String.fromCharCode(col+64));
    }
    startPopup();
    readBoard($('#save-board').data("id"))
    four_master = new Ship(+4,+1) ;
    three_master = [new Ship(+3,+2), new Ship(+3,+3)];
    two_master = [new Ship(+2,+4),new Ship(+2,+5),new Ship(+2,+6)];
    one_master = [new Ship(+1,+7),new Ship(+1,+8),new Ship(+1,+9),new Ship(+1,+10)];
    current_ship = four_master;
    currentShipDraw(current_ship);
    $('.tic-box').click(function(){
        var field = new Field($(this).data("x"),$(this).data("y"));
        if(current_ship.getFields().length > 0){
            if($(this).attr("data-hinted")==="true") {
                current_ship.addField(field);
                field.hintNeighbours();
            }

        } else if(field.getStatus()==="free") {
            current_ship.addField(field);
            field.hintNeighbours();
        } else {
            Swal.fire(field_unavailable);
        }
        if (current_ship.isCompleted()) {
            current_ship = pickNextShip(current_ship);
            clearHinted();
            if (current_ship) {
                currentShipDraw(current_ship);
            } else {
                Swal.fire(seems_ready);
            }
        }
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
