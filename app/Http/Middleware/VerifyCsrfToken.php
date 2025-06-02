<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Closure; // Pastikan ini ada
use Illuminate\Http\Request; // Pastikan ini ada

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '*', // Menonaktifkan CSRF untuk SEMUA rute untuk tes ini
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): \Symfony\Component\HttpFoundation\Response // Return type hint diperbarui
    {
        // !!! KODE DEBUGGING DIMULAI DI SINI !!!
        dd(
            'VerifyCsrfToken Middleware Dijalankan!',
            'Request Path:', $request->path(),
            'Request is GET:', $request->isMethod('GET'),
            'Request is POST:', $request->isMethod('POST'),
            'Isi $this->except:', $this->except,
            'Apakah path ini dikecualikan (inExceptArray)?', $this->inExceptArray($request)
        );
        // !!! KODE DEBUGGING BERAKHIR DI SINI !!!

        // Baris di bawah ini tidak akan pernah dijalankan jika dd() aktif,
        // tapi ini adalah cara normal untuk memanggil parent handle.
        return parent::handle($request, $next);
    }
}