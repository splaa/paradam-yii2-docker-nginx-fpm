<?php


namespace app\commands;


use app\modules\message\models\Froze;
use app\modules\message\models\Message;
use app\modules\message\models\Thread;
use app\modules\user\models\Activity;
use app\modules\user\models\User;
use yii\db\StaleObjectException;
use yii\helpers\Console;

class FrozeController extends \yii\console\Controller
{
	public function actionAnalyze()
	{
		$thread_ids = [];

		$frozeData = Froze::find()->where(['status' => 0])->andWhere('created_at <= NOW() - INTERVAL ' . (int)User::MESSAGE_LIVE_TIME . ' DAY')->asArray()->all();

		if ($frozeData) {
			foreach ($frozeData as $item) {
				$message = Message::findOne($item['message_id']);

				if ($message) {
					User::transferBits($message->thread->creator_id, $message->author_id,User::TRANSFER_TYPE_TRANSFER, $item['amount']);

					$froze = Froze::findOne($item['id']);
					$froze->status = 1;
					$froze->save();

					if (!in_array($message->thread_id, $thread_ids)) {
						$thread_ids[$message->author_id] = $message->thread_id;
					}
				}
			}

			if ($thread_ids) {
				foreach ($thread_ids as $author_id => $id) {
					$thread = Thread::findOne($id);

					$activity = new Activity();
					$activity->user_id = $author_id;
					$activity->type = Activity::ACTIVITY_TYPE_REMOVE_THREAD;
					$activity->additional = json_encode([
						'text' => 'Диалог с пользователем (' . $thread->creator->username . ') удален по причине бездействия!',
					]);
					$activity->save();

					try {
						$thread->delete();
					} catch (\Throwable $e) {
						echo $this->ansiFormat($e . PHP_EOL, Console::BOLD, Console::FG_RED);
					}
				}
				echo $this->ansiFormat("Сканирование завершенно" . PHP_EOL, Console::BOLD, Console::FG_BLUE);
			}
		} else {
			echo $this->ansiFormat("Нет диалогов для удаления" . PHP_EOL, Console::BOLD, Console::FG_RED);
		}
	}
}