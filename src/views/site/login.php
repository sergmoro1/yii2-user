<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

use sergmoro1\user\Module;

$this->title = Module::t('core', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-6">

        <p>
            <?php echo Module::t('core', 'This page is for registered users. If it\'s not about you, you can go through a simple') . 
                Html::a(Module::t('core', 'registration'), ['site/signup']); ?>.
        </p>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{beginWrapper}{label}{input}{hint}{error}{endWrapper}",
                'horizontalCssClasses' => [
                    'label' => '',
                    'offset' => '',
                    'wrapper' => 'col-xs-12 floating-label-form-group controls',
                    'error' => '',
                    'hint' => '',
                ],
            ],
        ]);?>
            <?= $form->errorSummary($model); ?>

            <?= $form->field($model, 'username')
                ->textInput(['placeholder' => true])
                ->label()
            ?>

            <?= $form->field($model, 'password')
                ->passwordInput(['placeholder' => true])
                ->label()
            ?>
            
            <?= $form->field($model, 'rememberMe')->checkBox(); ?>
            
            <p>
                <?= Module::t('core', 'If you forgot your password you can') . ' ' .
                    Html::a(Module::t('core', 'reset it'), ['site/request-password-reset']); ?>.
            </p>
            <p>
                <?= Html::submitButton(Module::t('core', 'Login'), [
                    'class'=>'btn btn-default',
                    'name' => 'login-button',
                ]); ?>    
            </p>

        <?php ActiveForm::end(); ?>

    </div> <!-- / .col ... -->
</div> <!-- / .row -->
