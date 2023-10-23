var Chat;
function message(text) { //Часики при отправлении
	let message = "<div id='waiting' title='отправляется' class='recipient'><span><p class='message'>" + text + "</p><p class='time'>&#9203; </p></span></div>";
	let h3 = document.querySelectorAll("#messages h3")[document.querySelectorAll("#messages h3").length - 1];
	let date_msg = new Date();
	const monthsList2 = ["января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря"];
	date_msg = date_msg.getDate() + ' ' + monthsList2[date_msg.getMonth()];
	if(h3 != undefined) {
		if(h3.innerText != date_msg) {
			document.getElementById('messages').insertAdjacentHTML('beforeend', '<h3>'+date_msg+'</h3>');
		}
	}else {
		document.getElementById('messages').insertAdjacentHTML('beforeend', '<h3>'+date_msg+'</h3>');
	}
	document.getElementById('messages').insertAdjacentHTML('beforeend', message);
}
function sendingform(button, param = '') { //функция отправки формы
	
	let formData = new FormData(); //создаём форму
	let xhr = new XMLHttpRequest(); //Создаём запрос на сервер
	formData.set('eleterx_login', localStorage.getItem('eleterx_login'));
	formData.set('eleterx_password', localStorage.getItem('eleterx_password'));
	formData.set('iden_canvas', localStorage.getItem('iden_canvas'));
	let message_text = document.getElementById('textarea').innerText;
	
	if(button == 'send') { //при нажатии кнопки отправить
		//Наполняем поля формы
		formData.set('message', message_text);
		formData.set('login_recipient', Chat);
		formData.set('send', 'send_message');
		message(message_text);
		xhr.open("POST", "/eleterx");
	}
	if(button == 'load_messages') { //при загрузке чата
		//Наполняем поля формы
		formData.set('Chat', Chat);
		formData.set('load_messages', 'load_messages');
		xhr.open("POST", "/eleterx");
	}
	if(button == 'newDevice') { //при смене устройства
		if(confirm('Сменить устройство?')) {
			formData.set('newDevice', 'newDevice');
			xhr.open("POST", "/eleterx/login");
		}else return;
	}
	if(button == 'delAccount') { //при удалении аккаунта
		if(confirm('Точно удалить аккаунт?')) {
			formData.set('delAccount', 'delAccount');
			xhr.open("POST", "/eleterx/login");
		}else return;
	}
	if(button == 'search') { //при нажатии кнопки поиск
		//Наполняем поля формы
		formData.set('search_chat', document.getElementById('search').value);
		formData.set('search', 'search');
		xhr.open("POST", "/eleterx/login");
	}
	if(button == 'addChat') { //при добавлении чата
		//Наполняем поля формы
		formData.set('add_chat', document.getElementById('search').value);
		formData.set('addChat', 'addChat');
		xhr.open("POST", "/eleterx/login");
	}
	if(button == 'file_avatar') { //при добавлении аватарки
		//Наполняем поля формы
		formData.set('file_image', param);
		formData.set('file_avatar', 'file_avatar');
		xhr.open("POST", "/eleterx/login");
	}
	if(button == 'del_chat') { //удаление чата
		if(confirm('Точно удалить чат?')) {
			//Наполняем поля формы
			formData.set('Chat', Chat);
			formData.set('del_chat', 'del_chat');
			xhr.open("POST", "/eleterx");
		}else {
			return;
		}
	}
	xhr.timeout = 15000; //время ожидания
	xhr.send(formData);
	//Проверяем статус запроса
	xhr.onload = function() {
	  if (xhr.status != 200) { // анализируем HTTP-статус ответа, если статус не 200, то произошла ошибка
		alert(`Ошибка ${xhr.status}: ${xhr.statusText}`); // Например, 404: Not Found
	  } else { // если всё прошло гладко, выводим результат
		//alert(xhr.response);
		if(/Ошибка/.test(xhr.response)) {
			alert(xhr.response);
			return;
		}
		if(/arr/.test(xhr.response)) { //если ответ является массивом
			let chat_data = JSON.parse(xhr.response.slice(3)); //обрезаем в начале arr
			//console.log(chat_data);
			document.querySelectorAll(".login_").forEach((login) => { //ставим логин
			  login.innerText = Chat;
			})
			document.querySelectorAll(".time_").forEach((time) => { //ставим время последнего присутствия
			  time.innerText = 'был в сети: ' + date_messages(chat_data['user_presence'], true);
			})
			if(chat_data['user_avatar']) { //если есть аватарка то добавляем
				document.querySelectorAll('.chat_' + Chat + ' .avatar').forEach((chat) => {
				  chat.style.background = "url('" + chat_data['user_avatar'] + "') no-repeat";
				  chat.style.backgroundSize = 'cover';
				})
				document.querySelectorAll('.info .avatar').forEach((chat) => {
				  chat.style.background = "url('" + chat_data['user_avatar'] + "') no-repeat";
				  chat.style.backgroundSize = 'cover';
				})
			}else {
				document.querySelectorAll('.info .avatar').forEach((chat) => { //если нет аватарки то ставим по умолчанию
				  chat.style.background = "url('/icons/eleterx/profile.jpeg') no-repeat";
				  chat.style.backgroundSize = 'cover';
				})
			}
			if(chat_data['messages'].length != 0) { //если есть сообщения
				let date_first = date_messages(chat_data['messages'][0]['date']);//дата первого сообщения
				let messages = document.getElementById('messages');
				let msg;
				let date_current;
				messages.innerHTML = '<h3>' + date_first + '</h3>'; 
				chat_data['messages'].forEach((message) => {
					date_current = date_messages(message['date']); //дата текущего сообщения
					if(date_first != date_current) { //если дата текущего сообщения другая
						messages.insertAdjacentHTML('beforeend', '<h3>'+date_current+'</h3>');
						date_first = date_current;
					}
					if(message['login_sender'] == localStorage.getItem('eleterx_login')) { //если сообщение получаем
						msg = "<div id='"+message['id']+"' title='"+date_current+"' class='sender'><span><p class='message'>"+message['message']+"</p><p class='time'>"+message['date'].slice(11, 16)+"</p></span></div>";
					}
					if(message['login_sender'] == Chat) { //если сообщение отправляем
						msg = "<div id='"+message['id']+"' title='"+date_current+"' class='recipient'><span><p class='message'>"+message['message']+"</p><p class='time'>"+message['date'].slice(11, 16)+" ";
						if(message['status'] == 1) { //если сообщение ещё не просмотрено
							msg = msg + "<i class='check'></i>";
						}
						if(message['status'] == 2) { //если сообщение уже просмотрено
							msg = msg + "<i class='check'></i><i class='check check2'></i>";
						}
						msg = msg + "</p></span></div>";
					}
					messages.insertAdjacentHTML("beforeend", msg);
				})
			}else {
				document.getElementById('messages').innerHTML = '';
			}
		}
		if(xhr.response == document.getElementById('search').value) {
			if(confirm('Добавить пользователя?')) {
				sendingform('addChat');
			}
		}
		if(xhr.response == 'Чат удалён') {
			return document.location.href = '/eleterx';
		}
		if(xhr.response == 'чат добавлен') {
			return document.location.href = '/eleterx';
		}
		if(xhr.response == 'Устройство обновлено' || xhr.response == 'Аккаунт удалён') {
			localStorage.removeItem('iden_canvas');
			localStorage.removeItem('eleterx_login');
			localStorage.removeItem('eleterx_password');
			return document.location.href = '/eleterx/login';
		}
		if(xhr.response == 'Аватар установлен') {
			document.querySelectorAll('.avatar img').forEach((img) => {
			img.src = param;})
			return;
		}
		if(/^[0-9]*\//.test(xhr.response)) { //если сообщение добавлено в базу
			document.getElementById('textarea').innerText = ''; //очищаем поле ввода
			let delivery = xhr.response.split('/'); //массив из id и даты
			let el = document.querySelector("#waiting .time"); //получаем элемент time
			el.innerText = delivery[1].slice(-8, -3); //вставляем время сообщения
			el.insertAdjacentHTML('beforeend', " <i class='check'></i>"); //добавляем галочку доставлено
			document.getElementById('waiting').title = delivery[1].slice(0, 10); //ставим дату в title сообщения
			document.getElementById('waiting').id = delivery[0]; //ставим id сообщения
		}
	  }
	};
	xhr.ontimeout = function() {
		// время ожидания запроса истекло.
		alert('Сервер не отвечает');
	}; 
}

