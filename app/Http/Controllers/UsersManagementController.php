<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Traits\CaptureIpTrait;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use jeremykenedy\LaravelRoles\Models\Role;
use Validator;

class UsersManagementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginationEnabled = config('usersmanagement.enablePagination');
        if ($paginationEnabled) {
            $users = User::paginate(config('usersmanagement.paginateListSize'));
        } else {
            $users = User::all();
        }
        $roles = Role::all();

        return View('usersmanagement.show-users', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        return view('usersmanagement.create-user', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'                  => 'required|max:255|unique:users|alpha_dash',
                'first_name'            => 'alpha_dash',
                'last_name'             => 'alpha_dash',
                'email'                 => 'required|email|max:255|unique:users',
                'password'              => 'required|min:6|max:20|confirmed',
                'password_confirmation' => 'required|same:password',
                'role'                  => 'required',
            ],
            [
                'name.unique'         => trans('auth.userNameTaken'),
                'name.required'       => trans('auth.userNameRequired'),
                'first_name.required' => trans('auth.fNameRequired'),
                'last_name.required'  => trans('auth.lNameRequired'),
                'email.required'      => trans('auth.emailRequired'),
                'email.email'         => trans('auth.emailInvalid'),
                'password.required'   => trans('auth.passwordRequired'),
                'password.min'        => trans('auth.PasswordMin'),
                'password.max'        => trans('auth.PasswordMax'),
                'role.required'       => trans('auth.roleRequired'),
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $ipAddress = new CaptureIpTrait();
        $profile = new Profile();

        $user = User::create([
            'name'             => strip_tags($request->input('name')),
            'first_name'       => strip_tags($request->input('first_name')),
            'last_name'        => strip_tags($request->input('last_name')),
            'email'            => $request->input('email'),
            'password'         => Hash::make($request->input('password')),
            'token'            => str_random(64),
            'admin_ip_address' => $ipAddress->getClientIp(),
            'activated'        => 1,
        ]);

        $user->profile()->save($profile);
        $user->attachRole($request->input('role'));
        $user->save();

        return redirect('users')->with('success', trans('usersmanagement.createSuccess'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('usersmanagement.show-user', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();

        foreach ($user->roles as $userRole) {
            $currentRole = $userRole;
        }

        $data = [
            'user'        => $user,
            'roles'       => $roles,
            'currentRole' => $currentRole,
        ];

        return view('usersmanagement.edit-user')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User                     $user
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $emailCheck = ($request->input('email') !== '') && ($request->input('email') !== $user->email);
        $ipAddress = new CaptureIpTrait();

        if ($emailCheck) {
            $validator = Validator::make($request->all(), [
                'name'          => 'required|max:255|unique:users|alpha_dash',
                'email'         => 'email|max:255|unique:users',
                'first_name'    => 'alpha_dash',
                'last_name'     => 'alpha_dash',
                'password'      => 'present|confirmed|min:6',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name'          => 'required|max:255|alpha_dash|unique:users,name,'.$user->id,
                'first_name'    => 'alpha_dash',
                'last_name'     => 'alpha_dash',
                'password'      => 'nullable|confirmed|min:6',
            ]);
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->name = strip_tags($request->input('name'));
        $user->first_name = strip_tags($request->input('first_name'));
        $user->last_name = strip_tags($request->input('last_name'));

        if ($emailCheck) {
            $user->email = $request->input('email');
        }

        if ($request->input('password') !== null) {
            $user->password = Hash::make($request->input('password'));
        }

        $userRole = $request->input('role');
        if ($userRole !== null) {
            $user->detachAllRoles();
            $user->attachRole($userRole);
        }

        $user->updated_ip_address = $ipAddress->getClientIp();

        switch ($userRole) {
            case 3:
                $user->activated = 0;
                break;

            default:
                $user->activated = 1;
                break;
        }

        $user->save();

        return back()->with('success', trans('usersmanagement.updateSuccess'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::find($id);
        $user->delete();

            return redirect('users')->with('success', trans('usersmanagement.deleteSuccess'));
        

    }

    /**
     * Method to search the users.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output='';

            $query=$request->get('query');
            if($query!='')
            {

                $data=User::where('first_name','like','%'.$query.'%')->get();
            }
                
           
        
        else{
            $data=User::all();
        }
        $totalRow=$data->count();
                if($totalRow>0)
                {
                    foreach($data as $user)
                    {
                    //     $deletecell='<form method="POST" action="/users/'. $user->id .'" accept-charset="UTF-8" data-toggle="tooltip" title="Delete">
                        
                    //     <a class="remove" type="button"  data-toggle="modal" data-target="#confirmDelete" data-title="Delete User" data-message="{!! trans("usersmanagement.modals.delete_user_message") !!}">
                    //     delete
                    //     </a>
                    // </form>';
                        $output.='  
                        <tr>
                            <td>'.$user->id.'</td>
                            <td>'.$user->name.'</td>
                            <td>'.$user->email.'</td>
                            <td>'.$user->first_name.'</td>
                            <td>'.$user->last_name.'</td>
                            <td></td>
                            <td>'.$user->created_at.'</td>
                            <td>'.$user->updated_at.'</td>
                            <td><a class="btn btn-sm btn-success btn-block"href="users/'.$user->id.'">show</a></td>
                            <td><a class="btn btn-sm btn-info btn-block"href="users/'.$user->id.'/edit">edit</a></td>
                            <td><a class="btn btn-sm btn-danger btn-block delete" data-id="'.$user->id.'"href="#">delete</a>
                        </td>
                        </tr> ';
                    }
                }
                else{
                    $Output='
                    <tr>
                        <td>No Results</td>
                    </tr>
                    ';
                }

                $data = array(
                    'table_data'=>$output
                );
                echo json_encode($data);
            }
    }

}
