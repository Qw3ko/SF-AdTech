<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view("auth.login");
    }

    public function showRegisterForm()
    {
        return view("auth.register");
    }

    public function logout()
    {
        auth("web")->logout();

        return redirect(route("/"));
    }

    public function register(Request $request)
    {

        $data = $request->validate([
            "name" => ["required", "string"],
            "email" => ["required", "email", "string", "unique:users,email"],
            "password" => ["required", "confirmed"],
        ]);

        if (!(new RoleController)->isRoleExist($request["role"])) {

            Role::create([
                'name' => $request["role"],
                'guard_name' => 'api',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        }

        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => bcrypt($data["password"])
        ]);

        $user->assignRole($request["role"]);

        if (auth()->id() === 1) {
            return redirect(route("home"));
        }

        if ($user) {
            auth("web")->login($user);
        }

        return redirect(route("home"));
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            "email" => ["required", "email", "string"],
            "password" => ["required"]
        ]);

        if(DB::table('users')->where('email', '=', $data["email"])->value('active') == 0) {
            return redirect(route("login"))->withErrors(["email" => "Вы были отключены администратором и не можете войти"]);
        }

        if(auth("web")->attempt($data)) {
            return redirect(route("home"));
        }

        return redirect(route("login"))->withErrors(["email" => "Пользователь не найден либо введенные данные неправильные"]);
    }
}
