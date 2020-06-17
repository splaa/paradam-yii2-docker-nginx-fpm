<?php
// paradam.me.loc/ActionColumn.php
	
	namespace app\components;
	
	use yii\grid\ActionColumn as AColumn;

    class ActionColumn extends AColumn
    {
        public $contentOptions = [
            'class' => 'action-column',
//			'style' => 'white-space: nowrap; text-align: center; letter-spacing: 0.1em; max-width: 7em;',
        ];
    }