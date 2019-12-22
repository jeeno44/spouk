Здравствуйте, {{$user->first_name}} {{$user->last_name}} !<br />
<br />
Информируем вас о том, что для вас создан аккаунт в системе https://cont-spo.ru
<br />
<br />
Ваши данные для авторизации:<br>
e-mail: {{$user->email}}<br />
пароль: {{$password}}<br />
<br />
Для подтверждения регистрации перейдите по ссылке {!! url('activate?code='.$user->activation_code) !!}<br />
<br />---<br>
