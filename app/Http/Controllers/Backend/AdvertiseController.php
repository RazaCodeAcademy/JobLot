<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Advertisement;

class AdvertiseController extends Controller
{
    public function create()
    {
        $countries = DB::table('countries')->get();
        $employers = DB::table('model_has_roles')->select('model_id')->where('role_id','=','2')->get();

        return view('backend.pages.advertise.create',compact('countries','employers'));
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'countries' => 'required',
            'employer' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $countries = implode(',', $request->input('countries'));

        $advertise =  DB::table('advertisements')->insertGetId([
            'admin_id' => Auth::user()->id,
            'title' => $request['title'],
            'countries' => $countries,
            'employer' => $request['employer'],
            'start_date' => $request['start_date'],
            'end_date' => $request['end_date'],
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image)
            {
                $images = $image;
                $path = public_path(). '/images/';
                $filename = time() . '.' . $images->getClientOriginalExtension();
                $images->move($path, $filename);
                $advertisementImage  = $filename;

                DB::table('advertisements_images')->insert(array(
                    'ad_id'=> $advertise,
                    'image'=> $advertisementImage,
                    'created_at'=> DB::raw('CURRENT_TIMESTAMP')
                ));
            }
        }

        return redirect()->route('listAdvertise')->with('success', 'Record Added Successfully.');
    }

    public function list()
    {
        $advertisements = Advertisement::get();

        return view('backend.pages.advertise.list',compact('advertisements'));
    }

    public function edit($id)
    {
        $advertisements = Advertisement::where('id', $id)
        ->first();

        $countries = DB::table('countries')->get();
        $employers = DB::table('model_has_roles')->select('model_id')->where('role_id','=','2')->get();

        if($advertisements == null)
        {
            return redirect()->route('listAdvertise')->with('error', 'No Record Found.');
        }

        return view('backend.pages.advertise.edit', compact('advertisements','countries','employers'));
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'countries' => 'required',
            'employer' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $advertisement = DB::table('advertisements')->where('id', $id)->first();

        if (empty($advertisement))
        {
            return redirect()->route('listAdvertise')->with('error', 'Something went wrong try again!');
        }
        else{
            $countries = implode(',', $request->input('countries'));

            DB::table('advertisements')->where('id', $advertisement->id)->update([
                'title' => $request['title'],
                'countries' => $countries,
                'employer' => $request['employer'],
                'start_date' => $request['start_date'],
                'end_date' => $request['end_date'],
                'updated_at' => DB::raw('CURRENT_TIMESTAMP')
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image)
                {
                        $images = $image;
                        $path = public_path(). '/images/';
                        $filename = time() . '.' . $images->getClientOriginalExtension();
                        $images->move($path, $filename);
                        $advertisementImage  = $filename;

                        DB::table('advertisements_images')->insert(array(
                            'ad_id'=> $id,
                            'image'=> $advertisementImage,
                            'created_at'=> DB::raw('CURRENT_TIMESTAMP')
                        ));
                }
            }

            return redirect()->route('listAdvertise')->with('success', 'Record Added Successfully.');
        }
    }

    public function delete(Request $request)
    {
        $advertisement = DB::table('advertisements')->where('id',$request->id)->first();

        if(empty($advertisement)) {
            return response()->json(['status' => 0]);
        }

        DB::table('advertisements')->where('id',$request->id)->delete();
        DB::table('advertisements_images')->where('ad_id', $request->id)->delete();

        return response()->json(['status' => 1]);
    }

    public function deleteImage(Request $request)
    {
        $image = DB::table('advertisements_images')->where('id', $request->id)->first();
//        dd($image->image);

        if(empty($image)) {
            return response()->json(['status' => 0]);
        }

        if (Storage::exists($image->image))
        {
            Storage::delete('/'.$image->image);
        }
        DB::table('advertisements_images')->delete($request->id);

        return response()->json(['status' => 1]);
    }

    public function status(Request $request)
    {
        $advertisement = DB::table('advertisements')->where('id',$request->ad_id)->first();

        if(empty($advertisement)) {
            return response()->json(['status' => 0]);
        }

        DB::table('advertisements')->where('id', $advertisement->id)->update([
            'status' => $request->status_id,
        ]);

        return response()->json(['status' => 1]);
    }

}
