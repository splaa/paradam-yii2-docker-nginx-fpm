<?php
namespace app\commands;
use app\components\Time;
use app\modules\message\models\Froze;
use app\modules\message\models\Message;
use app\modules\message\models\Thread;
use app\modules\message\models\UserMessage;
use app\modules\message\models\UserThread;
use app\modules\services\models\OrderService;
use app\modules\user\models\User;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Yii;

class SocketServer implements MessageComponentInterface
{
	protected $clients;

	public function __construct() {
		$this->clients = new \SplObjectStorage;
	}

	public function onOpen(ConnectionInterface $conn) {
		// Store the new connection to send messages to later
		$this->clients->attach($conn);

		echo "New connection! ({$conn->resourceId})\n";
	}

	public function onMessage(ConnectionInterface $from, $msg) {
		$numRecv = count($this->clients) - 1;
		echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
			, $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

		$this->saveMessageToDB($msg);

		$parse = json_decode($msg, true);

		if (isset($parse['error'])) {
			$from->send($msg);
		} else {
			foreach ($this->clients as $client) {
				//if ($from !== $client) {
					// The sender is not the receiver, send to each client connected
					$client->send($msg);
				//}
			}
		}
	}

	public function onClose(ConnectionInterface $conn) {
		// The connection is closed, remove it, as we can no longer send it messages
		$this->clients->detach($conn);

		echo "Connection {$conn->resourceId} has disconnected\n";
	}

	public function onError(ConnectionInterface $conn, \Exception $e) {
		echo "An error has occurred: {$e->getMessage()}\n";

		$conn->close();
	}

	private function saveMessageToDB(&$data) {
		$parse = json_decode($data, true);

		if ((!empty($parse['message']) || !empty($parse['audio'])) && !empty($parse['user_id']) && !empty($parse['thread_id'])) {
			$recipient = UserThread::find()
						->alias('ut')
						->leftJoin('thread as t', 'ut.thread_id = t.id')
						->where(['ut.thread_id' => $parse['thread_id']])
						->andWhere(['<>', 'ut.user_id', $parse['user_id']])
						->asArray()
						->one();

			if ($recipient) {
				$recipient_id = $recipient['user_id'];

				if (!empty($recipient['creator_id'])) {
					$recipient_id = $recipient['creator_id'];
				}

				if (User::validateSendMessage($parse['user_id'], $recipient_id, 0)) {
					$message = new Message();
					$message->author_id = $parse['user_id'];
					$message->thread_id = $parse['thread_id'];
					$message->text = $parse['message'];
					$message->audio = $parse['audio'];
					$message->cancel = $parse['cancel'];
					$message->save();

					$user_message = new UserMessage();
					$user_message->user_id = $parse['user_id'];
					$user_message->message_id = $message->id;
					$user_message->save();

					$factor = 0;

					$thread = Thread::findOne($recipient['thread_id']);
					$thread->updated_at = date("Y-m-d H:i:s");
					$thread->save();

					// Minus from balance
					if ($thread->creator_id != $parse['user_id']) {
						if (!empty($parse['audio']) && !empty($parse['message'])) {
							$timing = $parse['timing'] ?? 0;
							if ($timing) {
								$factor += ceil((int)$timing / 30);
							}

							if (mb_strlen($parse['message'], 'UTF-8') > User::MESSAGE_LENGTH) {
								$factor += count(User::strSplitUnicode($parse['message'], User::MESSAGE_LENGTH));
							}
						} elseif (!empty($parse['audio'])) {
							$timing = $parse['timing'] ?? 0;
							if ($timing) {
								$factor = ceil((int)$timing / 30);
							}
						} else {
							if (mb_strlen($parse['message'], 'UTF-8') > User::MESSAGE_LENGTH) {
								$factor = count(User::strSplitUnicode($parse['message'], User::MESSAGE_LENGTH));
							}
						}
						
						if (!$factor)
							$factor = 1;

						User::transferBits($parse['user_id'], $recipient_id, User::TRANSFER_TYPE_SMS_FROZE, 0, $factor, false, $message->id, $thread->id);
					} elseif (Froze::find()->where(['thread_id' => $thread->id])->andWhere(['status' => 0])->count()) {
						User::transferBits($recipient_id, $parse['user_id'], User::TRANSFER_TYPE_SMS, 0, 1, true, $message->id, $thread->id);
					}
				} else {
					$parse['error'] = 'На счету не достаточно средств пожалуйста пополните Ваш баланс.';
				}

				$parse['time'] = Time::showDate(date('Y-m-d H:i:s'));
				$parse['date'] = Time::showDate(date('Y-m-d H:i:s'));
			}

			$data = json_encode($parse);
		}
	}
}