<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProjectManage extends Component {
    use WithPagination, WithFileUploads;

    // --- FORM PROPERTIES ---

    #[Validate('required|min:3')]
    public $name = '';

    #[Validate('required|email')] 
    public $client_email = ''; 

    #[Validate('nullable|string')]
    public $description = '';

    // Deadline & Status kita hapus validasinya dari sisi user input
    // Karena akan di-set otomatis oleh sistem
    public $status = 'pending'; 
    public $deadline = null;

    #[Validate('nullable|image|max:2048')] 
    public $logo; 

    public $projectIdToEdit = null;
    public $oldLogo = null;
    public $myModal = false;
    public $search = '';

    #[Layout("admin")] 
    public function render() {
        $projects = Project::with('client')
            ->when($this->search, fn($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->latest()
            ->paginate(10);

        return view("livewire.project-manage", [
            "projects" => $projects
        ]);
    }

    public function create() {
        $this->resetInputFields();
        $this->myModal = true;
    }

    public function edit($id) {
        $project = Project::findOrFail($id);
        $this->projectIdToEdit = $id;
        
        $this->name = $project->name;
        $this->client_email = $project->client->email ?? ''; 
        $this->description = $project->description;
        
        // Load data lama, tapi tidak ditampilkan di form (disimpan di memori saja)
        $this->deadline = $project->deadline;
        $this->status = $project->status;
        
        $this->oldLogo = $project->logo; 
        $this->logo = null; 

        $this->myModal = true;
    }

    public function save() {
        $this->validate(); 

        // 1. CEK / BUAT USER CLIENT
        $user = User::where('email', $this->client_email)->first();

        if (!$user) {
            $generatedPassword = Str::random(8);
            $generatedUsername = explode('@', $this->client_email)[0] . rand(100,999);

            $user = User::create([
                'name' => 'Client ' . $generatedUsername,
                'email' => $this->client_email,
                'username' => $generatedUsername,
                'password' => Hash::make($generatedPassword),
                'role' => 'client', 
            ]);

            session()->flash('new_account_info', "Akun Client Baru Dibuat! Password: $generatedPassword");
        }

        // 2. SIAPKAN DATA UTAMA
        $data = [
            'name' => $this->name,
            'client_id' => $user->id,
            'description' => $this->description,
        ];

        // 3. LOGIKA KHUSUS CREATE vs EDIT
        if (!$this->projectIdToEdit) {
             // == KONDISI CREATE BARU ==
             $data['slug'] = Str::slug($this->name);
             
             // Default Value (Sesuai Permintaan)
             $data['status'] = 'pending'; 
             $data['deadline'] = null; 
             
        } else {
            // == KONDISI EDIT ==
            // Kita JANGAN update status/deadline di sini.
            // Biarkan status/deadline tetap seperti apa adanya di database
            // (karena mungkin Tim Dokumentasi sudah mengubahnya)
        }

        // 4. HANDLE LOGO
        if ($this->logo) {
            if ($this->projectIdToEdit && $this->oldLogo) {
                Storage::disk('public')->delete($this->oldLogo);
            }
            $data['logo'] = $this->logo->store('project-logos', 'public');
        }

        // 5. EKSEKUSI
        Project::updateOrCreate(['id' => $this->projectIdToEdit], $data);

        $this->myModal = false;
        $this->resetInputFields();
        
        $msg = $this->projectIdToEdit ? "Project berhasil diupdate." : "Project berhasil dibuat.";
        session()->flash("message", $msg);
    }

    public function delete($id) {
        $project = Project::findOrFail($id);
        if ($project->logo) Storage::disk('public')->delete($project->logo);
        $project->delete();
        session()->flash("message", "Project deleted.");
    }

    private function resetInputFields() {
        $this->projectIdToEdit = null;
        $this->name = '';
        $this->client_email = '';
        $this->description = '';
        $this->logo = null;
        $this->oldLogo = null;
        // Reset status ke default memori (meski tidak dipakai di form)
        $this->status = 'pending'; 
        $this->deadline = null;
        $this->resetValidation(); 
    }
}