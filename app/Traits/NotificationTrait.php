<?php

namespace App\Traits;

use Illuminate\Http\RedirectResponse;

trait NotificationTrait
{
    /**
     * Redirect dengan notifikasi sukses
     */
    public function successResponse($message, $redirectTo = null): RedirectResponse
    {
        return redirect($redirectTo ?: back())->with('message', $message);
    }

    /**
     * Redirect dengan notifikasi error
     */
    public function errorResponse($message, $redirectTo = null): RedirectResponse
    {
        return redirect($redirectTo ?: back())->with('error', $message);
    }

    /**
     * Redirect dengan notifikasi warning
     */
    public function warningResponse($message, $redirectTo = null): RedirectResponse
    {
        return redirect($redirectTo ?: back())->with('warning', $message);
    }

    /**
     * Redirect kembali dengan validasi error
     */
    public function validationError($errors, $input = []): RedirectResponse
    {
        return back()
            ->withErrors($errors)
            ->withInput($input);
    }
}
