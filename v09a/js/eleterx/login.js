let iden_canvas;
window.onload = function() {
	var drawingCanvas = document.getElementById('iden');
	if(drawingCanvas && drawingCanvas.getContext) {
		ctx = drawingCanvas.getContext('2d');
		ctx.beginPath();
		ctx.moveTo(75, 25);
		ctx.quadraticCurveTo(25, 25, 25, 62.5);
		ctx.quadraticCurveTo(25, 100, 50, 100);
		ctx.quadraticCurveTo(50, 120, 30, 125);
		ctx.quadraticCurveTo(60, 120, 65, 100);
		ctx.quadraticCurveTo(125, 100, 125, 62.5);
		ctx.quadraticCurveTo(125, 25, 75, 25);
		ctx.stroke();
		iden_canvas = CryptoJS.MD5(document.getElementById('iden').toDataURL()).toString();
	}
}

function login() {
	let formData = new FormData(); //создаём форму
    if (document.getElementById('login_check').checked) {
      formData.set('button', 'registration');
    } else {
      formData.set('button', 'login');
    }	
	if(localStorage.getItem('iden_canvas') && localStorage.getItem('iden_canvas').length == 32) {
		formData.set('iden_canvas', localStorage.getItem('iden_canvas'));
	}else {
		formData.set('iden_canvas', iden_canvas);
	}
	let eleterx_login = document.getElementById("login").value;
	let eleterx_password = CryptoJS.SHA256(document.getElementById("password").value);
	formData.set('login', eleterx_login);
	formData.set('password', eleterx_password);
	
	let xhr = new XMLHttpRequest(); //Создаём запрос на сервер
	xhr.open("POST", "/eleterx/login");
	xhr.timeout = 15000; //время ожидания
	xhr.send(formData);
	xhr.onload = function() { //Проверяем статус запроса
		if (xhr.status == 200) {
			document.getElementById("logo").innerText = xhr.response;
			if(xhr.response == 'Вход выполнен') {
				localStorage.setItem('eleterx_login', eleterx_login);
				localStorage.setItem('eleterx_password', eleterx_password);
				document.location.href = '/eleterx';
			}else if(xhr.response == 'Регистрация выполнена' || xhr.response == 'Вход на новом устройстве') {
				localStorage.setItem('iden_canvas', iden_canvas);
				localStorage.setItem('eleterx_login', eleterx_login);
				localStorage.setItem('eleterx_password', eleterx_password);
				document.location.href = '/eleterx';
			}else {
				login_active('#f45');
				document.getElementById("logo").innerText = xhr.response;
			}
		}
	};
	xhr.ontimeout = function() { // время ожидания запроса истекло.
		document.getElementById("logo").innerText = 'Сервер не отвечает';
	}; 		
}

function login_active(color_text) {
	let el = document.getElementById("login");
	el.style.color = color_text;
	el = document.getElementById("password");
	el.style.color = color_text;
}