<?php

namespace app\commands;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class SocketController extends  \yii\console\Controller
{
	public function actionStartSocket($port=9505)
	{
		$server = IoServer::factory(
			new HttpServer(
				new WsServer(
					new SocketServer()
				)
			),
			$port
		);
		$server->run();
	}
}