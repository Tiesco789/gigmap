<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Newsletter / Email de boas-vindas
Route::post('/newsletter', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Authentication
Route::get('/cadastro', [AuthController::class, 'showRegister'])->name('register');
Route::post('/cadastro', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');
});

// Public profile (no auth required – shareable link)
Route::get('/perfil/{user}', [ProfileController::class, 'show'])->name('profile.show');

// Search autocomplete (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/api/buscar', function (\Illuminate\Http\Request $request) {
        $q = $request->query('q', '');
        if (mb_strlen($q) < 3) {
            return response()->json([]);
        }

        $users = \App\Models\User::where(function ($query) use ($q) {
                $query->where('name', 'ilike', "%{$q}%")
                      ->orWhereHas('musicianProfile', function ($mq) use ($q) {
                          $mq->where('first_name', 'ilike', "%{$q}%")
                             ->orWhere('last_name', 'ilike', "%{$q}%");
                      })
                      ->orWhereHas('establishmentProfile', function ($eq) use ($q) {
                          $eq->where('establishment_name', 'ilike', "%{$q}%");
                      });
            })
            ->with(['musicianProfile', 'establishmentProfile'])
            ->limit(8)
            ->get()
            ->map(function ($user) {
                $isMusician = $user->type === 'musician';
                return [
                    'id'       => $user->id,
                    'name'     => $user->getDisplayName(),
                    'avatar'   => $user->getAvatarUrl(),
                    'type'     => $isMusician ? 'musician' : 'establishment',
                    'label'    => $isMusician ? 'Músico' : 'Estabelecimento',
                    'subtitle' => $isMusician
                        ? $user->musicianProfile?->city
                        : $user->establishmentProfile?->city ?? $user->establishmentProfile?->address,
                    'url'      => route('profile.show', $user),
                ];
            });

        return response()->json($users);
    })->name('api.search');
});

// Announcements (auth required for all)
Route::middleware('auth')->group(function () {
    Route::get('/anuncios', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/anuncios/criar', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/anuncios', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/anuncios/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
    Route::get('/anuncios/{announcement}/editar', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::put('/anuncios/{announcement}', [AnnouncementController::class, 'update'])->name('announcements.update');
    Route::delete('/anuncios/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    // Proposals
    Route::post('/anuncios/{announcement}/proposta', [ProposalController::class, 'store'])->name('proposals.store');
});

// Notifications (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/notificacoes', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notificacoes/{id}/lida', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notificacoes/todas-lidas', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});

// Reviews (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/avaliar/{user}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/avaliar/{user}', [ReviewController::class, 'store'])->name('reviews.store');
});

// Chat (auth required)
Route::middleware('auth')->prefix('chat')->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('chats.index');
    Route::post('/', [ChatController::class, 'store'])->name('chats.store');
    Route::get('/{chat}', [ChatController::class, 'show'])->name('chats.show');
    Route::post('/{chat}/mensagens', [MessageController::class, 'store'])->name('messages.store');
});

