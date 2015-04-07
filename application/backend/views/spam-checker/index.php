<?php

/**
 * @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $searchModel app\models\SpamCheckerBehavior
 */
use app\backend\components\Helper;
use app\backend\widgets\BackendWidget;
use app\backend\widgets\RemoveAllButton;
use app\models\SpamCheckerBehavior;
use kartik\dynagrid\DynaGrid;
use kartik\grid\CheckboxColumn;
use kartik\icons\Icon;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Spam Checker Settings');
$this->params['breadcrumbs'][] = $this->title;

$this->beginBlock('buttonGroup');
echo Html::a(
    Icon::show('plus') . ' ' . Yii::t('app', 'Add'),
    ['edit', 'returnUrl' => Helper::getReturnUrl()],
    ['class' => 'btn btn-success',]
);
echo RemoveAllButton::widget(
    ['url' => 'remove-all', 'gridSelector' => '.grid-view', 'htmlOptions' => ['class' => 'btn btn-danger pull-right'],]
);
$this->endBlock();

?>
<div class="config-index">
    <div class="row">
        <div class="col-md-12">
            <?=DynaGrid::widget(
                [
                    'options' => [
                        'id' => 'spam-grid',
                    ],
                    'columns' => [
                        [
                            'class' => CheckboxColumn::className(),
                            'options' => [
                                'width' => '10px',
                            ],
                        ],
                        [
                            'class' => 'yii\grid\DataColumn',
                            'attribute' => 'id',
                        ],
                        'name',
                        'behavior',
                        [
                            'class' => 'app\backend\components\ActionColumn',
                            'buttons' => [
                                [
                                    'url' => 'edit',
                                    'icon' => 'pencil',
                                    'class' => 'btn-primary',
                                    'label' => Yii::t('app', 'Edit'),

                                ],
                                [
                                    'url' => 'delete',
                                    'icon' => 'trash-o',
                                    'class' => 'btn-danger',
                                    'label' => Yii::t('app', 'Delete'),
                                ],
                            ]

                        ],
                    ],
                    'theme' => 'panel-default',
                    'gridOptions' => [
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'hover' => true,
                        'panel' => [
                            'heading' => '<h3 class="panel-title">' . $this->title . '</h3>',
                            'after' => $this->blocks['buttonGroup'],

                        ],

                    ]
                ]
            );?>
            <?php BackendWidget::begin(['title' => Yii::t('app', 'Spam Checker Settings'), 'icon' => 'list']); ?>
            <?php $form = ActiveForm::begin(['id' => 'spamchecker-form', 'type' => ActiveForm::TYPE_VERTICAL]); ?>

            <?=$form->field($searchModel, 'enabledApiId')->dropDownList(SpamCheckerBehavior::getAvailableApis());?>
            <!--Эта хрень переносится просто в конфиг и там навсегда живет или в модель надо посмотреть на реализацию и где эта штука используется-->
            <?php
            //            $form->field($model, 'configFieldsParentId')->dropDownList(
            //                //SpamChecker::getFieldTypesForForm()
            //                []
            //            )
            ?>

            <?=Html::submitButton(
                Icon::show('save') . Yii::t('app', 'Save'),
                ['class' => 'btn btn-primary']
            )?>
            <?php ActiveForm::end(); ?>
            <?php BackendWidget::end(); ?>

        </div>
    </div>
</div>