<?php

namespace App\Livewire\PreventiveAction;

use App\Models\PreventiveAction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ListsModal extends Component
{
    use WithPagination;
    public $search;
    public $pagination = 20;

    // เพิ่มฟังก์ชันนี้เพื่อให้ Search ทำงานไม่เพี้ยน
    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('refresh-preventive-action')]
    public function render()
    {
        $preventiveActions = PreventiveAction::query()
            ->when(trim($this->search), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('id')
            ->paginate($this->pagination);

        return view('livewire.preventive-action.lists-modal', compact('preventiveActions'));
    }

    public function deleteConfirm($id, $name)
    {
        $this->dispatch("confirm", id: $id, name: $name);
    }

    #[On('destroy-1')]
    public function destroy($id, $name)
    {
        // dd("Preventive");
        try {

            $preventiveAction = PreventiveAction::findOrFail($id);

            $preventiveAction->delete();

            $this->dispatch(
                "sweet.success",
                position: "center",
                title: "Deleted Successfully !!",
                text: "Preventive Action : " . $name,
                icon: "success",
                timer: 3000,
            );
        } catch (QueryException $e) {
            // กรณีลบไม่ได้เพราะติด Foreign Key (เช่น มีการเอาไปใช้ใน NCP แล้ว)
            $errorMessage = ($e->getCode() == "23000")
                ? "ไม่สามารถลบได้ เนื่องจากรายการนี้ถูกใช้งานอยู่ในระบบอื่น (NCP)"
                : "เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล";

            $this->dispatch(
                "sweet.error",
                title: "Cannot Deleted !!",
                text: $name . " : " . $errorMessage,
                icon: "error",
            );
        } catch (ModelNotFoundException $e) {
            // เมื่อหา ID ไม่เจอ จะวิ่งมาที่นี่
            $this->dispatch(
                "sweet.error",
                title: "Cannot Deleted !!",
                text: $name . " : Data not found.",
                icon: "error",
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                "sweet.error",
                position: "center",
                title: "Cannot Deleted !!",
                text: $name . " : " . $th->getMessage(),
                icon: "error",
            );
        }

        // $this->dispatch('close-modal');
    }
}
