<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;

<<<<<<< HEAD
class ActionKurs
{
    const MAX_RESULT = 5; // Maximum number of points received
    const MIN_VIDEO_LENGHT = 55; // Length of video

    private $userID = 0;
    private $request;
    private $currentPage;
    
    public function __construct(Request $requestC)
    {
        $this->request = $requestC;

        $this->currentPage = $this->request->session()->get('current', '');
        $this->userID = $this->request->session()->get('id', 0);
    }
    public function regUser($name)
    {
        $id = Users::insertGetId(['name' => $name, 'startTime' => time()]);
        $this->userID = $this->request->session()->put('id', $id);
        return $this->userID;
    }
    public function getUsersList()
    {
        return Users::where('endTime', '>', 0)
            ->orderBy('endTime', 'desc')
            ->take(10)
            ->get();
    }
    public function getUserID()
    {
        return $this->userID;
    }
    public function resetUser()
    {
        $this->request->session()->flush();
    }
    public function getCurrentUser()
    {
        $usersData = Users::where('id', $this->userID)->get();
        return $usersData[0];
    }
=======
class PagesController extends Controller
{
    const MAX_RESULT = 5; // Maximum number of points received
    const MIN_VIDEO_LENGHT = 55; // Length of video
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
    /**
     * Change the page to random
     * @param  integer $userID          User id
     * @param  Request $request         Request
     * @return string                   Page Name
     */
<<<<<<< HEAD
    public function getRandomPage()
=======
    private function getRandomPage($userID, Request $request)
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
    {
        $pages = ['text', 'summ', 'languages', 'days', 'video'];
        $pagesRandom = [];
        $page = 'finish';

        foreach ($pages as $p) {
<<<<<<< HEAD
            if (!$this->request->session()->get($p, false)) {
=======
            if (!$request->session()->get($p, false)) {
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
                $pagesRandom[] = $p;
            }
        }
        $count = count($pagesRandom);
        if ($count > 0) {
            $page = $pagesRandom[rand(0, $count - 1)];
<<<<<<< HEAD
            $this->request->session()->put($page, true);
        } else {
            Users::where('id', $this->userID)->update(['endTime' => time()]);
        }
        $this->request->session()->put('current', $page);
=======
            $request->session()->put($page, true);
        } else {
            Users::where('id', $userID)->update(['endTime' => time()]);
        }
        $request->session()->put('current', $page);
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
        return $page;
    }
    /**
     * Get the current page
     * @param  Request $request         Request
     * @return string                   Current page
     */
<<<<<<< HEAD
    public function getCurrentPage()
    {
        return $this->currentPage;
=======
    private function getCurrentPage(Request $request)
    {
        return $request->session()->get('current', '');
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
    }
    /**
     * Returns a page, or redirects to the current one
     * @param  string $page             Get page name
     * @param  Request $request         Request
     * @param  array [$params = null]   Array of Variables
     * @return string                   Returns a page, or redirects to the current one
     */
<<<<<<< HEAD
    public function getPage($page, $params = null)
    {
        $cp = $this->currentPage;
=======
    private function getPage($page, Request $request, $params = null)
    {
        $cp = self::getCurrentPage($request);
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
        if ($page !== $cp) {
            return redirect('/larKurs/' . $cp);
        } else {
            return ($params == null) ? view($page) : view($page, $params);
        }
<<<<<<< HEAD
=======
        getCurrentPage
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
    }
    /**
     * Will score the user
     * @param integer $userID User id
     */
<<<<<<< HEAD
    public function plusResult()
    {
        $res = Users::where('id', $this->userID)->get()[0]->result;
=======
    private function plusResult($userID)
    {
        $res = Users::where('id', $userID)->get()[0]->result;
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
        $res += 1;
        if ($res < 0) {
            $res = 0;
        }
        if ($res > self::MAX_RESULT) {
            $res = self::MAX_RESULT;
        }
<<<<<<< HEAD
        Users::where('id', $this->userID)->update(['result' => $res]);
    }
    public function pageCheck($page)
    {
        switch ($page) {
            case 'text':
                $this->plusResult();
                break;
            case 'summ': // Give a score if the sum of the numbers is correct
                $res = $this->request->session()->get('summRes');
                $resInput = $this->request->input('summ');
                if ($resInput == $res) {
                    $this->plusResult();
=======
        Users::where('id', $userID)->update(['result' => $res]);
    }
    /**
     * Processing of basic actions
     * @param  Request $request         Request
     * @param  string $page             Page name
     * @return string                   Redirect last page
     */
    public function triger(Request $request, $page)
    {
        $currentPage = self::getCurrentPage($request);
        $userID = $request->session()->get('id', 0);

        // If the user is not authorized
        if ($userID < 1) {
            return redirect('larKurs/');
        }
        // If the request is not for the current "operation"
        if ($currentPage !== $page) {
            return redirect('/larKurs/' . $currentPage);
        }

        switch ($page) {
            case 'text':
                self::plusResult($userID);
                break;
            case 'summ': // Give a score if the sum of the numbers is correct
                $res = $request->session()->get('summRes');
                $resInput = $request->input('summ');
                if ($resInput == $res) {
                    self::plusResult($userID);
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
                }
                break;
            case 'languages': // We determine which languages the user has chosen, and perform the actions we need (paragraph 4.4)
                $resInput = array();
                for ($i = 1; $i < 6; $i++) {
<<<<<<< HEAD
                    $resInput[] = $this->request->input('v' . $i);
=======
                    $resInput[] = $request->input('v' . $i);
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
                }
                $count = 0;
                $vb = false;
                foreach ($resInput as $r) {
                    if (strlen($r) > 0) {
                        $count += 1;
                    }
                    if ($r == 'vb') {
                        $vb = true;
                    }
                }
                if ($count > 0 && !$vb) {
<<<<<<< HEAD
                    $this->plusResult();
                }
                break;
            case 'days': // We are verifying the current day of the week
                $res = $this->request->session()->get('daysTrue');
                $resInput = $this->request->input('value');
                if ($resInput == $res) {
                    $this->plusResult();
                }
                break;
            case 'video': // Check the video until the end
                $startTime = $this->request->session()->get('videoStartTime');
                $resInput = $this->request->input('lenght');
                if (time() - $startTime >= $resInput && $resInput > self::MIN_VIDEO_LENGHT) {
                    $this->plusResult();
                }
                break;
        }
    }
    public function addSummData()
    {
        $dataArray = array();
        $dataArray['summC1'] = $this->request->session()->get('summC1', 0);
        $dataArray['summC2'] = $this->request->session()->get('summC2', 0);
        if ($dataArray['summC1'] < 10 || $dataArray['summC1'] > 99 || $dataArray['summC2'] < 10 || $dataArray['summC2'] > 99) {
            $dataArray['summC1'] = rand(10, 99);
            $dataArray['summC2'] = rand(10, 99);
            $this->request->session()->put('summC1', $dataArray['summC1']);
            $this->request->session()->put('summC2', $dataArray['summC2']);
            $this->request->session()->put('summRes', $dataArray['summC1'] + $dataArray['summC2']);
        }
        return $dataArray;
    }
    public function addDateData()
    {
        $daysText = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
        $days = $this->request->session()->get('daysData');
        $dayArray = $this->request->session()->get('daysTrue');
        $dayNow = date('w');
        if (!is_array($days) || $dayNow != $dayArray) {
            $days = array();
            $days[0] = $dayNow;

            // First
            if ($days[0] <= 0) {
                $days[1] = 6;
            } else {
                $days[1] = $days[0] - 1;
            }

            // Second
            if ($days[0] >= 6) {
                $days[2] = 0;
            } else {
                $days[2] = $days[0] + 1;
            }

            // The third
            if ($days[2] >= 6) {
                $days[3] = 0;
            } else {
                $days[3] = $days[2] + 1;
            }

            $this->request->session()->put('daysTrue', $dayNow);
            
            shuffle($days);
            $this->request->session()->put('daysData', $days);

        }
        return ['days' => $days, 'daysText' => $daysText];
    }
    public function addVideoData()
    {
        $this->request->session()->put('videoStartTime', time());
    }

}
class PagesController extends Controller
{
    /**
     * Processing of basic actions
     * @param  Request $request         Request
     * @param  string $page             Page name
     * @return string                   Redirect last page
     */
    public function triger(Request $request, $page)
    {
        $act = new ActionKurs($request);

        $currentPage = $act->getCurrentPage();

        // If the user is not authorized
        if ($act->getUserID() < 1) {
            return redirect('larKurs/');
        }
        // If the request is not for the current "operation"
        if ($currentPage !== $page) {
            return redirect('/larKurs/' . $currentPage);
        }
        $act->pageCheck($page);
        
        return redirect('/larKurs/' . $act->getRandomPage());
=======
                    self::plusResult($userID);
                }
                break;
            case 'days': // We are verifying the current day of the week
                $res = $request->session()->get('daysTrue');
                $resInput = $request->input('value');
                if ($resInput == $res) {
                    self::plusResult($userID);
                }
                break;
            case 'video': // Check the video until the end
                $startTime = $request->session()->get('videoStartTime');
                $resInput = $request->input('lenght');
                if (time() - $startTime >= $resInput && $resInput > self::MIN_VIDEO_LENGHT) {
                    self::plusResult($userID);
                }
                break;
        }
        return redirect('/larKurs/' . self::getRandomPage($userID, $request));
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
    }
    /**
     * We register for the passage of the "course"
     * @param  Request $request         Request
     * @return string                   Redirect page
     */
    public function trigerReg(Request $request)
    {
<<<<<<< HEAD
        $act = new ActionKurs($request);

        $userID = $act->getUserID();

=======
        $userID = $request->session()->get('id', 0);
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
        // We register the user
        if ($userID < 1) {
            $this->validate($request, [
                'name' => 'alpha_dash|min:2|max:40'
            ]);
            $name = $request->input('name');
            if (empty($name)) {
                // No name entered
                return redirect('/larKurs/');
            }
<<<<<<< HEAD
            $act->regUser($name);
            // Registered, now start the course
            return redirect('/larKurs/' . $act->getRandomPage());
        }
        // User is already registered, redirected to the last page
        return redirect('/larKurs/' . $act->getCurrentPage());
=======
            $id = Users::insertGetId(['name' => $name, 'startTime' => time()]);
            $userID = $request->session()->put('id', $id);
            // Registered, now start the course
            return redirect('/larKurs/' . self::getRandomPage($userID, $request));
        }
        // User is already registered, redirected to the last page
        return redirect('/larKurs/' . self::getCurrentPage($request));
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
    }
    /**
     * Controller page "start"
     * @param  Request $request         Request
     * @return string                   Page "start" and redirect to current page
     */
    public function start(Request $request)
    {
<<<<<<< HEAD
        $act = new ActionKurs($request);

        $list = $act->getUsersList();
        $cp = $act->getCurrentPage($request);
=======
        $list = Users::where('endTime', '>', 0)
            ->orderBy('endTime', 'desc')
            ->take(10)
            ->get();
        $cp = self::getCurrentPage($request);
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
        if ($cp != '') {
            return redirect('/larKurs/' . $cp);
        }
        return view('start', compact('list'));
    }
    /**
     * Controller page "text"
     * @param  Request $request         Request
     * @return string                   Page "text" and redirect to current page
     */
    public function text(Request $request)
    {
<<<<<<< HEAD
        $act = new ActionKurs($request);
        return $act->getPage('text');
=======
        return self::getPage('text', $request);
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
    }
    /**
     * Controller page "summ"
     * @param  Request $request         Request
     * @return string                   Page "summ" and redirect to current page
     */
    public function summ(Request $request)
    {
<<<<<<< HEAD
        $act = new ActionKurs($request);

        $dataArray = $act->addSummData();

        return $act->getPage('summ', $dataArray);
=======
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
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
    }
    /**
     * Controller page "languages"
     * @param  Request $request         Request
     * @return string                   Page "languages" and redirect to current page
     */
    public function languages(Request $request)
    {
<<<<<<< HEAD
        $act = new ActionKurs($request);

        return $act->getPage('languages');
=======
        return self::getPage('languages', $request);
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
    }
    /**
     * Controller page "days"
     * @param  Request $request         Request
     * @return string                   Page "days" and redirect to current page
     */
    public function days(Request $request)
    {
<<<<<<< HEAD
        $act = new ActionKurs($request);

        $d = $act->addDateData();
        $days = $d['days'];
        $daysText = $d['daysText'];
        
        return $act->getPage('days', compact('days', 'daysText'));
=======
        $daysText = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
        $days = $request->session()->get('daysData');
        $dayArray = $request->session()->get('daysTrue');
        $dayNow = date('w');
        if (!is_array($days) || $dayNow != $dayArray) {
            $days = array();
            $days[0] = $dayNow;

            // First
            if ($days[0] <= 0) {
                $days[1] = 6;
            } else {
                $days[1] = $days[0] - 1;
            }

            // Second
            if ($days[0] >= 6) {
                $days[2] = 0;
            } else {
                $days[2] = $days[0] + 1;
            }

            // The third
            if ($days[2] >= 6) {
                $days[3] = 0;
            } else {
                $days[3] = $days[2] + 1;
            }

            $request->session()->put('daysTrue', $dayNow);
            
            shuffle($days);
            $request->session()->put('daysData', $days);
        }
        return self::getPage('days', $request, compact('days', 'daysText'));
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
    }
    /**
     * Controller page "video"
     * @param  Request $request         Request
     * @return string                   Page "video" and redirect to current page
     */
    public function video(Request $request)
    {
<<<<<<< HEAD
        $act = new ActionKurs($request);

        $act->addVideoData();
        return $act->getPage('video');
=======
        $request->session()->put('videoStartTime', time());
        return self::getPage('video', $request);
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
    }
    /**
     * Controller page "finish"
     * @param  Request $request         Request
     * @return string                   Page "finish" and redirect to current page
     */
    public function finish(Request $request)
    {
<<<<<<< HEAD
        $act = new ActionKurs($request);

        $userID = $act->getUserID();
        if ($userID > 0) {
            $userData = $act->getCurrentUser();
            return $act->getPage('finish', compact('userData'));
        } else {
            return $act->getPage('finish');
=======
        $userID = $request->session()->get('id', 0);
        if ($userID > 0) {
            $usersData = Users::where('id', $userID)->get();
            $userData = $usersData[0];
            return self::getPage('finish', $request, compact('userData'));
        } else {
            return self::getPage('finish', $request);
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
        }
    }
    /**
     * Restart Kurs
     * @param  Request $request         Request
     * @return string                   Redirect start page
     */
    public function restart(Request $request)
    {
<<<<<<< HEAD
        $act = new ActionKurs($request);

        $act->resetUser();
=======
        $request->session()->flush();
>>>>>>> a6ad60745b6b8371efbc74ee6b520a66499e573d
        return redirect('/larKurs');
    }
}
