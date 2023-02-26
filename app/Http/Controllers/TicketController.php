<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Discussion;

class TicketController extends Controller
{
    public function index(){
        $title = "MyBdApps | Ticket List";
        $is_active = "ticket_list";

        $tickets = Ticket::orderBy('updated_at', 'desc')->paginate(50);

        return view('portal.ticket.list', compact('title', 'is_active', 'tickets'));
    }

    public function create(){
        $title = "MyBdApps | Create Ticket";
        $is_active = "ticket_create";

        return view('portal.ticket.create', compact('title', 'is_active'));
    }

    public function store(Request $request){
      $rules = [
          'subject' => 'required',
          'details' => 'required',
      ];
      
      $messages = [
          'subject.required' => 'Subject field is required!',
          'details.required' => 'Details field is required!',
      ];
      
      $this->validate($request, $rules, $messages);
      $user_id = session()->get('user_id');

      $ticketData = new Ticket;
      $ticketData->user_id = $user_id;
      $ticketData->subject = $request->subject;
      $ticketData->details = $request->details;
      $ticketData->admin_seen = 0;
      $ticketData->user_seen = 1;
      $ticketData->save();

      $message = 'Ticket created successfully!';
      $log_write = storeActivityLog('Ticket','Ticket Create',json_encode($request->all()));
      return redirect()->route('ticket.list.self')->with('message',$message);
    }

    public function selfList(){
        $title = "MyBdApps | My Ticket List";
        $is_active = "ticket_list_self";

        $user_id = session()->get('user_id');
        $tickets = Ticket::where('user_id', $user_id)->orderBy('updated_at', 'desc')->paginate(50);

        return view('portal.ticket.self_list', compact('title', 'is_active', 'tickets'));


    }

    public function edit($id){
        $title = "MyBdApps | Edit Ticket";
        $is_active = "ticket_edit";
  
        $ticketDetail = Ticket::where('id', $id)->first();
        $ticketDetail->admin_seen = 1;
        $ticketDetail->save();

        $threadDetail = Discussion::where('ticket_id', $ticketDetail->id)->get();

        return view('portal.ticket.edit', compact('title', 'is_active', 'ticketDetail', 'threadDetail'));
    }

    public function selfEdit($id){
        $title = "MyBdApps | Edit Ticket";
        $is_active = "ticket_edit";
  
        $ticketDetail = Ticket::where('id', $id)->first();
        $ticketDetail->user_seen = 1;
        $ticketDetail->save();

        $threadDetail = Discussion::where('ticket_id', $ticketDetail->id)->get();

        return view('portal.ticket.self_edit', compact('title', 'is_active', 'ticketDetail', 'threadDetail'));
    }

    public function update(Request $request){
        $rules = [
            'reply' => 'required',
        ];
        
        $messages = [
            'reply.required' => 'Reply field is required!',
        ];
        
        $this->validate($request, $rules, $messages);
  
        $ticket_id = $request->ticket_id;
  
        $ticketData = Ticket::where('id', $ticket_id)->first();
        $ticketData->is_resolved = $request->is_resolved;
        $ticketData->user_seen = 0;
        $ticketData->save();

        $discussionData = new Discussion;
        $discussionData->ticket_id = $ticket_id;
        $discussionData->message = $request->reply;
        $discussionData->sender = 'admin';
        $discussionData->save();
  
        $message = 'Ticket replied successfully!';
        $log_write = storeActivityLog('Ticket','Ticket Update',json_encode($request->all()));
        
        return redirect()->back()->with('message',$message);
    }

    public function selfUpdate(Request $request){
        $rules = [
            'reply' => 'required',
        ];
        
        $messages = [
            'reply.required' => 'Reply field is required!',
        ];
        
        $this->validate($request, $rules, $messages);
  
        $ticket_id = $request->ticket_id;

        $ticketData = Ticket::where('id', $ticket_id)->first();
        $ticketData->admin_seen = 0;
        $ticketData->save();

        $discussionData = new Discussion;
        $discussionData->ticket_id = $ticket_id;
        $discussionData->message = $request->reply;
        $discussionData->sender = 'user';
        $discussionData->save();
  
        $message = 'Ticket replied successfully!';
        return redirect()->back()->with('message',$message);
    }

}
