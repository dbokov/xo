<div class="game">
    <? for($i=0;$i<$size;$i++): ?>
        <div class="row">
            <? for($k=0;$k<$size;$k++): ?>
                <div class="col-xs-2 game-cell"><?= $k ?></div>
            <? endfor; ?>
        </div>
    <? endfor; ?>
</div>