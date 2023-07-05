<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\UserInfo;
class UserinfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|email|max:255',
            'other_info' => 'required',
            'gender' => 'required',
            'skill' => 'required',
            'image' => 'required|image|max:1048', // maximum 2MB
        ]);
     
        if ($file = $request->file('image')) {
            $filename = date('dmY') . time() . '.' . $file->getClientOriginalExtension();

            $file->move(storage_path('app/public/employee_image'), $filename);
        }
        $employees=new UserInfo();
        $employees->name=$request->name;
        $employees->email=$request->email;
        $employees->other_info=$request->other_info;
        $employees->gender=$request->gender;
        $employees->skill=json_encode($request->skill);
        $employees->image=$filename;
        $employees->save();
        return redirect()->back()->withMessage('Successfully Created');
    

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employees=UserInfo::latest()->get();
        
        $user_update = UserInfo::where('id', $id)->get();

       return view('dashboard',compact('user_update','employees'));
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
          $user_update = UserInfo::where('id', $id)->first();
        // @dd($user_update1->email);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('user_infos')->ignore($user_update->id),
            ],
            'gender' => 'required',
            'skill' => 'required',
            'image' => 'max:1048', // maximum 1MB
        ]);
        if ($file = $request->file('image')) {
            $filename = date('dmY') . time() . '.' . $file->getClientOriginalExtension();

            $file->move(storage_path('app/public/employee_image'), $filename);
        }

        
      
        $user_update->update([
            'Name' => $request->name??$user_update->name,
            'email' => $request->email,
            'other_info' => $request->other_info??$user_update->other_info,
            'gender' => $request->gender??$user_update->gender,
            'skill' => json_encode($request->skill)??$user_update->skill,
            'image' => $filename??$user_update->image,
        ]);
        return redirect('dashboard')->withMessage('Successfully Update');
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         UserInfo::findOrFail($id)->delete();
        return redirect('dashboard')->withMessage('Successfully Deleted');
    }
}
