<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $exercise = Exercise::get();
        if ($request->ajax()) {
            $data = Video::get();
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
                    $btn = '<button class="modal-effect btn btn-sm btn-info"  style="margin: 5px" id="showModalEditVideo" data-id="' . $row->id . '"><i class="las la-pen"></i></button>';
                    $btn = $btn . '<button class="modal-effect btn btn-sm btn-danger" style="margin: 5px" id="showModalDeleteVideo" data-name="' . $row->title_en . '" data-id="' . $row->id . '"><i class="las la-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns([
                    'image' => 'image',
                    'status' => 'status',
                    'action' => 'action',
                ])
                ->make(true);
        }
        return view('dashboard.views-dash.video.index' , compact('exercise'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $videoData = $request->all();
        $validator = Validator($videoData, [
            'title_en' => 'required|string|min:3|max:255',
            'title_ar' => 'required|string|min:3|max:255',
            'fitness_level' => 'required|string|max:255',
            'type' => 'required|in:home,gym',
            'sex' => 'required|in:male,female',
            'image' => 'required|image',
            'video' => 'required|mimes:mp4',
            'alternative_video' => 'required|mimes:mp4',
            'exercise_id' => 'required|exists:exercises,id',
            'status' => 'required|in:active,inactive',
        ]);
        if (!$validator->fails()) {
            if($request->hasFile('image')) {
                $name = Str::random(12);
                $image = $request->file('image');
                $imageName = $name . time() . '_' . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('image'), $imageName);
                $videoData['image'] = 'image/' . $imageName;
            }
            if($request->hasFile('video')) {
                $name = Str::random(12);
                $video = $request->file('video');
                $videoName = $name . time() . '_' . '.' . $video->getClientOriginalExtension();
                $video->move(public_path('video'), $videoName);
                $videoData['video'] = 'video/' . $videoName;
            }
            if($request->hasFile('alternative_video')) {
                $name = Str::random(12);
                $alternative_video = $request->file('alternative_video');
                $alternative_videoName = $name . time() . '_' . '.' . $alternative_video->getClientOriginalExtension();
                $alternative_video->move(public_path('video'), $alternative_videoName);
                $videoData['alternative_video'] = 'video/' . $alternative_videoName;
            }
            $video = Video::create($videoData);
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
        $video = Video::find($id);
        if ($video) {
            $response = [
                'message' => __('success'),
                'status' => 200,
                'data' => $video
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
        $videoData = $request->all();
        $validator = Validator($videoData, [
            'title_en' => 'required|string|min:3|max:255',
            'title_ar' => 'required|string|min:3|max:255',
            'fitness_level' => 'required|string|max:255',
            'type' => 'required|in:home,gym',
            'sex' => 'required|in:male,female',
            'image' => 'nullable|image',
            'video' => 'nullable|mimes:mp4',
            'alternative_video' => 'nullable|mimes:mp4',
            'exercise_id' => 'required|exists:exercises,id',
            'status' => 'required|in:active,inactive',
        ]);
        if (!$validator->fails()) {
            if($request->hasFile('image')) {
                $name = Str::random(12);
                $image = $request->file('image');
                $imageName = $name . time() . '_' . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('image'), $imageName);
                $videoData['image'] = 'image/' . $imageName;
            }
            if($request->hasFile('video')) {
                $name = Str::random(12);
                $video = $request->file('video');
                $videoName = $name . time() . '_' . '.' . $video->getClientOriginalExtension();
                $video->move(public_path('video'), $videoName);
                $videoData['video'] = 'video/' . $videoName;
            }
            if($request->hasFile('alternative_video')) {
                $name = Str::random(12);
                $alternative_video = $request->file('alternative_video');
                $alternative_videoName = $name . time() . '_' . '.' . $alternative_video->getClientOriginalExtension();
                $alternative_video->move(public_path('video'), $alternative_videoName);
                $videoData['alternative_video'] = 'video/' . $alternative_videoName;
            }
            $video = Video::find($id)->update($videoData);
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
        $video = Video::find($id);
        if ($video) {
            $video->delete();
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
        $video = Video::find($id);
        if ($video) {
            $video->changeStatus();
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
