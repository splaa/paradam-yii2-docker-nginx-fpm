<?php
?>

<?php use yii\helpers\Html;
	use yii\widgets\ActiveForm;

	if (!empty($session['order'])): ?>
        <h4>Ответы на вопросы:</h4>
        <div class="table-responsive-lg">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>Вопрос</th>
                </tr>
                </thead>

                <tbody>
				<?php $form = ActiveForm::begin(); ?>
				<?php foreach ($service->questions as $item): ?>
                    <tr>
                        <td>
							<?= $item->question; ?>
                        </td>
                        <td>

							<?= $form->field($answer, 'answer') ?>
                            <div class="form-group">
								<?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                            </div>

                        </td>

                    </tr>
				<?php endforeach;; ?>
				<?php ActiveForm::end(); ?>
                </tbody>
            </table>
        </div>


	<?php else: ?>
        <h3>Пусто</h3>
	<?php endif; ?>


