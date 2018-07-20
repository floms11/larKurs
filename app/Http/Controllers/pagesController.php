<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;

class PagesController extends Controller
{
    const MAX_RESULT = 5; // Максимальное количество полученых балов
    const MIN_VIDEO_LENGHT = 55; // Длина видео (примерно 95% от длины, что бы засчитать просмотр)

    // Получаем(и "устанавливаем") рандомную след. страницу
    private function getRandomPage($userID, Request $request)
    {
        $pages = ['text', 'summ', 'languages', 'days', 'video'];
        $pagesRandom = [];
        $page = 'finish';

        foreach ($pages as $p) {
            if (!$request->session()->get($p, false)) {
                $pagesRandom[] = $p;
            }
        }
        $count = count($pagesRandom);
        if ($count > 0) {
            $page = $pagesRandom[rand(0, $count - 1)];
            $request->session()->put($page, true);
        }
        else {
            Users::where('id', $userID)->update(['endTime' => time()]);
        }

        $request->session()->put('current', $page);
        return $page;
    }
    // Получить текущую страницу
    private function getCurrentPage(Request $request)
    {
        return $request->session()->get('current', '');
    }
    // Возвращает страницу, либо редирект на текущую
    private function getPage($page, Request $request, $params = null)
    {
        $cp = self::getCurrentPage($request);
        if ($page !== $cp)
            return redirect('/larKurs/' . $cp);
        else
            return ($params == null) ? view($page) : view($page, $params);
    }
    // Плюсует балл пользователю
    private function plusResult($userID)
    {
        $res = Users::where('id', $userID)->get()[0]->result;
        $res += 1;
        if ($res < 0)
            $res = 0;
        if ($res > self::MAX_RESULT)
            $res = self::MAX_RESULT;

        Users::where('id', $userID)->update(['result' => $res]);
    }












    // Обработка всех действий
    public function triger(Request $request, $page)
    {
        $currentPage = self::getCurrentPage($request);
        $userID = $request->session()->get('id', 0);

        // Если пользователь не авторизирован
        if ($userID < 1)
            return redirect('larKurs/');
        // Если запрос не к текущей "операции"
        if ($currentPage !== $page)
            return redirect('/larKurs/' . $currentPage);

        switch ($page) {
            case 'text': // В любом случаи даем один балл
                self::plusResult($userID);
                break;
            case 'summ': // Даем балл, если сумма чисел правильная
                $res = $request->session()->get('summRes');
                $resInput = $request->input('summ');
                if ($resInput == $res)
                    self::plusResult($userID);
                break;
            case 'languages': // Опеределяем какие языки пользователь выбрал, и выполняем нужные нам действия (параграф 4.4)
                $resInput = array();
                for ($i = 1; $i < 6; $i++)
                    $resInput[] = $request->input('v' . $i);  
                $count = 0;
                $vb = false;
                foreach($resInput as $r) {
                    if (strlen($r) > 0)
                        $count += 1;
                    if ($r == 'vb')
                        $vb = true;
                }
                if ($count > 0 && !$vb)
                    self::plusResult($userID);
                break;
            case 'days': // Сверяем текщий день недели
                $res = $request->session()->get('daysTrue');
                $resInput = $request->input('value');
                if ($resInput == $res)
                    self::plusResult($userID);
                break;
            case 'video': // Проверяем просмотр видео до конца
                $startTime = $request->session()->get('videoStartTime');
                $resInput = $request->input('lenght');
                if (time() - $startTime >= $resInput && $resInput > self::MIN_VIDEO_LENGHT)
                    self::plusResult($userID);
                break;
        }
        return redirect('/larKurs/' . self::getRandomPage($userID, $request));
    }
    // Регистрируем на прохождения "курса"
    public function trigerReg(Request $request)
    {
        $userID = $request->session()->get('id', 0);

        // Регистрируем пользователя
        if ($userID < 1) {
            $this->validate($request, [
                'name' => 'alpha_dash|min:2|max:40'
            ]);
            $name = $request->input('name');
            if (empty($name)) {
                // Имя не введено
                return redirect('/larKurs/');
            }
            $id = Users::insertGetId(['name' => $name, 'startTime' => time()]);
            $userID = $request->session()->put('id', $id);

            // Зарегистрировали, теперь начинаем курс
            return redirect('/larKurs/' . self::getRandomPage($userID, $request));
        }
        // Пользователь уже зарегистрирован, перенаправляем на последнюю страницу
        return redirect('/larKurs/' . self::getCurrentPage($request));
    }














    public function start(Request $request)
    {
        $list = Users::where('endTime', '>', 0)
            ->orderBy('endTime', 'desc')
            ->take(10)
            ->get();
        $cp = self::getCurrentPage($request);
        if ($cp != '')
            return redirect('/larKurs/' . $cp);
        return view('start', compact('list'));
    }
    public function text(Request $request)
    {
        return self::getPage('text', $request);
    }
    public function summ(Request $request)
    {
        $dataArray = array();
        $dataArray['summC1'] = $request->session()->get('summC1', 0);
        $dataArray['summC2'] = $request->session()->get('summC2', 0);
        if ($dataArray['summC1'] < 10 || $dataArray['summC1'] > 99 || $dataArray['summC2'] < 10 || $dataArray['summC2'] > 99) {
            $dataArray['summC1'] = rand(10, 99);
            $dataArray['summC2'] = rand(10, 99);
            
            $request->session()->put('summC1', $dataArray['summC1']);
            $request->session()->put('summC2', $dataArray['summC2']);
            $request->session()->put('summRes', $dataArray['summC1'] + $dataArray['summC2']);
            
        }
        return self::getPage('summ', $request, $dataArray);
    }
    public function languages(Request $request)
    {
        return self::getPage('languages', $request);
    }
    public function days(Request $request)
    {
        $daysText = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
        $days = $request->session()->get('daysData');
        $dayArray = $request->session()->get('daysTrue');
        $dayNow = date('w');
        
        if (!is_array($days) || $dayNow != $dayArray) {
            $days = array();
            $days[0] = $dayNow;

            // Первый
            if ($days[0] <= 0)
                $days[1] = 6;
            else
                $days[1] = $days[0] - 1;

            // Второй
            if ($days[0] >= 6)
                $days[2] = 0;
            else
                $days[2] = $days[0] + 1;

            // Третий
            if ($days[2] >= 6)
                $days[3] = 0;
            else
                $days[3] = $days[2] + 1;

            $request->session()->put('daysTrue', $dayNow);
            
            shuffle($days);
            $request->session()->put('daysData', $days);
        }

        return self::getPage('days', $request, compact('days', 'daysText'));
    }
    public function video(Request $request)
    {
        $request->session()->put('videoStartTime', time());
        return self::getPage('video', $request);
    }
    public function finish(Request $request)
    {
        $userID = $request->session()->get('id', 0);
        if ($userID > 0) {
            $usersData = Users::where('id', $userID)->get();
            $userData = $usersData[0];
            return self::getPage('finish', $request, compact('userData'));
        }
        else {
            return self::getPage('finish', $request);
        }
    }
    public function restart(Request $request)
    {
        $request->session()->flush();
        return redirect('/larKurs');
    }
}
