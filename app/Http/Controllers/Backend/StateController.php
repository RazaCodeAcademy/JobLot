<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\State;

class StateController extends Controller
{
    public function listStates()
    {
        $states = State::all();

        return view('backend.pages.states.list', compact('states'));
    }
    public function createState()
    {
        return view('backend.pages.states.create');
    }

    public function storeState(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
           
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

            State::create([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            
        ]);

        return redirect()->route('liststates')->with('success', 'Record Added Successfully.');
    }

    public function editState($id)
    {
        $state = State::find($id);

        if($state == null)
        {
            return redirect()->route('liststates')->with('error', 'No Record Found.');
        }

        return view('backend.pages.states.edit', compact('state'));
    }

    public function updateState(Request $request,$id)
    {
        $state = State::find($id);
            $state = State::find($id)->update
            ([
                'name' => $request->name,
                'name_ar' => $request->name_ar,
                
            ]);

        return redirect()->route('liststates')->with('success','Record Successfully Updated');

    }

    public function deleteState($id){
        
        $state = State::find($id);

        if(empty($state)) {
            return response()->json(['status' => 0]);
        }

        $state->delete();

        return response()->json(['status' => 1]);
    }
}
