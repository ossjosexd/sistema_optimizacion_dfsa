<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password; 
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\DB; 
use App\Mail\PasswordResetCodeMail; 

class AuthController extends Controller
{
    public function showLogin() { 
         return view('login'); 
     }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'], 
            'password' => ['required'],
        ]);

        $remember = $request->filled('remember'); 

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate(); 
            return redirect()->intended('/sistema/dashboard'); 
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function showCrearCuenta() { 
        return view('crear_cuenta'); 
    }

    public function doCrearCuenta(Request $request)
    {
         $validated = $request->validate([
             'name'      => ['required', 'string', 'max:255'],
             'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'], 
             'password'  => ['required', 'string', 'min:8', 'confirmed'], 
         ]);

         User::create([
             'name' => $validated['name'],
             'email' => $validated['email'],
             'password' => Hash::make($validated['password']), 
             'role' => 'user', 
         ]);

         return redirect()->route('login')->with('status', '¡Cuenta creada! Ya puedes iniciar sesión.');
    }

    // ----------------- Recuperar Contraseña ----------------
    public function showRecuperar()
    {
        return view('recuperar_contrasena'); 
    }

    public function sendRecoveryCode(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Generar un código numérico aleatorio de 6 dígitos
        $code = random_int(100000, 999999);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make((string)$code), 
            'created_at' => now()
        ]);

        try {
            Mail::to($request->email)->send(new PasswordResetCodeMail($code));
        } catch (\Exception $e) {
             Log::error('Error enviando correo de recuperación: '.$e->getMessage()); 
             return back()->withErrors(['email' => 'No se pudo enviar el correo. Verifica la configuración o contacta soporte.'])->withInput();
        }

        return redirect()->route('password.reset.form')->with(['status' => 'Se ha enviado un código de verificación a tu correo.', 'email' => $request->email]);
    }

     public function showResetForm(Request $request)
     {
         $email = $request->session()->get('email');
         return view('reset_password_form', ['email' => $email]);
     }

    public function doResetPassword(Request $request)
    {
        
        $request->validate([
            'email'              => 'required|email|exists:users,email',
            'code'               => 'required|numeric|digits:6',
            'password'           => 'required|string|min:8|confirmed',
        ]);

       
        $passwordReset = DB::table('password_reset_tokens')
                           ->where('email', $request->email)
                           ->first();

       
        if (!$passwordReset || !Hash::check($request->code, $passwordReset->token)) {
            return back()->withErrors(['code' => 'El código de verificación es inválido.'])->withInput();
        }

        $expiresAt = \Carbon\Carbon::parse($passwordReset->created_at)->addMinutes(config('auth.passwords.users.expire', 15));
        if (now()->greaterThan($expiresAt)) {
             DB::table('password_reset_tokens')->where('email', $request->email)->delete();
             return back()->withErrors(['code' => 'El código de verificación ha expirado. Solicita uno nuevo.'])->withInput();
        }
       
        $user = User::where('email', $request->email)->first();
       
        $user->forceFill([
            'password' => Hash::make($request->password)
        ])->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

     
        return redirect()->route('login')->with('status', '¡Tu contraseña ha sido restablecida! Ya puedes iniciar sesión.');
    }

    public function logout(Request $request)
    {
        Auth::logout();         
        $request->session()->invalidate();         
        $request->session()->regenerateToken(); 
        
        return redirect()->route('login'); 
    }
   
}