//определяем активна вкладка или нет
document.addEventListener('visibilitychange', function(e) {
  console.log('hidden:' + document.hidden,
              'state:' + document.visibilityState)
}, false);

function theme(theme_name) {  //Выбор темы
	if(theme_name == 'edit') {
		return document.location.href = '/eleterx/edit';
	}
	localStorage.setItem('theme_name', theme_name);
	document.location.href = '/eleterx';
}

function exitAccount() { //Выход из аккаунта
	if(confirm('Выйти из аккаунта?')) {
		localStorage.removeItem('eleterx_login');
		localStorage.removeItem('eleterx_password');
		document.location.href = '/eleterx/login';
	}
}

function info() { //О программе
	alert('EleterX: v0.9a (10.2023)\nВерсия для тестировщиков.\nПредложения и вопросы писать в чат eleterx');
}

function chat_active(chat = 'chat_' + Chat) { //функция активации чата
	Chat = chat.slice(5);
	document.querySelectorAll(".chat_").forEach((chat_) => { //убираем активность со всех чатов
	  chat_.classList.remove("active");
	})
	document.querySelectorAll("." + chat).forEach((chat_) => { //ставим активность на выбраный чат
	  chat_.classList.add('active');
	})
	document.querySelectorAll(".login_").forEach((login) => { //ставим часики на логин
	  login.innerHTML = '&#9203;';
	})
	sendingform('load_messages');
}

function date_messages(date, presence = false) { //функция перевода даты на русский язык
	const monthsList = {
	  "01" : "января",
	  "02" : "февраля",
	  "03" : "марта",
	  "04" : "апреля",
	  "05" : "мая",
	  "06" : "июня",
	  "07" : "июля",
	  "08" : "августа",
	  "09" : "сентября",
	  "10" : "октября",
	  "11" : "ноября",
	  "12" : "декабря"
	};
	if(presence) {
		var now = new Date();
		if(date.slice(0, 4) != now.getFullYear()) return 'давно'
		now = now.getFullYear() + '-' + (now.getMonth() + 1) + '-' + now.getDate();
		if(date.slice(0, 10) == now) {
			return date.slice(11, 16); //возвращаем время
		}else return date.slice(8, 10) + ' ' + monthsList[date.slice(5, 7)]; //возвращаем дату
	}else {
		return date.slice(8, 10) + ' ' + monthsList[date.slice(5, 7)]; //возвращаем дату
	}
}

document.getElementById('file_avatar').addEventListener('change', function() { //сработает при выборе файла аватара
	if (this.files && this.files[0]) {
		if(this.files[0]['type'].slice(0, 5) != 'image') return alert('Не картинка');
		if(this.files[0]['size'] > 10000) return alert('Не более 10kb');
		var reader = new FileReader();
		reader.readAsDataURL(this.files[0]);
		reader.onloadend = function () { //сработает при загрузке файла
			sendingform('file_avatar', reader.result);
		};
	}
});
