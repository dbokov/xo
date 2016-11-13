<?php

use dbokov\xo\assets\XoAsset;
XoAsset::register($this);

?>

<div class="row text-center">
    <select id="size-changer">
        <option <? if($size == 6) echo "selected"; ?> value="6">6x6</option>
        <option <? if($size == 9) echo "selected"; ?> value="9">9x9</option>
    </select>
</div>

<div class="row game-field" style="width: <?= $size * 60 ?>px;">
    <? for($x=0;$x<$size;$x++): ?>
        <div>
            <? for($y=0;$y<$size;$y++): ?>
                <div id="cell_<?= $x ?>_<?= $y ?>" data-x="<?= $x ?>" data-y="<?= $y ?>" class="col-xs-2 game-cell"></div>
            <? endfor; ?>
        </div>
    <? endfor; ?>
</div>

<div class="row results" style="margin-top:30px;">
    <div id="game_result"></div>
    <div id='restart_game' class="btn btn-info">Restart</div>
</div>