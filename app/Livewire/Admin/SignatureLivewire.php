<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Signature;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\GlobalMessage;

class SignatureLivewire extends Component
{
    use WithFileUploads;
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // auth references
    public $my_id;
    public $my_name;
    public $my_email;
    public $my_position;
    public $my_position_full;
    public $my_office;
    public $my_office_full;
    public $my_role;
    public $my_photo;
    public $dark_setting;
    
    public $user_id;
    public $signature_id;
    public $signature_path_new;
    public $signature_path_up;
    public $update_signature =  false;
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        else
        {
            // $this->loadIssuer();

            $this->my_id = Auth::user()->id;
            $this->my_name = Auth::user()->name;
            $this->my_email = Auth::user()->email;
            $this->my_position = Auth::user()->position;
            $this->my_position_full = Auth::user()->position_full;
            $this->my_office = Auth::user()->office;
            $this->my_office_full = Auth::user()->office_full;
            $this->my_role = Auth::user()->role;
            $this->my_photo = Auth::user()->profile_photo_path;
            $this->dark_setting = Auth::user()->dark_mode;
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function render()
    {
        $this->user_id = $this->my_id;
        $signatures = Signature::where('user_id','=',$this->user_id)->get();

        // Get system message
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.admin.signature-livewire',[
            'signatures' => $signatures,
            'system_message' => $system_message,
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function saveSignature()
    {
        // Validate the image
        $this->validate([
            'signature_path_new' => 'image|max:2048', // 2MB Max
        ]);

        $imagePath = $this->signature_path_new->store('esign', 'public');

        $signature = new Signature;
        $signature->user_id = $this->user_id;
        $signature->signature_path = $imagePath;
        $signature->save();

        $this->resetForm();

        session()->flash('success', 'E-Signature was successfully uploaded.');
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetForm()
    {
        $this->reset(['signature_path_new']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updateSignature($id)
    {
        // get values
        $current_sig = Signature::find($id);
        $this->signature_id = $current_sig->id;
        $this->update_signature = true;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function saveSignatureUpdate()
    {
        // Validate the image
        $this->validate([
            'signature_path_up' => 'image|max:2048', // 2MB Max
        ]);

        $imagePath = $this->signature_path_up->store('esign', 'public');

        $signature = Signature::find($this->signature_id);
        $signature->signature_path = $imagePath;
        $signature->save();

        $this->resetFormUpdate();

        session()->flash('success', 'E-Signature was successfully updated.');
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetFormUpdate()
    {
        $this->reset(['signature_path_up']);
        $this->update_signature = false;
    }
}
