<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Exercise::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    if(App::getLocale() == 'en'){
                        $title = $row->title_en;
                    }else{
                        $title = $row->title_ar;
                    }
                    return $title;
                })
                ->addColumn('image', function ($row) {
                    $image = '<img src="' . asset('/') . $row->image . '" alt="image" width="50" height="50">';
                    return $image;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 'active') {
                        $status = '<button class="modal-effect btn btn-sm btn-success" style="margin: 5px" id="status" data-id="' . $row->id . '" ><i class=" icon-check"></i></button>';
                    } else {
                        $status = '<button class="modal-effect btn btn-sm btn-danger" style="margin: 5px" id="status" data-id="' . $row->id . '" ><i class=" icon-check"></i></button>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button class="modal-effect btn btn-sm btn-info"  style="margin: 5px" id="showModalEditExercise" data-id="' . $row->id . '"><i class="las la-pen"></i></button>';
                    $btn = $btn . '<button class="modal-effect btn btn-sm btn-danger" style="margin: 5px" id="showModalDeleteExercise" data-name="' . $row->title_en . '" data-id="' . $row->id . '"><i class="las la-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns([
                    'image' => 'image',
                    'status' => 'status',
                    'action' => 'action',
                ])
                ->make(true);
        }
        return view('dashboard.views-dash.exercise.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $exerciseData = $request->all();
        $validator = Validator($exerciseData, [
            'title_en' => 'required|string|min:3|max:255',
            'title_ar' => 'required|string|min:3|max:255',
            'image' => 'required|image',
            'status' => 'required|in:active,inactive',
        ]);
        if (!$validator->fails()) {
            if ($request->hasFile('image')) {
                $name = Str::random(12);
                $image = $request->file('image');
                $imageName = $name . time() . '_' . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('image'), $imageName);
                $exerciseData['image'] = 'image/' . $imageName;
            }
            $exercise = Exercise::create($exerciseData);
            $response = [
                'message' => __('Added successfully'),
                'status' => 200,
            ];
            return ControllersService::responseSuccess($response);
        } else {
            $response = [
                'message' => $validator->getMessageBag()->first(),
                'status' => 400,
            ];
            return ControllersService::responseErorr($response);
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
        $exercise = Exercise::find($id);
        if ($exercise) {
            $response = [
                'message' => __('success'),
                'status' => 200,
                'data' => $exercise
            ];
            return ControllersService::responseSuccess($response);
        } else {
            $response = [
                'message' => __('Not Found Data'),
                'status' => 400,
            ];
            return ControllersService::responseErorr($response);
        }
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
        $exerciseData = $request->all();
        $validator = Validator($exerciseData, [
            'title_en' => 'required|string|min:3|max:255',
            'title_ar' => 'required|string|min:3|max:255',
            'image' => 'nullable|image',
            'status' => 'required|in:active,inactive',
        ]);
        if (!$validator->fails()) {
            if ($request->hasFile('image')) {
                $name = Str::random(12);
                $image = $request->file('image');
                $imageName = $name . time() . '_' . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('image'), $imageName);
                $exerciseData['image'] = 'image/' . $imageName;
            }
            $exercise = Exercise::find($id)->update($exerciseData);
            $response = [
                'message' => __('Updated successfully'),
                'status' => 200,
            ];
            return ControllersService::responseSuccess($response);
        } else {
            $response = [
                'message' => $validator->getMessageBag()->first(),
                'status' => 400,
            ];
            return ControllersService::responseErorr($response);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exercise = Exercise::find($id);
        if ($exercise) {
            $exercise->delete();
            $response = [
                'message' => __('Deleted successfully'),
                'status' => 200,
            ];
            return ControllersService::responseSuccess($response);
        } else {
            $response = [
                'message' => __('Not Found Data'),
                'status' => 400,
            ];
            return ControllersService::responseErorr($response);
        }
    }

    public function status($id)
    {
        $exercise = Exercise::find($id);
        if ($exercise) {
            $exercise->changeStatus();
            $response = [
                'message' => __('Updated successfully'),
                'status' => 200,
            ];
            return ControllersService::responseSuccess($response);
        } else {
            $response = [
                'message' => __('Not Found Data'),
                'status' => 400,
            ];
            return ControllersService::responseErorr($response);
        }
    }
}

