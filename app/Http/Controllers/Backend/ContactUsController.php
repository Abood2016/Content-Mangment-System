<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function __construct()
    {
        if (auth()->check()) {
            $this->middleware('auth');
        } else {
            return view('backend.auth.login');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\auth()->user()->ability('admin', 'manage_contact_us show_contact_us')) {
            return redirect('admin/index');
        }

        $keyword =     isset(\request()->keyword) && \request()->keyword != '' ? \request()->keyword : null;
        $status =      isset(\request()->status) && \request()->status != '' ? \request()->status : null;
        $sort_by =     isset(\request()->sort_by) && \request()->sort_by != '' ? \request()->sort_by : 'id';
        $order_by =    isset(\request()->order_by) && \request()->order_by != '' ? \request()->order_by : 'desc';
        $limit_by =    isset(\request()->limit_by) && \request()->limit_by != '' ? \request()->limit_by : '10';

        $messages = Contact::query();
        if ($keyword != null) {
            $messages = $messages->search($keyword);
        }

        if ($status != null) {
            $messages = $messages->whereStatus($status);
        }

        $messages = $messages->orderBy($sort_by, $order_by);
        $messages = $messages->paginate($limit_by);

        return view('backend.contact-us.index', compact('messages'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!\auth()->user()->ability('admin', 'show_contact_us')) {
            return redirect('admin/index');
        }
        $message = Contact::where('id', $id)->first();
        if ($message && $message->status == 0) {
            $message->status = 1;
            $message->save();
        }
        return view('backend.contact-us.show', compact('message'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!\auth()->user()->ability('admin', 'delete_contact_us')) {
            return redirect('admin/index');
        }

        $message = Contact::where('id', $id)->first();
        if ($message) {
            $message->delete();

            return redirect()->route('admin.contact_us.index')->with([
                'message' => 'message deleted successfully',
                'alert-type' => 'success',
            ]);
        }


        return redirect()->route('admin.contact_us.index')->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger',
        ]);
    }
}
