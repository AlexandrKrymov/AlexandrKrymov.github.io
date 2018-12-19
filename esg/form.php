<?php
//определен метод для вывода шаблона письма
require('mail.php');
// инициализация обработчика формы
processForm();
//метод
function processForm()
{
    //обрабатываем полученные переменные.
    if ($_SERVER['REQUEST_METHOD'] == 'POST') //если это пост запрос
    {
        //цикл по переменным в форме - нужно для вывода в случае валидации формы
        $data = [];
        $error = "";
        foreach($_POST as $key => $value) {
            $value=trim($value);
            $value=htmlspecialchars($value,ENT_QUOTES);
            $_POST[$key]=$value;
            $value=str_replace("\r","",$value);
            $value=str_replace("\n","<br>",$value);
            $data[$key] = $value;
        }
//        $error = validateForm($data);
//        if(!$error){
        sendForm($data);
//        }
//        else{
//            Header("Location: ".$_SERVER['PHP_SELF']);
//        }
    }
    echo ' <div class="form-success">
    <p class="form-success__title">Ваша заявка успешно отправлена</p>
    <img class="form-success__icon" src="assets/images/form-success.png" alt="success" title="success">
    <p class="form-success__msg">Мы свяжемся с вами в близжайшее время.</p>
    <a href="#" class="btn" onclick="$(\'.js-modal-close\').click()">Понятно</a>
</div>';
}
// отправка формы на почту
function sendForm($data)
{
//    здесь указываем сколько угодно почтовых ящиков
    $email_to['0'] = 'hellogoodbye2806@gmail.com';
    $email_to ['1'] = 'alexanderkrymov@yandex.ru';
    foreach ($email_to as $key=>$value)
    {
        $headers  = "Content-type: text/html; charset=utf-8 \r\n"; //Кодировка письма
        $headers .= "From: Отправитель:".$data['email']."\r\n"; //Наименование и почта отправителя
        mail($value,'Заявка',message_mail($data,'Заявка с сайта'),$headers);
    }
}
function validateForm($data)
{
    //   валидация
    $error='';
    // валидация полей на пустоту - можно добавлять любое количество полей
    if ( (isset($data['name']) && $data['name'] != '') || (isset($data['phone']) && $data['phone'] != ''))
    {
        $error .= "Поле имя не должно быть пустым";
    }
    // проверка email на валидность
    if (isset($data['email']) && preg_match('[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$',$data['email']))
    {
        $error .= "Укажите email в формате test@gmail.com.<br>";
    };
    // проверка телефона на валидность, добавлена валидация имени, если нужен другой то можно раскомментрировать
    $patern = '7\([0-9]{3}\)[0-9]{3}-[0-9]{2}-[0-9]{2}'; // патерн для 7(___)___-__-__
//    $patern = '^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$'; // патерн для +8(___)___-__-__
    if (
        (isset($data['phone']) || isset($data['telephone'])||isset($data['phone_number'])||isset($data['telefon'])||isset($data['Телефон']))
        && (
            preg_match($patern,$data['phone']) ||
            preg_match($patern,$data['telephone']) ||
            preg_match($patern,$data['phone_number']) ||
            preg_match($patern,$data['telefon']) ||
            preg_match($patern,$data['телефон'])
        ))
    {
        $error .= "укажите номер телефона в корректном формате 7(___)___-__-__";
    };
    return $error;
}
//безопасность формы
function securityForm()
{
//    методы безопасности формы
    if (ok)
    {
        processForm();
    }
    else{
        return;
    }
}
?>
