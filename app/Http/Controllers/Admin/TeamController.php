<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamController extends Controller
{

    protected $search = [
        'q' => null,
        'limit' => 20
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $this->search;
        $members = new User();
        if ($request->get('q')) {
            $search['q'] = $request->get('q');
            $members = $members->where('email', 'like', '%' . $search['q'] . '%');
        }

        if ($request->get('limit')) {
            $search['limit'] = $request->get('limit');
        }
        $members = $members->where('type', 'student')->paginate($search['limit']);
        return view('admin.team_members.index', compact('members', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $status_list = ['published' => 'Published', 'draft' => 'Draft'];
        // $positions = Position::orderBy('created_at', 'DESC')->get();
        return view('admin.team_members.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:191',
            'email'       => 'required|email|unique:users',
            'position' => 'required'
            // 'link'    => 'nullable|string|max:191|url',
            // 'description' => 'required|string|max:116'
        ]);

        $team_member = new User();
        $team_member->name = $request->name;
        $team_member->slug = Str::slug($request->name, '-');
        $team_member->email = $request->email;
        $team_member->position_id = $request->position;
        $team_member->type = 'member';
        $ps = Str::random(8);
        $password = \Hash::make($ps);
        $team_member->password = $password;
        if($request->file('image'))
        {
            //Getting the file name with extension
            $image = $request->file('image');
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $pat = $image->storeAs('public/profils', $fileNameToStore);
            $team_member->image = $fileNameToStore;
        }

        //  Sending mail to the created user
        \Mail::send('admin.admin.mailacc', array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $ps
        ), function($message) use ($request){
            $message->from('ericaelab@ulaval.ca');
            $message->to($request->get('email'), $request->get('name'))->subject('ERICAE Lab Account Created');
        });
        $team_member->save();

        session()->flash('success', 'Team Student successfully added');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $members = User::findorFail($id);
        $positions = Position::orderBy('created_at', 'DESC')->get();
        return view('admin.team_members.edit', compact('members', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $members = User::findorFail($id);

        $this->validate($request, [
            'name'        => 'required|string|max:191',
            'email'       => 'required|email',
            'position' => 'required'
        ]);

        if ($request->file('image')) {
            // delete old file
            if ($members->image) {
                Storage::delete('public/profils/' . $members->image);
            }

            //Getting the file name with extension
            $image = $request->file('image');
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $pat = $image->storeAs('public/profils', $fileNameToStore);
            $members->image = $fileNameToStore;
        }
        $members->name = $request->name;
        $members->email = $request->email;
        $members->position_id = $request->position;
        $members->save();

        Session::flash('success', 'Team Student updated successfully');
        return redirect()->route('admin.team_members.index');
    }


    public function updateStatus($id)
    {
        $member = User::findorFail($id);
        if($member->status === 'active')
        {
            $member->status = 'inactive';
            $member->save();
            Session::flash('success', 'Student Status has been set to Inactive');
            return redirect()->route('admin.team_members.index');
        }
        else
        {
            $member->status = 'active';
            $member->save();
            Session::flash('success', 'Student Status has been set back to Active');
            return redirect()->route('admin.team_members.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $members = User::findorFail($id);
        $rank = $members->rank;

        if ($members->image) {
            Storage::delete('public/team_members/' . $members->image);
        }
        $members->delete();
        Session::flash('success', 'Team Student deleted successfully');
        return redirect()->route('admin.team_members.index');
    }
}
