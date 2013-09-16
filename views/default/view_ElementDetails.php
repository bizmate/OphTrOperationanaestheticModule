<h4><?php echo $element->elementType->name ?></h4>

<div class="eventHighlight">
    <h4><?php echo CHtml::encode($element->getAttributeLabel('anaesthetist_id'))?>: <?php echo $element->anaesthetist->fullName?></h4>
    <h4><?php echo CHtml::encode($element->getAttributeLabel('comments'))?>: <?php echo $element->comments?></h4>
</div>