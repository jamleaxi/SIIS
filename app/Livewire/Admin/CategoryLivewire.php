<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\GlobalMessage;

class CategoryLivewire extends Component
{
    use WithPagination, WithoutUrlPagination;
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    // for pagination
    protected $paginationTheme = "bootstrap";
    public $pagination = 10;

    // for searching
    public $searchQuery;
    public $recordCount;
    public $resultCount;
    public $statMessage;

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

    // for inputs
    public $category;
    public $category_new;
    public $branch_new = "0";

    // for counters
    public $count_cs = 0;
    public $count_sep = 0;
    public $count_ppe = 0;

    // for checking
    public $show_add = false;
    public $dup_status; # duplicate checking
    public $category_id = '';

    // for updating
    public $up_status = false;
    public $category_up_origin;
    public $category_up;
    public $branch_up_origin;
    public $branch_up;

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        else
        {
            $this->loadCategory();

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
        $categories_cs = Category::where('branch','=','CS')->orderBy('category','asc')->get();
        $this->count_cs = $categories_cs->count();
        $categories_sep = Category::where('branch','=','SEP')->orderBy('category','asc')->get();
        $this->count_sep = $categories_sep->count();
        $categories_ppe = Category::where('branch','=','PPE')->orderBy('category','asc')->get();
        $this->count_ppe = $categories_ppe->count();

        // Get system message
        $system_message = GlobalMessage::orderBy('created_at','desc')->value('global_message');

        return view('livewire.admin.category-livewire', [
            // 'categories' => $categories,
            'categories_cs' => $categories_cs,
            'categories_sep' => $categories_sep,
            'categories_ppe' => $categories_ppe,
            'system_message' => $system_message,
        ]);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function loadCategory()
    {
        $this->category = Category::all();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    protected $listeners = [
        'category-added' => '$refresh',
        'category-updated' => '$refresh',
    ];
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updatedQuery()
    {
        $this->resetPage();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    #[On('category-added','category-updated')]
    public function refreshCategory()
    {
        $this->loadCategory();
        $this->updatedQuery();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateCategory()
    {
        $this->checkDuplicate();
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicate()
    {
        $dup_category = Category::where('category','=',$this->category_new)->get();
        $this->dup_status = $dup_category->count();

        if($this->dup_status == 0)
        {
            $this->addCategory();
        }
        else
        {
            session()->flash('error','Duplicate category!');
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function addCategory()
    {
        $category = new Category;

        $category->category = $this->category_new;
        $category->branch = $this->branch_new;
        $category->save();

        $this->resetAddForm();

        $this->dispatch('category-added', $category);

        session()->flash('success','New category added!');
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetAddForm()
    {
        $this->reset(['category_new','branch_new']);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function validateCategoryUpdate()
    {
        if($this->branch_up == '0')
        {
            session()->flash('warning','Please select a branch!');
        }
        else
        {
            $this->checkDuplicateUpdate();
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function checkDuplicateUpdate()
    {
        $dup_category = Category::where('category','=',$this->category_up)->get();
        $this->dup_status = $dup_category->count();

        if($this->dup_status == 0)
        {
            $this->saveUpdate();
        }
        else
        {
            if($this->category_up_origin == $this->category_up)
            {
                if($this->branch_up_origin == $this->branch_up)
                {
                    $this->resetUpdateForm();

                    session()->flash('info','No updates were made.');
                }
                else
                {
                    $this->saveUpdate();
                }
            }
            else
            {
                session()->flash('error','Duplicate category!');
            }
        }
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function updateCategory($id)
    {
        // get values
        $category = Category::find($id);
        $this->category_id = $category->id;
        $this->category_up_origin = $category->category;
        $this->category_up = $category->category;
        $this->branch_up_origin = $category->branch;
        $this->branch_up = $category->branch;
        $this->up_status = true;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function saveUpdate()
    {
        $updated = Category::find($this->category_id);
        $updated->category = $this->category_up;
        $updated->branch = $this->branch_up;
        $updated->save();

        $this->resetUpdateForm();

        session()->flash('success','Category updated!');

        $this->dispatch('category-updated', $updated);
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function resetUpdateForm()
    {
        $this->reset(['category_up','branch_up']);
        $this->category_id = '';
        $this->up_status = false;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function showAddPanel()
    {
        $this->show_add = true;
    }
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    public function hideAddPanel()
    {
        $this->show_add = false;
    }
}
