<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class UserOnline extends Component
{
    use WithPagination;

    public $pagination = 20;

    #[On('refresh-data')]
    public function render()
    {
        // ดึง user_id จากตาราง sessions ที่มีความเคลื่อนไหวในช่วง 5 นาทีล่าสุด
        // 5 นาที * 60 วินาที = 300 วินาที
        $threshold = now()->subMinutes(5)->getTimestamp();

        $onlineUserIds = DB::table('sessions')
            ->whereNotNull('user_id')
            ->where('last_activity', '>=', $threshold)
            ->pluck('user_id');

        $users = User::whereIn('id', $onlineUserIds)->paginate($this->pagination);

        return view('livewire.user.user-online', compact('users'));
    }
}
