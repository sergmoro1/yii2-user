<?php
/* @var $this yii\web\View */
/* @var $user common\models\User */

use sergmoro1\user\Module;

$resetLink = \Yii::$app->urlManager->createAbsoluteUrl(['user/site/reset-password', 'token' => $user->password_reset_token]);
?>
<?= Module::t('core', 'Hello') ?> <?= $user->username ?>,

<?= Module::t('core', 'Follow the link below to reset your password') ?>:

<?= $resetLink ?>
