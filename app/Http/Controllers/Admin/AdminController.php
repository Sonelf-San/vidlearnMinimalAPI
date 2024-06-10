<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Models\User;
use App\Models\Position;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    //

    protected $search = [
        'q' => null,
        'limit' => 20
    ];

    public function index(Request $request)
    {
        $search = $this->search;
        $lecturers = new User();

        if ($request->get('q')) {
            $search['q'] = $request->get('q');
            $lectures = $lecturers->where('email', 'like', '%' . $search['q'] . '%');
        }

        if ($request->get('limit')) {
            $search['limit'] = $request->get('limit');
        }
//        $admins = $admins->where('type', 'admin')->where('super_admin', false)->paginate($search['limit']);
        $lecturers = $lecturers->where('type', 'lecturer')->paginate($search['limit']);
        return view('admin.admin.index', compact('lecturers', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Position::orderBy('created_at', 'DESC')->get();
        return view('admin.admin.create', compact('positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required'       => __('Champ de nom obligatoire'),
            'email.required' => __('Champ de courriel obligatoire'),
            'email.email'         => __('L\'email doit être et l\'email'),
            'email.unique'         => __('Cet e-mail a déjà été utilisé pour un autre administrateur'),
            // 'phone.required'         => __('Champ de téléphone requis'),
            // 'password.required'         => __('Champ de mot de passe obligatoire'),
            // 'password.min'         => __('Le mot de passe doit être composé de 8 caractères'),
            // 'password.confirmed'         => __('La confirmation du mot de passe ne correspond pas'),
        ];

        $validator = Validator::make($request->all(), [
            'name'         => 'required',
            'email'        => ['required', 'string', 'email', 'unique:users']
            // 'password'      => ['required', 'string', 'min:8', 'confirmed'],
            // 'phone'         => ['required', 'string'],
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $admin = new User();
        $admin->name = $request->name;
        $admin->slug = Str::slug($request->name, '-');
        $admin->email = $request->email;
        $admin->position_id = $request->position;
        $ps = Str::random(8);
        $password = \Hash::make($ps);
        $admin->password = $password;
        $admin->type = 'admin';

        $user = Auth('admin')->user()->super_admin;
        if($user != 'super_admin')
            {
                return redirect()->to(route('admin.administrator.index'))->with('error', "Impossible d'effectuer cette action, vous n'avez pas les privilèges necessaires");
            }
        else
            //  Sending mail to the created user
            \Mail::send('admin.admin.mailacc', array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => $ps
            ), function($message) use ($request){
                $message->from('ericaelab@ulaval.ca');
                $message->to($request->get('email'), $request->get('name'))->subject('ERICAE Lab Account Created');
            });
        {
            $admin->save();
            return redirect()->to(route('admin.administrator.index'))->with('success', "Admin created successfully");
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.admin.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        session()->flash('success', 'Mise à jour réussie');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->super_admin){
            session()->flash('error', 'L\'action ne peut pas être effectuée sur le super administrateur');
        }else{
            if($user->id == \Auth('admin')->user()->id){
                session()->flash('error', 'Impossible d\'effectuer cette action sur vous-même');
            }else{
                if(!\Auth('admin')->user()->super_admin)
                {
                    session()->flash('error', 'Impossible d\'effectuer cette action, vous n\'avez pas les privilèges necessaires');
                }
                else
                {
                    $user->delete();
                    session()->flash('success', 'Admin supprimé avec succès');
                }
            }
        }
        return redirect()->to(route('admin.administrator.index'));
    }
}
