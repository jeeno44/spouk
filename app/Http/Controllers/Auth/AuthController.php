<?php

namespace App\Http\Controllers\Auth;

use App\Models\College;
use App\Models\Role;
use App\Models\SmsCode;
use App\Models\User;
use Blackgremlin\Sms\SmsSender;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */

    protected $username = 'email';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function redirectPath()
    {
        return '/';
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'region_id' => 'required',
            'city_id'   => 'required',
            'phone' => 'required|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        $credentials = $this->getCredentials($request);
        $credentials['activated'] = 1;
        if (\Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'), false)) {
            $user = User::where('email', $request->get('email'))->first();
            if ($user) {
                //$user->sms_token = str_random(100);
                //$user->save();
                if (!empty($user->college)) {
                    \Auth::login($user);
                    \Event::fire('logs.auth.login', 'Успешная авторизация');
                    if ($user->hasRole('admin')) {
                        return redirect('/admin');
                    }
                    if ($user->college->systems->count() == 1) {
                        if ($user->college->systems->first()->id == 1) {
                            return redirect('http://spo.'.config('app.domain'));
                        }
                        if ($user->college->systems->first()->id == 2) {
                            return redirect('http://vo.'.config('app.domain'));
                        }
                    } else {
                        return redirect('sub-system');
                    }
                    return redirect('/')->withCookie('educationSystemId', \Cookie::get('educationSystemId', 1));
                }
                //\Session::set('sms_token', $user->sms_token);
                #return redirect('auth/two-step');
            }
        }
        return $this->sendFailedLoginResponse($request);
    }
    
    public function getTwoStep()
    {
        $sender = new SmsSender();
        $token = \Session::get('sms_token');
        if ($token) {
            $user = User::where('sms_token', $token)->first();
            if ($user) {
                $lastSms = SmsCode::where('user_id', $user->id)->orderBy('id', 'desc')->first();
                if (!$lastSms || (strtotime($lastSms->created_at) + 300) < time()) {
                    $code = str_random(8);
                    $sms = new SmsCode();
                    $sms->user_id = $user->id;
                    $sms->code = $code;
                    $sms->save();
                    $sender->send($code, $sms->user_id);
                } else {
                    $sms = $lastSms;
                }
                return view('auth.two-step', compact('sms'));
            }
        }
        return redirect('login')->withErrors(['Время сессии истекло, пожалуйста авторизуйтезь заново']);
    }
    
    public function postTwoStep(Request $request)
    {
        $token = \Session::get('sms_token');
        if ($token) {
            $user = User::where('sms_token', $token)->first();
            if ($user) {
                $lastSms = SmsCode::where('user_id', $user->id)->orderBy('id', 'desc')->first();
                if (!$lastSms || (strtotime($lastSms->created_at) + 300) < time()) {
                    return redirect('auth/two-step')->withErrors(['Время сессии истекло, пожалуйста авторизуйтезь заново']);
                }
                if ($lastSms->code == $request->get('code')) {
                    \Auth::login($user);
                    $lastSms->delete();
                    \Event::fire('logs.auth.login', 'Успешная авторизация');
                    return redirect('/');
                }
                return redirect('auth/two-step')->withErrors(['code' => 'Неверный код из смс']);
            }
        }
        return redirect('login')->withErrors(['Время сессии истекло, пожалуйста авторизуйтезь заново']);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        if (!empty($data['new_college'])) {
            $college = $this->makeCollege($data);
        } elseif (!empty($data['college_id'])) {
            $college = College::find($data['college_id']);
            if (!$college) {
                return redirect()->back()->withInput()->withErrors(['Указанного учебного заведения не существует']);
            }
            $role = Role::find(5);
            $users = $role->users()->where('college_id', $college->id)->count();
            if ($users > 0) {
                return redirect()->back()->withInput()->withErrors(['У вас нет прав для регистрации в этом учебнов заведении']);
            }
        } else {
            return redirect()->back()->withInput()->withErrors(['Укажите учебное заведение']);
        }
        return User::create([
            'email'         => $data['email'],
            'password'      => bcrypt($data['password']),
            'phone'         => $data['phone'],
            'college_id'    => $college->id,
            'first_name'    => !empty($data['first_name']) ? $data['first_name'] : '',
            'last_name'     => !empty($data['last_name']) ? $data['last_name'] : '',
            'middle_name'   => !empty($data['middle_name']) ? $data['middle_name'] : '',
        ]);
    }

    function makeCollege(array $data)
    {
        $college = new College();
        $college->title = $data['coll'];
        $college->region_id = $data['region_id'];
        $college->city_id = $data['city_id'];
        $college->phone = $data['college_phone'];
        $college->address = $data['college_address'];
        $college->save();
        if (!empty($data['sub_systems'])) {
            foreach ($data['sub_systems'] as $system) {
                $college->systems()->attach($system);
            }
        } else {
            $college->systems()->attach(1);
        }
        \File::makeDirectory(base_path('docs/college_'.$college->id));
        return $college;
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $password = $request->get('password');
        $data = $request->all();
        if (!empty($data['new_college'])) {
            $oldCollege = College::where('title', $request->get('coll'))->where('city_id', $request->get('city_id'))->first();
            if (!$oldCollege) {
                $college = $this->makeCollege($data);
            } else {
                return redirect()->back()->withInput()->withErrors(['college' => 'Учебное заведение с таким названием уже зарегистрирован в системе']);
            }
        } elseif (!empty($data['college_id'])) {
            $college = College::find($data['college_id']);
            if (!$college) {
                return redirect()->back()->withInput()->withErrors(['college' => 'Указанного учебного заведения не существует']);
            }
            $role = Role::find(5);
            $users = $role->users()->where('college_id', $college->id)->count();
            if ($users > 0) {
                return redirect()->back()->withInput()->withErrors(['college' => 'У вас нет прав для регистрации в этом учебном заведении']);
            }
        } else {
            return redirect()->back()->withInput()->withErrors(['college' => 'Укажите учебное заведение']);
        }

        $user =  User::create([
            'email'         => $data['email'],
            'password'      => bcrypt($data['password']),
            'phone'         => $data['phone'],
            'college_id'    => $college->id,
            'first_name'    => !empty($data['first_name']) ? $data['first_name'] : '',
            'last_name'     => !empty($data['last_name']) ? $data['last_name'] : '',
            'middle_name'   => !empty($data['middle_name']) ? $data['middle_name'] : '',
        ]);

        $user->sms_token = str_random(100);
        $user->activation_code = str_random(32);
        $user->save();
        $user->roles()->attach(5); // 5 роль директора коллежда

        \Session::set('sms_token', $user->sms_token);

        \Mail::send('auth.emails.activate', compact('user', 'password'), function($message) use ($user) {
            $message->to($user->email)->subject('Благодарим вас за регистрацию в системе cont-spo.ru');
        });
        \Session::set('email', $user->email);
        return redirect('registered');
    }

    public function registered()
    {
        return view('auth.registered');
    }

    public function activate(Request $request)
    {
        $code = $request->get('code');
        $status = 'error';
        if (!empty($code)) {
            $user = User::where('activation_code', $code)->where('activated', 0)->first();
            if ($user) {
                $user->activated = 1;
                $user->save();
                $status = 'success';
            }
        }
        return view('auth.activate', compact('status'));
    }
}
