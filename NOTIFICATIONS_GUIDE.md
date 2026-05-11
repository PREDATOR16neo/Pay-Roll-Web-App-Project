# Panduan Penggunaan SweetAlert2 Notifications

## Overview

Sistem notifikasi telah diintegrasikan di seluruh aplikasi menggunakan SweetAlert2. Ini memudahkan menampilkan pesan sukses, error, warning, dan info dengan tampilan yang menarik.

## Lokasi File Penting

### 1. **Traits**

- `app/Traits/NotificationTrait.php` - Untuk Controller
- `app/Traits/LivewireNotificationTrait.php` - Untuk Livewire Components

### 2. **Layout**

- `resources/views/layouts/app.blade.php` - Layout utama dengan script SweetAlert2

### 3. **Auth**

- `resources/views/auth/login.blade.php` - Login page dengan notifikasi

## Cara Penggunaan

### A. Di Livewire Components

#### 1. Import Trait

```php
use App\Traits\LivewireNotificationTrait;

class MyComponent extends Component
{
    use LivewireNotificationTrait;
}
```

#### 2. Menggunakan Method Notifikasi

**Success Notification:**

```php
public function store()
{
    // ... proses menyimpan data
    $this->successNotification('Berhasil!', 'Data berhasil ditambahkan');
}
```

**Error Notification:**

```php
public function delete($id)
{
    try {
        // ... proses menghapus
    } catch (\Exception $e) {
        $this->errorNotification('Gagal!', 'Terjadi kesalahan saat menghapus data');
    }
}
```

**Warning Notification:**

```php
$this->warningNotification('Peringatan', 'Anda akan menghapus data ini');
```

**Info Notification:**

```php
$this->infoNotification('Informasi', 'Proses sedang berlangsung');
```

**Success dengan Timer:**

```php
$this->successWithTimer('Berhasil!', 'Data berhasil disimpan', 5000); // 5 detik
```

### B. Di Controller

#### 1. Import Trait

```php
use App\Traits\NotificationTrait;

class MyController extends Controller
{
    use NotificationTrait;
}
```

#### 2. Menggunakan Method Notifikasi

**Success Response:**

```php
public function store(Request $request)
{
    // ... proses menyimpan
    return $this->successResponse('Data berhasil ditambahkan', '/admin');
}
```

**Error Response:**

```php
return $this->errorResponse('Terjadi kesalahan', '/admin');
```

**Warning Response:**

```php
return $this->warningResponse('Peringatan penting', '/admin');
```

**Validation Error:**

```php
return $this->validationError($errors->all());
```

### C. Di View Blade

Notifikasi otomatis ditampilkan jika ada session message:

**Success Message** (otomatis disappear dalam 3 detik):

```php
// Di Controller atau Livewire
return redirect('/')->with('message', 'Berhasil login sebagai admin');
```

**Error Message:**

```php
return back()->with('error', 'Email atau password salah');
```

**Warning Message:**

```php
return back()->with('warning', 'Perhatian: data akan segera kadaluarsa');
```

**Validation Errors** (otomatis ditampilkan):

```php
return back()->withErrors($validator);
```

## Contoh Implementasi

### Livewire Component - Position Management

```php
<?php
namespace App\Livewire\Admin;

use App\Models\Position;
use App\Traits\LivewireNotificationTrait;
use Livewire\Component;

class Position extends Component
{
    use LivewireNotificationTrait;

    public $name;

    public function store()
    {
        $validated = $this->validate([
            'name' => 'required|unique:positions,name|min:3'
        ]);

        try {
            Position::create($validated);
            $this->successNotification('Berhasil!', 'Posisi baru berhasil ditambahkan');
            $this->clear();
        } catch (\Exception $e) {
            $this->errorNotification('Gagal!', 'Terjadi kesalahan');
        }
    }

    public function destroy($id)
    {
        try {
            $position = Position::find($id);
            $name = $position->name;
            $position->delete();
            $this->successNotification('Berhasil!', "Posisi '{$name}' berhasil dihapus");
        } catch (\Exception $e) {
            $this->errorNotification('Gagal!', 'Terjadi kesalahan');
        }
    }
}
```

## Tipe-tipe Notifikasi

| Type    | Icon | Warna  | Kegunaan         |
| ------- | ---- | ------ | ---------------- |
| success | ✓    | Hijau  | Operasi berhasil |
| error   | ✗    | Merah  | Operasi gagal    |
| warning | ⚠    | Orange | Peringatan       |
| info    | ℹ    | Biru   | Informasi umum   |

## Fitur Validasi Otomatis

Semua validation errors ditampilkan otomatis dalam SweetAlert2 dengan format yang rapi:

```php
public function store()
{
    $this->validate([
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users'
    ]);
    // Jika ada error, otomatis tampil di SweetAlert2
}
```

## Event Listener (Advanced)

Untuk custom handling di JavaScript:

```javascript
window.addEventListener("notify", function (event) {
    const { type, title, message } = event.detail;
    // Custom logic
});
```

## Best Practices

1. **Selalu gunakan Try-Catch** untuk operasi database yang berisiko
2. **Validasi yang jelas** - Gunakan custom error messages
3. **User-friendly messages** - Pesan mudah dipahami
4. **Timing** - Success notification auto-close dalam 3 detik, error tetap ditampilkan
5. **Konsistensi** - Gunakan format pesan yang sama di seluruh app

## Testing

Untuk test notifikasi:

1. Buka browser DevTools (F12)
2. Pergi ke tab Console
3. Trigger action (tambah/edit/hapus data)
4. Pastikan SweetAlert2 muncul dengan benar

## Troubleshooting

**Notifikasi tidak muncul:**

- Pastikan `@livewireScripts` ada di layout
- Cek browser console untuk error
- Pastikan trait sudah di-import

**Styling tidak cocok:**

- CSS gradient button dari Tailwind dan SweetAlert2 kompatibel
- Jika perlu custom styling, edit `showNotification()` di app.blade.php

---

**Terakhir diupdate:** Mai 2026
**Version:** 1.0
