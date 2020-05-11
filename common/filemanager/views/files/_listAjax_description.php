<?php
/**
 * @var $selected;
 * @var $data;
 * @var $relation_name;
 */
$selected_classes = "";
$unselected_classes = "";
?>
<div class="col-sm-4 col-md-3 filemanager-data filemanager-list-item" data-file-id="<?=$model->id?>" data-file-title="<?=$model->title?>" data-file-description="<?=$model->description?>" data-file-url-icon="<?=$model->src('icon')?>" data-file-url-small="<?=$model->src('small')?>" data-file-url-low="<?=$model->src('low')?>" data-file-url-normal="<?=$model->src('normal')?>" data-file-type="<?=$model->type?>">
    <div class="thumbnail">
        <div style="height:160px; width:100%; background-image: url(<?=$model->getImageSrc()?>); background-repeat: no-repeat;background-size: contain; background-position: center; background-color:black;">

        </div>
        <div class="row col-md-12 col-xs-12 col-sm-12 col-lg-12" style="position: absolute;left:0px;">
            <?php
            if($model->isVideo){
                $sizes = $model->converterStatus;
                foreach ($sizes as $size=>$per){
                    if($per == 100){
                        echo "<span class='label label-success'>";
                        echo $size;
                        echo "</span>";
                    }
                    else{
                        echo "<span class='label label-danger'>";
                        echo $size.":".$per;
                        echo "</span>";
                    }
                }
            }
            ?>
        </div>
        <div class="caption">

            <h5 style="text-overflow: ellipsis;width: 100%;overflow-x: hidden;white-space: nowrap;"><?=$model->title?></h5>
            <p style="text-overflow: ellipsis;width: 100%;overflow-x: hidden;white-space: nowrap;"><?=empty($model->description) ? "не задано" : $model->description?></p>
            <!--            <p><a href="#" class="btn btn-danger btn-sm filemanagerDeleteBtn" data-file-id="<?=$model->id?>">Удалить</a>
                <?php if(!in_array($model->id,$selected)):?>
                    <?php $unselected_classes = "display:none;";?>
                <?php else:?>
                    <?php $selected_classes = "display:none;";?>
                <?php endif;?>
                <a href="#" class="btn btn-success btn-sm filemanagerSelectBtn" style="<?=$selected_classes?>" data-file-id="<?=$model->id?>" data-file-title="<?=$model->title?>" data-file-url="<?=$model->src?>" data-file-type="<?=$model->type?>">Выбрать</a>
                <a href="#" class="btn btn-warning btn-sm filemanagerunSelectBtn" style="<?=$unselected_classes?>" data-file-id="<?=$model->id?>" data-file-title="<?=$model->title?>"  data-file-url="<?=$model->src?>" data-file-type="<?=$model->type?>">Отменить</a></p> -->

        </div>
    </div>
</div>
