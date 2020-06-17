const socket  = new WebSocket(WS_HOST);//помните про порт: он должен совпадать с тем, который использовался при запуске серверной части

window.onload = function() {
	socket.onopen = function (e) {
		//socket.send('{"idUser":{$user_id}}'); //часть моего кода. Сюда вставлять любой валидный json.
		//alert(123);
	};

	socket.onmessage = function(e) {
		// e.data - данные
		let data = JSON.parse(e.data);

		if (data.thread_id == systemData.thread_id) {
			if (data.user_id == systemData.user_id) {
				message(data, true);
			} else {
				message(data, false);
			}
		}

		$('#thread_' + data.thread_id).find('p > .text').html(data.message);

		if (data.user_id != systemData.user_id) {
			$('#thread_' + data.thread_id).find('p > .badge').html(1);
		}
	};

	socket.onclose = function(e) {
		if (e.wasClean) {
			// Соиденение закрыто
		} else {
			// Соиденение как-то закрыто
		}

		// e.code - e.reason - причина и код ошибки
	};

	socket.onerror = function (e) {
		// e.message - ошибка
	};
};
$(document).ready(function(){
	$(".msg_send_btn").on('click',function() {
		send();

		return false;
	});

	$('.write_msg').keyup(function(e) {
		if(e.keyCode === 13) {
			send();
		}
	});

	let div = $(".msg_history");
	div.scrollTop(div.prop('scrollHeight'));

	$(document).on('click', '.confirm_message', function() {
		let action = $(this).data('confirm_message');

		if (parseInt(action) === 0) {
			sendingData.cancel = 1;
		} else {
			$('.write_msg').attr('placeholder', 'Введите причину отказа');
		}

		$(this).parents('#control-information').addClass('hide');
		$('.type_msg').removeClass('hide');
	})

	// Symbols Length
	let myObject = '.write_msg'; // объект, у которого считаем символы
	let max = 300; // максимум символов
	let typeChars = '#typeChars'; // куда выводим кол-во введенных символов

	limitChars(myObject, max, typeChars);
});

function message(data, me) {
	let html = '';
	if (me) {
		html += '<div class="dialogMessage dialogMessage_me">';
			html += '<div class="dialogMessage__body">';
				html += '<div class="dialogMessage__content">';
					html += '<div class="dialogMessage__note">';
						if (data.cancel) {
							html += '<span class="service__finish reason_cancel"><b>Причина отказа:</b></span>';
						}

						html += '<div class="dialogMessage__note">';
							if (data.message && data.audio) {
								html += data.message + '<audio controls="" src="' + systemData.host + '/uploads/messages/' + data.audio + '"></audio>';
							} else if (data.audio) {
								html += '<audio controls="" src="' + systemData.host + '/uploads/messages/' + data.audio + '"></audio>';
							} else {
								html += data.message;
							}
							if (data.error) {
								html += '<span class="balance_error">' + data.error + '</span>';
							}
						html += '</div>';
					html += '</div>';
				html += '</div>';
			html += '</div>';
			html += '<div class="dialogMessage__time">' + data.time + '</div>';
		html += '</div>';
	} else {
		html += '<div class="dialogMessage">';
			html += '<div class="dialogMessage__body">';
				html += '<div class="dialogMessage__user">';
					html += '<div class="userAvatar userAvatar_size_small">';
						html += '<img src="' + data.avatar + '" alt="' +  data.alt + '">';
					html += '</div>';
				html += '</div>';
				html += '<div class="dialogMessage__content">';
					html += '<div class="dialogMessage__note">';
						if (data.cancel) {
							html += '<span class="service__finish reason_cancel"><b>Причина отказа:</b></span>';
						}
						if (data.message && data.audio) {
							html += data.message + '<audio controls="" src="' + systemData.host + '/uploads/messages/' + data.audio + '"></audio>';
						} else if (data.audio) {
							html += '<audio controls="" src="' + systemData.host + '/uploads/messages/' + data.audio + '"></audio>';
						} else {
							html += data.message;
						}
					html += '</div>';
				html += '</div>';
			html += '</div>';
			html += '<div class="dialogMessage__time">' + data.time + '</div>';
		html += '</div>';
	}

	$('.msg_history').append(html);

	$('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
}

function send() {
	sendingData.message = $('.write_msg').val();

	if (sendingData.message || sendingData.audio) {
		socket.send(JSON.stringify(sendingData));

		$('.write_msg').attr('placeholder', 'Введите сообщение');
		$('#recordingsList').html('');
		$(".write_msg").val("");

		sendingData.message = '';
		sendingData.audio = '';
		sendingData.timing = '';
		sendingData.cancel = 0;

		document.getElementById('record-control').classList.remove('active');
		document.getElementById('record-panel').classList.remove('active');
	}
}

function limitChars(myObject, max, typeChars){
	$(myObject).keyup(function(){
		var count = $(this).val().length; // кол-во уже введенных символов
		var num = max - count; // кол-во символов, которое еще можно ввести

		if(num > 0){
			// если не достигнут лимит символов
			$(typeChars).text(count);
			$(this).removeClass('type');
		}else{
			// если достигнут лимит символов
			$(typeChars).text(count);
			$(this).addClass('type');
		}
	});
}