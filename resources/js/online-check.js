/*
window.Echo.channel('game.' + tableId)
    .listen('PlayerMoved', function(response){
        console.log('echo works');

    });
*/

$(function(){
    console.log('Online checker script loaded');
    setInterval(function(){
        $('.online-status').each(function(){
            let userId = $(this).data("id");
            console.log("Testing user with id: " + userId);
            $.ajax({
                url: baseUrl + '/user/' + userId + '/online-status'
            }).done(function(response){
                console.log("success: " + response.message);
                let status = response.color;
                /*let interval = response.interval;
                if(interval) {
                    if (interval < 10) {
                        status = 'green';
                    } else if (interval < 30) {
                        status = 'yellow';
                    } else if (interval < 45) {
                        status = 'orange';
                    }
                }*/

                $('#status-'+response.user_id).html('<img src="'+baseAsset+'/'+status+'-dot.png" style="width: 30px; height:30 px;" />');
            }).fail(function(response){
                console.log("fail: " + response);
            });

        });

    },1000*5);
});

