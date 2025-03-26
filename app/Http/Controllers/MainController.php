<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Note;
use App\Services\Operations;
use Illuminate\Http\Request;

class MainController extends Controller {

    public function index() {
        // load user's notes
        $id = session("user.id"); //para pegar o id do usuario
        $notes = User::find($id)->notes()
        ->whereNull('deleted_at')->get()->toArray(); // Para pegar as notas do usuario pelo id

        /* get(): Executa a consulta e retorna uma coleção de usuários.
        toArray(): Converte a coleção em um array associativo. */

        // show home a view
        return view("home", ['notes' => $notes]);
    }

    public function newNote() {
        return view("new_note");
    }

    public function newNoteSubmit(Request $request) {
        // validate request 
        $request->validate(
            // regras 
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],
            // Mensagens de erro
            [
                'text_title.required' => 'O título é obrigatório',
                'text_title.min' => 'A título deve ter pelo menos :min caracteres',
                'text_title.max' => 'A título deve ter no máximo :max caracteres',

                'text_note.required' => 'A nota é obrigátoria',
                'text_note.min' => 'A nota deve ter pelo menos :min caracteres',
                'text_note.max' => 'A nota deve ter no máximo :max caracteres'
            ]
        );

        // get user id 
        $id = session('user.id');

        // create new note
        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        // redirect to home
        return redirect()->route('home');
    }

    public function editNote($id) {
        $id = Operations::dcryptId($id);

        // load note
        $note = Note::find($id);

        //show edit note view
        return view("edit_note", ['note' => $note]);
    }

    public function editNoteSubmit(Request $request) {

        // validate request 
        $request->validate(
            // regras 
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],
            // Mensagens de erro
            [
                'text_title.required' => 'O título é obrigatório',
                'text_title.min' => 'A título deve ter pelo menos :min caracteres',
                'text_title.max' => 'A título deve ter no máximo :max caracteres',

                'text_note.required' => 'A nota é obrigátoria',
                'text_note.min' => 'A nota deve ter pelo menos :min caracteres',
                'text_note.max' => 'A nota deve ter no máximo :max caracteres'
            ]
        );

        // check if note_id exists
        if($request->note_id == null) {
            return redirect()->to('home');
        }

        // decrypt note_id
        $id = Operations::dcryptId($request->note_id);

        // load note
        $note = Note::find($id);

        // update note
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        // redirect to home
        return redirect()->route('home');
    }

    public function deleteNote($id) {
        $id = Operations::dcryptId($id);

        // load note
        $note = Note::find($id);

        // show delete note confirmation
        return view('delete_note', ['note' => $note]);
    }

    public function deleteNoteConfirm($id) {
        
        // check if $id is encrypted
        $id = Operations::dcryptId($id);

        // load note
        $note = Note::find($id);

        // 1. hard delete
        // $note->delete();

        // 2. soft delete
        /* $note->deleted_at = date('Y:m:d H:i:s');
        $note->save(); */

        // 3. soft delete (property in model)
        $note->delete();

        // redirect to home
        return redirect()->route('home');
    }
}
