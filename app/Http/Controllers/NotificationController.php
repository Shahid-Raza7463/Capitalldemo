<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Teammember;
use DB;
use Mail;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 18) {
            $userId = auth()->user()->teammember_id;
            $notificationDatas = DB::table('notifications')
                ->leftjoin('notificationreadorunread', function ($join) use ($userId) {
                    $join->on('notificationreadorunread.notifications_id', 'notifications.id')
                        ->where('notificationreadorunread.readedby', $userId);
                })
                ->select('notifications.*', 'notificationreadorunread.status as readstatus')
                ->latest()
                ->distinct()
                ->paginate(20);
            return view('backEnd.notification.index', compact('notificationDatas'));
        } elseif (auth()->user()->role_id == 13) {

            $userId = auth()->user()->teammember_id;

            $notificationDatas = DB::table('notifications')
                ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                ->leftjoin('notificationreadorunread', function ($join) use ($userId) {
                    $join->on('notificationreadorunread.notifications_id', 'notifications.id')
                        ->where('notificationreadorunread.readedby', $userId);
                })
                ->Where(function ($query) {
                    $query->where('targettype', '3')->orWhere('targettype', '2');
                })
                ->orWhere(function ($query) use ($userId) {
                    $query->where('notificationtargets.teammember_id', $userId)
                        ->where('notificationreadorunread.readedby', $userId);
                })
                ->select('notifications.*', 'notificationreadorunread.status as readstatus')
                ->latest()
                ->distinct()
                ->get();
            return view('backEnd.notification.index', compact('notificationDatas'));
        } elseif (auth()->user()->role_id == 14) {
            $userId = auth()->user()->teammember_id;

            $notificationDatas = DB::table('notifications')
                ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                ->leftjoin('notificationreadorunread', function ($join) use ($userId) {
                    $join->on('notificationreadorunread.notifications_id', 'notifications.id')
                        ->where('notificationreadorunread.readedby', $userId);
                })
                ->where(function ($query) use ($userId) {
                    $query->where('targettype', '4')
                        ->orWhere('targettype', '2')
                        ->orWhere(function ($innerQuery) use ($userId) {
                            $innerQuery->where('notificationtargets.teammember_id', $userId);
                        });
                })
                ->select('notifications.*', 'notificationreadorunread.status as readstatus')
                ->distinct()
                ->get();

            return view('backEnd.notification.index', compact('notificationDatas'));
        } elseif (auth()->user()->role_id == 15) {
            $userId = auth()->user()->teammember_id;

            $notificationDatas = DB::table('notifications')
                ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                ->leftjoin('notificationreadorunread', function ($join) use ($userId) {
                    $join->on('notificationreadorunread.notifications_id', 'notifications.id')
                        ->where('notificationreadorunread.readedby', $userId);
                })
                ->where(function ($query) use ($userId) {
                    $query->where('targettype', '5')
                        ->orWhere('targettype', '2')
                        ->orWhere(function ($innerQuery) use ($userId) {
                            $innerQuery->where('notificationtargets.teammember_id', $userId);
                        });
                })
                ->select('notifications.*', 'notificationreadorunread.status as readstatus')
                ->distinct()
                ->get();

            return view('backEnd.notification.index', compact('notificationDatas'));
        } elseif (auth()->user()->role_id == 16) {
            $userId = auth()->user()->teammember_id;

            $notificationDatas = DB::table('notifications')
                ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                ->leftjoin('notificationreadorunread', function ($join) use ($userId) {
                    $join->on('notificationreadorunread.notifications_id', 'notifications.id')
                        ->where('notificationreadorunread.readedby', $userId);
                })
                ->where(function ($query) use ($userId) {
                    $query->where('targettype', '6')
                        ->orWhere('targettype', '2')
                        ->orWhere(function ($innerQuery) use ($userId) {
                            $innerQuery->where('notificationtargets.teammember_id', $userId);
                        });
                })
                ->select('notifications.*', 'notificationreadorunread.status as readstatus')
                ->distinct()
                ->get();

            return view('backEnd.notification.index', compact('notificationDatas'));
        } elseif (auth()->user()->role_id == 17) {
            $userId = auth()->user()->teammember_id;

            $notificationDatas = DB::table('notifications')
                ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                ->leftjoin('notificationreadorunread', function ($join) use ($userId) {
                    $join->on('notificationreadorunread.notifications_id', 'notifications.id')
                        ->where('notificationreadorunread.readedby', $userId);
                })
                ->where(function ($query) use ($userId) {
                    $query->where('targettype', '7')
                        ->orWhere('targettype', '2')
                        ->orWhere(function ($innerQuery) use ($userId) {
                            $innerQuery->where('notificationtargets.teammember_id', $userId);
                        });
                })
                ->select('notifications.*', 'notificationreadorunread.status as readstatus')
                ->distinct()
                ->get();

            return view('backEnd.notification.index', compact('notificationDatas'));
        } else {
            $userId = auth()->user()->teammember_id;

            $notificationDatas = DB::table('notifications')
                ->leftjoin('teammembers', 'teammembers.id', 'notifications.created_by')
                ->leftjoin('notificationtargets', 'notificationtargets.notification_id', 'notifications.id')
                ->leftjoin('notificationreadorunread', function ($join) use ($userId) {
                    $join->on('notificationreadorunread.notifications_id', 'notifications.id')
                        ->where('notificationreadorunread.readedby', $userId);
                })
                ->where(function ($query) use ($userId) {
                    $query->where('notifications.targettype', '2')
                        ->orWhere('notificationtargets.teammember_id', $userId);
                })
                ->select('notifications.*', 'teammembers.team_member', 'teammembers.profilepic', 'notificationreadorunread.status as readstatus')
                ->distinct()
                ->get();

            return view('backEnd.notification.index', compact('notificationDatas'));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teammember = Teammember::Where('role_id', '!=', '12')->where('status', 1)
            ->where('id', '!=', auth()->user()->teammember_id)->with('role')->get();

        //   dd($teammembers);
        return view('backEnd.notification.create', compact('teammember'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     dd($request->targettype[0]);
    //     // $firstElement = $request->targettype[0];

    //     // if ($firstElement == 1) {
    //     //     // Your code here
    //     // }

    //     // dd($request->targettype == 1);
    //     // $request->validate([
    //     //     'title' => "required",
    //     //     'team_member' => "required"
    //     // ]);

    //     try {
    //         $authid = auth()->user()->teammember_id;
    //         $data = $request->except(['_token']);
    //         $notification_id =    DB::table('notifications')->insertGetId([
    //             'title'         => $request->title,
    //             'created_by'  => $authid,
    //             // 'targettype'         => $request->targettype,
    //             'mail_content'         => $request->mail_content,
    //             'created_at'                =>       date('Y-m-d H:i:s'),
    //             'updated_at'              =>    date('Y-m-d H:i:s'),
    //         ]);
    //         if ($request->targettype == 1) {
    //             foreach ($request->teammember_id as $teammember_id) {
    //                 DB::table('notificationtargets')->insert([
    //                     'notification_id'       =>     $notification_id,
    //                     'teammember_id'     =>     $teammember_id,
    //                     'created_at'                =>       date('y-m-d'),
    //                     'updated_at'              =>    date('y-m-d'),
    //                 ]);
    //             }
    //         }
    //         if ($request->targettype == 1) {
    //             $teammembers = Teammember::wherein('id', $request->teammember_id)->pluck('emailid')->toArray();
    //             // dd($teammembers);
    //             foreach ($teammembers as $teammember) {
    //                 $data = array(
    //                     'title' =>  $request->title,
    //                     'mail_content' =>  $request->mail_content,
    //                     'emailid' =>  $teammember,
    //                 );

    //                 //   $data['mail']=$teammember;

    //                 Mail::send('emails.notificationmail', $data, function ($msg) use ($data) {
    //                     $msg->to($data['emailid']);
    //                     $msg->subject($data['title']);
    //                 });
    //             }
    //         } elseif ($request->targettype == 2) {
    //             $teammembers = Teammember::where('status', 1)->pluck('emailid')->toArray();
    //             //    dd($teammembers);
    //             foreach ($teammembers as $teammember) {
    //                 $data = array(
    //                     'title' =>  $request->title,
    //                     'mail_content' =>  $request->mail_content,
    //                     'emailid' =>  $teammember,
    //                 );

    //                 //  $data['mail']=$teammembers;

    //                 Mail::send('emails.notificationmail', $data, function ($msg) use ($data) {
    //                     $msg->to($data['emailid']);
    //                     $msg->subject($data['title']);
    //                 });
    //             }
    //         } elseif ($request->targettype == 3) {
    //             $teammembers = Teammember::where('role_id', 13)->where('status', 1)->pluck('emailid')->toArray();
    //             foreach ($teammembers as $teammember) {
    //                 $data = array(
    //                     'title' =>  $request->title,
    //                     'mail_content' =>  $request->mail_content,
    //                     'emailid' =>  $teammember,
    //                 );


    //                 //  $data['mail']=$teammembers;
    //                 Mail::send('emails.notificationmail', $data, function ($msg) use ($data) {
    //                     $msg->to($data['emailid']);
    //                     $msg->subject($data['title']);
    //                 });
    //             }
    //         } elseif ($request->targettype == 4) {
    //             $teammembers = Teammember::where('role_id', 14)->where('status', 1)->pluck('emailid')->toArray();
    //             foreach ($teammembers as $teammember) {
    //                 $data = array(
    //                     'title' =>  $request->title,
    //                     'mail_content' =>  $request->mail_content,
    //                     'emailid' =>  $teammember,
    //                 );

    //                 //   $data['mail']=$teammembers;
    //                 Mail::send('emails.notificationmail', $data, function ($msg) use ($data) {
    //                     $msg->to($data['emailid']);
    //                     $msg->subject($data['title']);
    //                 });
    //             }
    //         } elseif ($request->targettype == 5) {
    //             $teammembers = Teammember::where('role_id', 15)->where('status', 1)->pluck('emailid')->toArray();
    //             foreach ($teammembers as $teammember) {
    //                 $data = array(
    //                     'title' =>  $request->title,
    //                     'mail_content' =>  $request->mail_content,
    //                     'emailid' =>  $teammember,
    //                 );

    //                 //   $data['mail']=$teammembers;
    //                 Mail::send('emails.notificationmail', $data, function ($msg) use ($data) {
    //                     $msg->to($data['emailid']);
    //                     $msg->subject($data['title']);
    //                 });
    //             }
    //         } elseif ($request->targettype == 6) {
    //             $teammembers = Teammember::where('role_id', 16)->where('status', 1)->pluck('emailid')->toArray();
    //             foreach ($teammembers as $teammember) {
    //                 $data = array(
    //                     'title' =>  $request->title,
    //                     'mail_content' =>  $request->mail_content,
    //                     'emailid' =>  $teammember,
    //                 );
    //                 Mail::send('emails.notificationmail', $data, function ($msg) use ($data) {
    //                     $msg->to($data['emailid']);
    //                     $msg->subject($data['title']);
    //                 });
    //             }
    //         } elseif ($request->targettype == 7) {
    //             $teammembers = Teammember::where('role_id', 17)->where('status', 1)->pluck('emailid')->toArray();
    //             foreach ($teammembers as $teammember) {
    //                 $data = array(
    //                     'title' =>  $request->title,
    //                     'mail_content' =>  $request->mail_content,
    //                     'emailid' =>  $teammember,

    //                 );


    //                 //   $data['mail']=$teammembers;
    //                 Mail::send('emails.notificationmail', $data, function ($msg) use ($data) {
    //                     $msg->to($data['emailid']);
    //                     $msg->subject($data['title']);
    //                 });
    //             }
    //         }

    //         $output = array('msg' => 'Sent Successfully');
    //         return back()->with('success', $output);
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    //         report($e);
    //         $output = array('msg' => $e->getMessage());
    //         return back()->withErrors($output)->withInput();
    //     }
    // }



   public function store(Request $request)
    {
        // dd($request->targettype[0]);
        try {
            $authid = auth()->user()->teammember_id;
            $data = $request->except(['_token']);
            // Initialize the attachment path
            $attachmentPath = '';
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $name = $file->getClientOriginalName();
                $attachmentPath = storage_path('app/public/image/task/' . $name);
                $file->storeAs('public/image/task', $name);
            } else {
                $name = '';
            }
            // dd($attachmentPath);
            $notification_id =    DB::table('notifications')->insertGetId([
                'title'         => $request->title,
                'created_by'  => $authid,
                'targettype'         => $request->targettype[0],
                'mail_content'         => $request->mail_content,
                'attachment'    => $name,
                'created_at'                =>       date('Y-m-d H:i:s'),
                'updated_at'              =>    date('Y-m-d H:i:s'),
            ]);
            if ($request->targettype[0] == 1) {
                foreach ($request->teammember_id as $teammember_id) {
                    DB::table('notificationtargets')->insert([
                        'notification_id'       =>     $notification_id,
                        'teammember_id'     =>     $teammember_id,
                        'created_at'                =>       date('y-m-d'),
                        'updated_at'              =>    date('y-m-d'),
                    ]);
                }
            }
            // 1 exist or not in array of $request->targettype
            if (in_array(1, $request->targettype)) {
                $teammembers = Teammember::wherein('id', $request->teammember_id)->pluck('emailid')->toArray();

                // dd($teammembers);
                foreach ($teammembers as $teammember) {
                    $data = array(
                        'title' =>  $request->title,
                        'mail_content' =>  $request->mail_content,
                        'attachment' =>  $request->attachment,
                        'emailid' =>  $teammember,
                    );

                    //   $data['mail']=$teammember;

                    // Mail::send('emails.notificationmail', $data, function ($msg) use ($data) {
                    //     $msg->to($data['emailid']);
                    //     $msg->subject($data['title']);
                    // });

                    Mail::send('emails.notificationmail', $data, function ($msg) use ($data, $attachmentPath, $name) {
                        $msg->to($data['emailid']);
                        $msg->subject($data['title']);

                        // Attach the file to the email
                        if ($attachmentPath != '') {
                            $msg->attach($attachmentPath, [
                                'as' => $name,
                                'mime' => 'image/jpeg',
                            ]);
                        }
                    });
                }
            }
            if (in_array(2, $request->targettype)) {

                $teammembers = Teammember::where('status', 1)->pluck('emailid')->toArray();
                //    dd($teammembers);
                foreach ($teammembers as $teammember) {
                    $data = array(
                        'title' =>  $request->title,
                        'mail_content' =>  $request->mail_content,
                        'emailid' =>  $teammember,
                    );

                    //  $data['mail']=$teammembers;

                    Mail::send('emails.notificationmail', $data, function ($msg) use ($data, $attachmentPath, $name) {
                        $msg->to($data['emailid']);
                        $msg->subject($data['title']);

                        // Attach the file to the email
                        if ($attachmentPath != '') {
                            $msg->attach($attachmentPath, [
                                'as' => $name,
                                'mime' => 'image/jpeg',
                            ]);
                        }
                    });
                }
            }
            if (in_array(3, $request->targettype)) {
                $teammembers = Teammember::where('role_id', 13)->where('status', 1)->pluck('emailid')->toArray();
                foreach ($teammembers as $teammember) {
                    $data = array(
                        'title' =>  $request->title,
                        'mail_content' =>  $request->mail_content,
                        'emailid' =>  $teammember,
                    );


                    Mail::send('emails.notificationmail', $data, function ($msg) use ($data, $attachmentPath, $name) {
                        $msg->to($data['emailid']);
                        $msg->subject($data['title']);

                        // Attach the file to the email
                        if ($attachmentPath != '') {
                            $msg->attach($attachmentPath, [
                                'as' => $name,
                                'mime' => 'image/jpeg',
                            ]);
                        }
                    });
                }
            }
            if (in_array(4, $request->targettype)) {
                $teammembers = Teammember::where('role_id', 14)->where('status', 1)->pluck('emailid')->toArray();
                foreach ($teammembers as $teammember) {
                    $data = array(
                        'title' =>  $request->title,
                        'mail_content' =>  $request->mail_content,
                        'emailid' =>  $teammember,
                    );

                    Mail::send('emails.notificationmail', $data, function ($msg) use ($data, $attachmentPath, $name) {
                        $msg->to($data['emailid']);
                        $msg->subject($data['title']);

                        // Attach the file to the email
                        if ($attachmentPath != '') {
                            $msg->attach($attachmentPath, [
                                'as' => $name,
                                'mime' => 'image/jpeg',
                            ]);
                        }
                    });
                }
            }
            if (in_array(5, $request->targettype)) {
                $teammembers = Teammember::where('role_id', 15)->where('status', 1)->pluck('emailid')->toArray();
                foreach ($teammembers as $teammember) {
                    $data = array(
                        'title' =>  $request->title,
                        'mail_content' =>  $request->mail_content,
                        'emailid' =>  $teammember,
                    );

                    Mail::send('emails.notificationmail', $data, function ($msg) use ($data, $attachmentPath, $name) {
                        $msg->to($data['emailid']);
                        $msg->subject($data['title']);

                        // Attach the file to the email
                        if ($attachmentPath != '') {
                            $msg->attach($attachmentPath, [
                                'as' => $name,
                                'mime' => 'image/jpeg',
                            ]);
                        }
                    });
                }
            }
            if (in_array(6, $request->targettype)) {
                $teammembers = Teammember::where('role_id', 16)->where('status', 1)->pluck('emailid')->toArray();
                foreach ($teammembers as $teammember) {
                    $data = array(
                        'title' =>  $request->title,
                        'mail_content' =>  $request->mail_content,
                        'emailid' =>  $teammember,
                    );
                    Mail::send('emails.notificationmail', $data, function ($msg) use ($data, $attachmentPath, $name) {
                        $msg->to($data['emailid']);
                        $msg->subject($data['title']);

                        // Attach the file to the email
                        if ($attachmentPath != '') {
                            $msg->attach($attachmentPath, [
                                'as' => $name,
                                'mime' => 'image/jpeg',
                            ]);
                        }
                    });
                }
            }
            if (in_array(7, $request->targettype)) {
                $teammembers = Teammember::where('role_id', 17)->where('status', 1)->pluck('emailid')->toArray();
                foreach ($teammembers as $teammember) {
                    $data = array(
                        'title' =>  $request->title,
                        'mail_content' =>  $request->mail_content,
                        'emailid' =>  $teammember,

                    );


                    Mail::send('emails.notificationmail', $data, function ($msg) use ($data, $attachmentPath, $name) {
                        $msg->to($data['emailid']);
                        $msg->subject($data['title']);

                        // Attach the file to the email
                        if ($attachmentPath != '') {
                            $msg->attach($attachmentPath, [
                                'as' => $name,
                                'mime' => 'image/jpeg',
                            ]);
                        }
                    });
                }
            }

            $output = array('msg' => 'Sent Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
   public function show($id)
    {
        $notificationData =  DB::table('notifications')
            ->where('id', $id)->first();

        // notification read or unread functionality
        DB::table('notificationreadorunread')->insert([
            'notifications_id'   =>   $id,
            'readedby'   =>  auth()->user()->teammember_id,
            'status'   =>   1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return view('backEnd.notification.view', compact('notificationData'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = '')
    {
        //  dd($id);
        try {

            Notification::destroy($id);
            DB::table('notificationtargets')->where('notification_id', $id)->delete();
            $output = array('msg' => 'Deleted Successfully');
            return redirect('notification')->with('statuss', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
}
