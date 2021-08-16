<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserAccount;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserProfile;
use App\Models\Profile;
use App\Models\Theme;
use App\Models\User;
use App\Notifications\SendGoodbyeEmail;
use App\Traits\CaptureIpTrait;
use File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Image;
use jeremykenedy\Uuid\Uuid;
use Validator;
use View;
use Auth;
use PDF;

class ProfilesController extends Controller
{
    protected $idMultiKey = '618423'; //int
    protected $seperationKey = '****';

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
     * Fetch user
     * (You can extract this to repository method).
     *
     * @param $username
     *
     * @return mixed
     */
    public function getUserByUserId($id)
    {
        return User::with('profile')->whereid($id)->firstOrFail();
    }

    /**
     * Display the specified resource.
     *
     * @param string $username
     *
     * @return Response
     */
    public function show($id)
    {
        try {
            $user = $this->getUserByUserId($id);
        } catch (ModelNotFoundException $exception) {
            abort(404);
        }


        $data = [
            'user'         => $user,
        ];

        return view('profiles.show')->with($data);
    }

    /**
     * /profiles/username/edit.
     *
     * @param $username
     *
     * @return mixed
     */
    public function edit($id)
    {
        try {
            $user = $this->getUserByUserId($id);
        } catch (ModelNotFoundException $exception) {
            return view('pages.status')
                ->with('error', trans('profile.notYourProfile'))
                ->with('error_title', trans('profile.notYourProfileTitle'));
        }

       

        $data = [
            'user'         => $user,
            

        ];

        return view('profiles.edit')->with($data);
    }

    /**
     * Update a user's profile.
     *
     * @param \App\Http\Requests\UpdateUserProfile $request
     * @param $username
     *
     * @throws Laracasts\Validation\FormValidationException
     *
     * @return mixed
     */
    public function update(UpdateUserProfile $request, $id)
    {
        $user = $this->getUserByUserId($id);
        $user->first_name = strip_tags($request->input('first_name'));
        $user->last_name = strip_tags($request->input('last_name'));
    
       if($user->profile){
        $profile = $user->profile->first();
            self::destroy($profile->id);
        }
        if($request->hasFile('image')){
            $profile = $request->image;
                //generate thumb image
                $profileThumbImage = Image::make($profile);
                //generate random string for image name
                $random_string = md5(microtime());
                //make image names
                $profileName       = $random_string .'.'. $profile->getClientOriginalExtension();
                $profileThumbName  = $random_string.'.'.$profile->getClientOriginalExtension();
                //save path
                $save_path          = storage_path('app/public') . '/profileImages/' . $id;
                $save_path_thumb    = storage_path('app/public') . '/profileImages/' . $id.'/thumb/';
                //path
                $path               = $save_path . $profileName;
                $path_thumb         = $save_path_thumb . $profileThumbName;
                //public path
                $public_path        = 'storage/profileImages/' . $id . '/' . $profileName;
                $public_path_thumb  = 'storage/profileImages/' . $id.'/thumb/'.$profileThumbName;
                // Make  a folder for questionimages  and set permissions
                File::makeDirectory($save_path, $mode = 0755, true, true);
                File::makeDirectory($save_path_thumb, $mode = 0755, true, true);
                //resize original image
                $profileThumbImage->resize(150,150);
                // Save the file to the server
                $profile->move($save_path, $profileName);
                $profileThumbImage->save($path_thumb);
                //save image in question related image table
                $profileImage = new Profile;
                $profileImage->user_id              = $id;
                $profileImage->image_name            = $profileName;
                $profileImage->public_path           = $public_path;
                
                $profileImage->save();
                $user->save();
        return redirect('/home')->with('success', trans('profile.updateSuccess'));
            }
            
    // }
    }
            public function destroy($profileImageId)
            {
                $profileImage=Profile::find($profileImageId);
                unlink($profileImage->public_path);
                if ($profileImage->delete()) {
                }
                return redirect('/home')->with('success', trans('profile.updateSuccess'));
                
            }
    
    public function userProfileAvatar($id, $image)
    {
        return Image::make(storage_path().'/users/id/'.$id.'/uploads/images/avatar/'.$image)->response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\DeleteUserAccount $request
     * @param int                                  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteUserAccount(DeleteUserAccount $request, $id)
    {
        $currentUser = \Auth::user();
        $user = User::findOrFail($id);
        $ipAddress = new CaptureIpTrait();

        if ($user->id !== $currentUser->id) {
            return redirect('profile/'.$user->name.'/edit')->with('error', trans('profile.errorDeleteNotYour'));
        }

        // Create and encrypt user account restore token
        $sepKey = $this->getSeperationKey();
        $userIdKey = $this->getIdMultiKey();
        $restoreKey = config('settings.restoreKey');
        $encrypter = config('settings.restoreUserEncType');
        $level1 = $user->id * $userIdKey;
        $level2 = urlencode(Uuid::generate(4).$sepKey.$level1);
        $level3 = base64_encode($level2);
        $level4 = openssl_encrypt($level3, $encrypter, $restoreKey);
        $level5 = base64_encode($level4);

        // Save Restore Token and Ip Address
        $user->token = $level5;
        $user->deleted_ip_address = $ipAddress->getClientIp();
        $user->save();

        // Send Goodbye email notification
        $this->sendGoodbyEmail($user, $user->token);

        // Soft Delete User
        $user->delete();

        // Clear out the session
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect('/login/')->with('success', trans('profile.successUserAccountDeleted'));
    }

    /**
     * Send GoodBye Email Function via Notify.
     *
     * @param array  $user
     * @param string $token
     *
     * @return void
     */
    public static function sendGoodbyEmail(User $user, $token)
    {
        $user->notify(new SendGoodbyeEmail($token));
    }

    /**
     * Get User Restore ID Multiplication Key.
     *
     * @return string
     */
    public function getIdMultiKey()
    {
        return $this->idMultiKey;
    }

    /**
     * Get User Restore Seperation Key.
     *
     * @return string
     */
    public function getSeperationKey()
    {
        return $this->seperationKey;
    }

    //view pdf
    public function openPDF()
    {
        $user = Auth::User();
        $expiry=date('Y-F-d', strtotime($user->created_at->addYear(4)));    
        // usersPdf is the view that includes the downloading content
        $view = \View::make('profiles.libraryCard', ['user'=>$user,'expiry'=>$expiry]);
        $html_content = $view->render();
        // Set title in the PDF
        // PDF::SetTitle("List of users");
        PDF::AddPage('P',array(120,120));
        // PDF::SetMargins(10, 10, 10, true);

        PDF::writeHTML($html_content, true, false, true, false, '');
        // userlist is the name of the PDF downloading
        PDF::Output('libraryCard.pdf');    
    }
}
