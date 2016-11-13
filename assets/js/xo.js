$("#size-changer").change(function() {
    location.href = "/game?size=" + $(this).val();
});

$(".game-cell").click(function() {
    $.post("/game/turn", { x : $(this).data('x'), y : $(this).data('y') }, $.proxy(function(data) {
        switch(data.status)
        {
            case 'filled':
                alert('Field is not empty!');
                break;
            case 'win':
                $(this).text('X');
                $("#game_result").text('Win!');
                $(".results").show();
                break;
            case 'lost':
                $("#game_result").text('Lost!');
                $(".results").show();
                break;
            case 'ok':
                $(this).text('X');
                if(data.ai_turn)
                {
                    $("#cell_"+data.ai_turn.x+"_"+data.ai_turn.y).text('O');
                }
                break;
        }

    }, this));
});

$("#restart_game").click(function(e) {
   location.reload();
});