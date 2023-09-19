<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Регистрация</title>
</head>

<body style="background-color: lightgrey;">
    <div class="container" style="margin-top: 230px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                        <div class="card-header">Регистрация</div>
                        <div class="card-body">
                            <form action="{{ route("register_process") }}" method="post">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Имя</label>
                                    <div class="col-md-6">
                                        <input type="text" id="name" class="form-control" name="name" required autofocus>
                                    </div>
                                </div>

                                @error('name')
                                <div class="alert alert-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </div>
                                @enderror

                                <div class="form-group row">
                                    <label for="role" class="col-md-4 col-form-label text-md-right">Вид деятельности</label>
                                    <div class="col-md-6">
                                        <select name="role" class="form-control" id="role">
                                            <option>Работодатель</option>
                                            <option>Веб-мастер</option>
                                        </select>
                                    </div>
                                  </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>
                                    <div class="col-md-6">
                                        <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                    </div>
                                </div>

                                @error('email')
                                <div class="alert alert-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </div>
                                @enderror

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>
                                    <div class="col-md-6">
                                        <input type="password" id="password" class="form-control" name="password" required>
                                    </div>
                                </div>

                                @error('password')
                                <div class="alert alert-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </div>
                                @enderror

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Подтверждение пароля</label>
                                    <div class="col-md-6">
                                        <input type="password" id="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>

                                @error('password_confirmation')
                                <div class="alert alert-danger" role="alert">
                                    <p>{{ $message }}</p>
                                </div>
                                @enderror

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember"> Запомнить меня
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">
                                        Зарегестрироваться
                                    </button>
                                    <a href="{{ route("login") }}" class="btn btn-link">
                                        Уже есть аккаунт?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>