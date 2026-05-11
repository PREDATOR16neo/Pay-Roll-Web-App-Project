<?php

namespace App\Traits;

use Livewire\Attributes\On;

trait LivewireNotificationTrait
{
    /**
     * Dispatch notifikasi berhasil
     */
    public function successNotification($title, $message)
    {
        $this->dispatch('notify', type: 'success', title: $title, message: $message);
        session()->flash('message', $message);
    }

    /**
     * Dispatch notifikasi error
     */
    public function errorNotification($title, $message)
    {
        $this->dispatch('notify', type: 'error', title: $title, message: $message);
    }

    /**
     * Dispatch notifikasi warning
     */
    public function warningNotification($title, $message)
    {
        $this->dispatch('notify', type: 'warning', title: $title, message: $message);
    }

    /**
     * Dispatch notifikasi info
     */
    public function infoNotification($title, $message)
    {
        $this->dispatch('notify', type: 'info', title: $title, message: $message);
    }

    /**
     * Notifikasi umum dengan session flash
     */
    public function flashMessage($message)
    {
        session()->flash('message', $message);
    }

    /**
     * Notifikasi dengan custom timeout
     */
    public function successWithTimer($title, $message, $timer = 3000)
    {
        $this->dispatch('notifyWithTimer', type: 'success', title: $title, message: $message, timer: $timer);
        session()->flash('message', $message);
    }
}
