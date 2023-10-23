<?php
class LoadingPages
{
	public static function view($templates, $parameters, $url = '') {
		$urlviews = ROOT.'/views/';
		$urlPage = $urlviews.$url;
		foreach($templates as $i => $_templates) {
			if($i == 0){
				if(file_exists($urlPage.$_templates.'/index.php')) { //проверяет существование указанного файла
					include($urlPage.$_templates.'/index.php'); //подключаем файл
				}else if(file_exists($urlPage.$_templates.'/index.html')) { //проверяет существование указанного файла
					include($urlPage.$_templates.'/index.html'); //подключаем файл
				}else {
					Router::ErrorPage404('Главный шаблон вида не найден'); //------------------DEBUGGING
					break; //выходим из цикла
				}
			}else {
				if(file_exists($urlPage.$templates[0].'/'.$_templates.'.php')) { //проверяет существование указанного файла
					include($urlPage.$templates[0].'/'.$_templates.'.php'); //подключаем файл
				}
				if(file_exists($urlPage.$templates[0].'/'.$_templates.'.html')) { //проверяет существование указанного файла
					include($urlPage.$templates[0].'/'.$_templates.'.html'); //подключаем файл
				}
			}
		}
	}
}
?>