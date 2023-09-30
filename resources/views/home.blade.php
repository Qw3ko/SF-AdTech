<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>SF-AdTech</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('storage') . '/favicon.svg' }}" width="30" height="30" class="d-inline-block align-top" alt="">
            SF-AdTech
        </a>
        @auth("web")
        <ul class="navbar-nav ml-auto">
          <span class="navbar-text" style="margin-right: 15px;">
            @role('Работодатель')
            @foreach ($current_balance as $balance)
            Баланс: {{$balance->balance}} рублей
            @endforeach
            <button style="margin-left: 15px;" type="button" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalCenter">
              Пополнить
            </button>
            @endrole
            @role('Веб-мастер')
            @foreach ($current_balance as $balance)
            Баланс: {{$balance->balance}} рублей
            @endforeach
            @endrole
          </span>
            <li class="nav-item">
              <a class="nav-link" href="{{ route("logout") }}">Выйти</a>
            </li>
        </ul>
        @endauth
        </div>
    </nav>

    @role('Работодатель')

<div class="container">
  <br>
  <h2>Мои офферы</h2>
  <br>
  <button type="button" class="btn btn-primary" style="margin-bottom: 30px;" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Создать оффер</button>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Новый оффер</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ route("create_offer") }}" method="post">
                @csrf
                <div class="form-group">
                  <label for="offer-name" class="col-form-label">Имя оффера:</label>
                  <input type="text" class="form-control" id="offer-name" name="offer-name" required autofocus>
                </div>

                @error('offer-name')
                <div class="alert alert-danger" role="alert">
                    <p>{{ $message }}</p>
                </div>
                @enderror

                <div class="form-group">
                  <label for="transition-cost" class="col-form-label">Стоимость перехода:</label>
                  <input type="text" class="form-control" id="transition-cost" name="transition-cost" required>
                </div>

                @error('transition-cost')
                <div class="alert alert-danger" role="alert">
                    <p>{{ $message }}</p>
                </div>
                @enderror

                <div class="form-group">
                    <label for="target-url" class="col-form-label">Целевой URL:</label>
                    <input type="text" class="form-control" id="target-url" name="target-url" required>
                </div>

                @error('target-url')
                <div class="alert alert-danger" role="alert">
                    <p>{{ $message }}</p>
                </div>
                @enderror

                  <div class="form-group">
                    <label for="site-theme" class="col-form-label">Тема сайта:</label>
                    <input type="text" class="form-control" id="site-theme" name="site-theme" required>
                  </div>
                </div>

                @error('site-theme')
                <div class="alert alert-danger" role="alert">
                    <p>{{ $message }}</p>
                </div>
                @enderror

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Создать оффер</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Пополнение баланса</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route("top_up_balance") }}" method="post">
          @csrf
          <div class="form-group">
            <label for="offer-name" class="col-form-label">Сумма пополнения:</label>
            <input type="text" class="form-control" id="balance" name="balance" required autofocus>
          </div>
          @error('balance')
          <div class="alert alert-danger" role="alert">
            <p>{{ $message }}</p>
          </div>
          @enderror
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
          <button type="submit" class="btn btn-primary">Пополнить</button>
        </form>
      </div>
    </div>
  </div>
</div>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Имя оффера</th>
      <th scope="col">Стоимость перехода за клик (в руб.)</th>
      <th scope="col">Целевой URL</th>
      <th scope="col">Темы сайта</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    @foreach ($offers as $offer)
    @if ($offer->employer_id === auth()->id())
    <tr>
      <form action="{{ route("disable_offer") }}" method="post">
        @csrf
        <th scope="row"><input type="hidden" name="id" value="{{ $offer->id }}"/>{{ ++$i }}</th>
        <td>{{ $offer->name }}</td>
        <td>{{ $offer->transition_cost }}</td>
        <td>{{ $offer->target_url }}</td>
        <td>{{ $offer->site_theme }}</td>
        @if ($offer->active === 1)
        <td><button type="submit" class="btn btn-primary">Выключить</button></td>
        @else
        <td><button type="submit" class="btn btn-primary">Включить</button></td>
        @endif
      </form>
    </tr>
    @endif
    @endforeach
  </tbody>
</table>
<br>
<h2>Статистика</h2>
<br>
<table class="table">
  <thead>
      <tr>
          <th scope="col">#</th>
          <th scope="col">Имя оффера</th>
          <th scope="col">Количество подписанных веб-мастеров</th>
          <th scope="col">Количество переходов</th>
      </tr>
  </thead>
  <tbody>
      @foreach ($offers as $offer)
      @if ($offer->employer_id === auth()->id())
      <tr>
          <th scope="row"><input type="hidden" name="id" value="{{ $offer->id }}"/>{{ ++$e }}</th>
          <td>{{ $offer->name }}</td>
          <td>{{ $offer->number_of_subscribers }}</td>
          <td>{{ $offer->number_of_transitions }}</td>
      </tr>
      @endif
      @endforeach
  </tbody>
