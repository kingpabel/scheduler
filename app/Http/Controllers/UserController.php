<?php namespace App\Http\Controllers;
use Auth;
use Request;
use Session;
use DB;
use Response;
use Redirect;
use App\Schedule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Symfony\Component\Security\Core\User\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function getIndex()
    {
        $data['monthEvent'] = Schedule::where('start_time', '>=', date('Y-m-01'))
            ->where('start_time', '<=', date('Y-m-t'))
            ->count();
        $data['menu'] = 'Dashboard';
        return view('User.dashboard', $data);
    }

    public function getEvent()
    {
        $data['menu'] = 'Event';
        $data['events'] = Schedule::all();
        return view('User.event', $data);
    }

    public  function anyCreateEvent(){
        if(Input::all()){
            $rules = array(
                'title' => 'required',
                'start' => 'required|date_format:Y-m-d H:i',
                'end' => 'required|date_format:Y-m-d H:i',
            );
            /* Laravel Validator Rules Apply */
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()):
                return $validator->messages()->first();
            else:
                if (Input::get('start') > Input::get('end'))
                    return 'Start Time Can not be Greater Than End Time';
                if (Input::get('start') == Input::get('end'))
                    return 'Start Time And End Time Can not be Same';
                $duplicate = Schedule::where('start_time', Input::get('start'))
                    ->where('end_time', Input::get('end'))
                    ->first();
                if ($duplicate) {
                    return 'A Event is Already Created in This Time';
                }
                $event = new Schedule();
                $event->title = Input::get('title');
                $event->start_time = Input::get('start');
                $event->end_time = Input::get('end');
                $event->user_id = Auth::user()->id;
                $event->save();
                Session::flash('success', 'Event Created Successfully');
                return 'true';
            endif;
        }else {
            $data['menu'] = 'Create Event';
            return view('User.createEvent', $data);
        }
    }
    public function anyPasswordChange()
    {
        if(Input::all()){
            $rules = array(
                'new_password'  => 'required|same:confirm_password|min:6',
                'current_password'  => 'required|password_check',
            );
            $messages = array(
                'new_password.same' => 'New Password and Confirm password are not Matched',
            );
            /* Laravel Validator Rules Apply */
            $validator = Validator::make(Input::all(), $rules, $messages);
            if ($validator->fails()):
                return $validator->messages()->first();
            else:
                $userUpdate = \App\User::find(Auth::user()->id);
                $userUpdate->password = Hash::make(Input::get('new_password'));
                $userUpdate->save();
                return 'true';
            endif;
        }else {
            $data['menu'] = 'Setting';
            return view('User.passwordChange', $data);
        }
    }

    public function anyUpdateInfo(){
        if(Input::all()){
            $id = Input::get('id');
            $rules = array(
                'first_name' => 'required|alpha_num_spaces',
                'last_name' => 'required',
                'email' => "required|email|unique:users,email,$id",
                'phone' => 'required|phone_number',
            );
            /* Laravel Validator Rules Apply */
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()):
                return $validator->messages()->first();
            else:
                $user = \App\User::find($id);
                $user->first_name = Input::get('first_name');
                $user->last_name = Input::get('last_name');
                $user->email = Input::get('email');
                $user->phone = Input::get('phone');
                $user->email_status = Input::get('email_status');
                $user->save();
                return 'true';
            endif;
        }else {
            $data['menu'] = 'Setting';
            return view('User.updateInfo', $data);
        }
    }


    public function anyCalenderReport()
    {
        $data['menu'] = 'Report';
        if(Input::all()){
            $rules = array(
                'start' => 'required|date_format:Y-m-d H:i',
                'end' => 'required|date_format:Y-m-d H:i',
            );
            /* Laravel Validator Rules Apply */
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()):
                $validationMessage = $validator->messages()->first();
                Session::flash('error', $validationMessage);
                return Redirect::back();
            else:
                $data['events'] = Schedule::where('start_time', '>=', Input::get('start'))
                    ->where('start_time', '<=', Input::get('end'))
                    ->get();
                if($data['events']->isEmpty()) {
                    Session::flash('error', 'No Report Found Between This Time');
                    return Redirect::back();
                }
                return view('User.event', $data);
            endif;
        }else {
            return view('User.calenderReportView', $data);
        }
    }

    public function getEventTrash()
    {
        $data['menu'] = 'Trash';
        $data['events'] = Schedule::onlyTrashed()->orderBy('id', 'desc')->get();
        return view('User.eventTrash', $data);
    }

    public function getTableEvent()
    {
        $data['menu'] = 'Table';
        $data['events'] = Schedule::orderBy('id', 'desc')->paginate(500);
        return view('User.tableEvent', $data);
    }

    public function anyTableReport()
    {
        $data['menu'] = 'Report';
        if(Input::all()){
            $rules = array(
                'start' => 'required|date_format:Y-m-d H:i',
                'end' => 'required|date_format:Y-m-d H:i',
            );
            /* Laravel Validator Rules Apply */
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()):
                $validationMessage = $validator->messages()->first();
                Session::flash('error', $validationMessage);
                return Redirect::back();
            else:
                $data['events'] = Schedule::where('start_time', '>=', Input::get('start'))
                    ->where('start_time', '<=', Input::get('end'))
                    ->get();
                if($data['events']->isEmpty()) {
                    Session::flash('error', 'No Report Found Between This Time');
                    return Redirect::back();
                }
                return view('User.tableEvent', $data);
            endif;
        }else {
            return view('User.tableReportView',$data);
        }
    }

    public function getSaveEvent()
    {
        $rules = array(
            'title' => 'required',
            'start' => 'required|date_format:Y-m-d H:i',
            'end' => 'required|date_format:Y-m-d H:i',
        );
        /* Laravel Validator Rules Apply */
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()):
            $validationMessage = $validator->messages()->first();
            $response['type'] = 'error';
            $response['data'] = $validationMessage;
            return Response::json($response);
        else:
            if (Input::get('start') > Input::get('end')) {
                $response['type'] = 'error';
                $response['data'] = 'Start Time Can not be Greater Than End Time';
                return Response::json($response);
            }
            if (Input::get('start') == Input::get('end')) {
                $response['type'] = 'error';
                $response['data'] = 'Start Time And End Time Can not be Same';
                return Response::json($response);
            }

            $duplicate = Schedule::where('start_time', Input::get('start'))
                ->where('end_time', Input::get('end'))
                ->first();
            if ($duplicate) {
                $response['type'] = 'error';
                $response['data'] = 'A Event is Already Created in This Time';
                return Response::json($response);
            }
            $event = new Schedule();
            $event->title = Input::get('title');
            $event->start_time = Input::get('start');
            $event->end_time = Input::get('end');
            $event->user_id = Auth::user()->id;
            $event->save();
        endif;
        $response['type'] = 'success';
        $response['data'] = $event->id;
        return Response::json($response);
    }

    public function getUpdateEvent()
    {
        $rules = array(
            'title' => 'required',
            'start' => 'required|date_format:Y-m-d H:i',
            'end' => 'required|date_format:Y-m-d H:i',
        );
        /* Laravel Validator Rules Apply */
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()):
            return $validator->messages()->first();
        else:
            if (Input::get('start') > Input::get('end'))
                return 'Start Time Can not be Greater Than End Time';
            if (Input::get('start') == Input::get('end'))
                return 'Start Time And End Time Can not be Same';
            $duplicate = Schedule::where('start_time', Input::get('start'))
                ->where('end_time', Input::get('end'))
                ->where('id', '!=', Input::get('id'))
                ->first();
            if ($duplicate)
                return 'A Event is Already Created in This Time';
            $event = Schedule::find(Input::get('id'));
            $event->title = Input::get('title');
            $event->start_time = Input::get('start');
            $event->end_time = Input::get('end');
            $event->save();
        endif;
        return 'true';
    }

    public function getTrashEvent()
    {
        $event = Schedule::find(Input::get('id'));
        $event->delete();
        return 'true';
    }

    public function getDeleteEvent()
    {
        Schedule::onlyTrashed()->where('id', Input::get('id'))->forceDelete();
        return 'true';
    }

    public function getRestoreEvent()
    {
        Schedule::onlyTrashed()->where('id', Input::get('id'))->restore();
        return 'true';
    }

    public function getEventAllRestore()
    {
        Schedule::onlyTrashed()->restore();
        Session::flash('success', 'All Trash Event Restored Successfully');
        return redirect('user/table-event');
    }

    public function getEventAllDelete()
    {
        Schedule::onlyTrashed()->forceDelete();
        Session::flash('success', 'All Trash Event Deleted Successfully');
        return redirect('user/table-event');
    }

    public function anyEventUpdate($id = null)
    {
        if(Input::all()){
            $rules = array(
                'title'  => 'required',
                'start'  => 'required|date_format:Y-m-d H:i',
                'end'  => 'required|date_format:Y-m-d H:i',
            );
            /* Laravel Validator Rules Apply */
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()):
                return $validator->messages()->first();
            else:
                if(Input::get('start') > Input::get('end'))
                    return 'Start Time Can not be Greater Than End Time';
                if (Input::get('start') == Input::get('end'))
                    return 'Start Time And End Time Can not be Same';
                $duplicate = Schedule::where('start_time', Input::get('start'))
                    ->where('end_time', Input::get('end'))
                    ->where('id', '!=', Input::get('id'))
                    ->first();
                if($duplicate)
                    return 'A Event is Already Created in This Time';
                $event = Schedule::find(Input::get('id'));
                $event->title = Input::get('title');
                $event->start_time = Input::get('start');
                $event->end_time = Input::get('end');
                $event->save();
                Session::flash('success', 'Event Update Successfully');
            endif;
            return 'true';
        }
        else{
            $data['event'] = Schedule::find($id);
            $data['menu'] = 'Table';
            return view('User.eventUpdate', $data);
        }
    }
}