</table>
</div>
</div>
@endrole

@role('Веб-мастер')
<div class="container" style="margin-top: 50px;">
  <h2>Доступные офферы</h2>
  <br>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Имя оффера</th>
        <th scope="col">Стоимость перехода за клик (в руб.)</th>
        <th scope="col">Тема сайта</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($offers as $offer)
      @if (!DB::table('offers_of_user')->where([['user_id', '=', auth()->id()],['offer_id', '=', $offer->id],])->exists())
      <tr>
        <form action="{{ route("signUpOffer") }}" method="post">
          @csrf
          <th scope="row"><input type="hidden" name="id" value="{{ $offer->id }}"/>{{ ++$i }}</th>
          <td>{{ $offer->name }}</td>
          <td>{{ $offer->transition_cost }}</td>
          <td>{{ $offer->site_theme }}</td>
          <td><button type="submit" class="btn btn-primary">Подписаться</button></td>
        </form>
      </tr>
      @endif
      @endforeach
    </tbody>
  </table>
  <br>
  <h2>Подписанные офферы</h2>
  <br>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Имя оффера</th>
        <th scope="col">Стоимость перехода за клик (в руб.)</th>
        <th scope="col">Ссылка</th>
        <th scope="col">Тема сайта</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($offers_of_webmasters as $sub_offer)
      @if ($sub_offer->user_id === auth()->id())
      @foreach ($offers as $offer)
      @if ($offer->id === $sub_offer->offer_id)
      <tr>
        <form action="{{ route("signUpOffer") }}" method="post">
          @csrf
          <th scope="row"><input type="hidden" name="id" value="{{ $offer->id }}"/>{{ ++$e }}</th>
          <td>{{ $offer->name }}</td>
          <td>{{ $offer->transition_cost }}</td>
          <td><a href="{{ route("redirect", [$offer->id]) }}">{{ $offer->target_url }}</a></td>
          <td>{{ $offer->site_theme }}</td>
          <td><button type="submit" class="btn btn-primary">Отписаться</button></td>
        </form>
      </tr>
      @endif
      @endforeach
      @endif
      @endforeach
    </tbody>
  </table>
</div>
@endrole
@role('Админ')
<div class="container">
  <br>
  <h2>Меню пользователей</h2>
  <br>
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Создать пользователя</button>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Создать пользователя</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route("register_process") }}" method="post">
            @csrf
            <div class="form-group">
              <label for="name" class="col-form-label">Имя:</label>
              <input type="text" class="form-control" id="name" name="name" required autofocus>
            </div>
            <div class="form-group">
              <label for="role" class="col-form-label">Вид деятельности:</label>
              <select name="role" class="form-control" id="role">
                <option>Работодатель</option>
                <option>Веб-мастер</option>
            </select>
            </div>
            <div class="form-group">
              <label for="email" class="col-form-label">E-Mail:</label>
              <input type="text" class="form-control" id="email" name="email" required autofocus>
            </div>
            <div class="form-group">
              <label for="password" class="col-form-label">Пароль:</label>
              <input type="password" class="form-control" id="password" name="password" required autofocus>
            </div>
            <div class="form-group">
              <label for="password_confirmation" class="col-form-label">Подтверждение пароля:</label>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autofocus>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            <button type="submit" class="btn btn-primary">Создать</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <br>
  <table class="table">
    <br>
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Имя</th>
        <th scope="col">E-Mail</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
      <tr>
        <form action="{{ route("disable_user") }}" method="post">
          @csrf
          <th scope="row"><input type="hidden" name="id" value="{{ $user->id }}"/>{{ ++$e }}</th>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          @if ($user->id !== 1)
          @if ($user->active === 1)
          <td><button type="submit" class="btn btn-primary">Отключить</button></td>
          @else
          <td><button type="submit" class="btn btn-primary">Включить</button></td>
          @endif
          @endif
        </form>
      </tr>
      @endforeach
    </tbody>
  </table>
  <br>
  <h2>Статистика</h2>
  <br>
  <table class="table">
    <thead>
        <tr>
            <th scope="col">Доход системы</th>
            <th scope="col">Количество выданных ссылок</th>
            <th scope="col">Количество переходов</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($current_balance as $balance)
        <tr>
            <td>{{ $balance->balance }}</td>
            <td>{{ $sum_urls }}</td>
            <td>{{ $sum_transitions }}</td>
        </tr>
        @endforeach
    </tbody>
  </table>
</div>
@endrole
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
