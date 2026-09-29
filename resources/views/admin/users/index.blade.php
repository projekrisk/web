@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manajemen Pengguna</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola data member, reset password, dan blokir akun pelanggar.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="bg-brand-primary hover:bg-brand-primaryHover text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm inline-flex items-center gap-2 w-max">
        <i class="fa-solid fa-plus"></i> Tambah Pengguna
    </a>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden relative">
    
    <div class="p-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-800/50 flex flex-col sm:flex-row justify-between gap-4">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-center gap-3 w-full">
            <div class="relative flex-1 max-w-sm">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Cari nama, email, atau WA..." class="w-full bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-brand-primary outline-none transition-all">
            </div>

            <select name="status" onchange="this.form.submit()" class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 text-gray-900 dark:text-white rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-primary outline-none cursor-pointer">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active (Aktif)</option>
                <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Banned (Diblokir)</option>
            </select>

            <button type="submit" class="hidden"></button>

            @if(request('search') || request('status'))
                <a href="{{ route('admin.users.index') }}" class="text-sm text-red-500 hover:text-red-700 font-medium flex items-center gap-1 transition-colors px-2">
                    <i class="fa-solid fa-circle-xmark"></i> Reset Filter
                </a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse min-w-[900px]">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-900/50 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Profil Member</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Kontak</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Tanggal Daftar</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700">Status</th>
                    <th class="p-4 font-medium border-b border-gray-100 dark:border-slate-700 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100 dark:divide-slate-700">
                
                <?php if(count($users) > 0): ?>
                    <?php foreach($users as$user): ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors <?php echo $user->is_banned ? 'opacity-70 bg-red-50/30 dark:bg-red-900/10' : ''; ?>">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full <?php echo $user->is_banned ? 'bg-red-100 dark:bg-red-900/30 text-red-600' : 'bg-brand-primary text-white'; ?> flex items-center justify-center font-bold text-sm shrink-0 shadow-sm">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white">{{ $user->name }}</p>
                                    <span class="inline-flex items-center gap-1 text-[10px] text-gray-500 dark:text-gray-400 font-semibold mt-0.5 uppercase tracking-wider">
                                        <i class="fa-regular fa-user"></i> {{ $user->role }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <p class="text-gray-600 dark:text-gray-300"><i class="fa-regular fa-envelope text-gray-400 text-xs mr-1"></i> {{ $user->email }}</p>
                            @if($user->whatsapp_number)
                                <p class="text-gray-600 dark:text-gray-300 mt-1"><i class="fa-brands fa-whatsapp text-green-500 text-xs mr-1"></i> {{ $user->whatsapp_number }}</p>
                            @endif
                        </td>
                        <td class="p-4 text-gray-600 dark:text-gray-400">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="p-4">
                            <?php if($user->is_banned): ?>
                                <span class="px-2.5 py-1 bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400 text-xs font-bold rounded uppercase tracking-wider border border-red-200 dark:border-red-500/20">Banned</span>
                            <?php else: ?>
                                <span class="px-2.5 py-1 bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400 text-xs font-bold rounded uppercase tracking-wider border border-green-200 dark:border-green-500/20">Active</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center items-center gap-2">
                                <form action="{{ route('admin.users.ban', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-md {{ $user->is_banned ? 'bg-green-50 text-green-600 hover:bg-green-100 dark:bg-green-500/10' : 'bg-orange-50 text-orange-600 hover:bg-orange-100 dark:bg-orange-500/10' }} transition-colors" title="{{ $user->is_banned ? 'Pulihkan (Unban)' : 'Blokir (Ban)' }}">
                                        <i class="fa-solid {{ $user->is_banned ? 'fa-unlock' : 'fa-lock' }} text-xs"></i>
                                    </button>
                                </form>

                                <a href="{{ route('admin.users.edit', $user->id) }}" class="w-8 h-8 flex items-center justify-center rounded-md bg-blue-50 text-brand-primary hover:bg-brand-primary hover:text-white dark:bg-blue-500/10 dark:hover:bg-brand-primary transition-colors" title="Edit Data & Reset Sandi">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>

                                <button type="button" onclick="openDeleteModal('{{ route('admin.users.destroy', $user->id) }}', '{{ addslashes($user->name) }}')" class="w-8 h-8 flex items-center justify-center rounded-md bg-red-50 text-brand-danger hover:bg-brand-danger hover:text-white dark:bg-red-500/10 dark:hover:bg-brand-danger transition-colors" title="Hapus Permanen">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="p-12 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fa-solid fa-users-slash text-4xl mb-3 text-gray-300 dark:text-gray-600"></i>
                                <p>Tidak ada data pengguna ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
    <div class="p-4 border-t border-gray-100 dark:border-slate-700">
        {{ $users->links() }}
    </div>
    @endif
</div>

<div id="delete-modal" class="fixed inset-0 z-[100] hidden items-center justify-center px-4">
    <div id="delete-overlay" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
    <div id="delete-content" class="relative bg-white dark:bg-slate-800 w-full max-w-md rounded-2xl p-6 text-center shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="w-16 h-16 mx-auto bg-red-100 dark:bg-red-500/20 text-brand-danger rounded-full flex items-center justify-center text-3xl mb-4">
            <i class="fa-solid fa-user-xmark"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Hapus Pengguna?</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">Apakah Anda yakin ingin menghapus akun <strong id="delete-user-name" class="text-gray-800 dark:text-gray-200"></strong> secara permanen?</p>
        
        <div class="flex gap-3">
            <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-900 dark:text-white font-medium py-2.5 rounded-lg transition-colors">
                Batal
            </button>
            <form id="delete-form" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-brand-danger hover:bg-red-600 text-white font-medium py-2.5 rounded-lg transition-colors">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const deleteModal = document.getElementById('delete-modal');
    const deleteOverlay = document.getElementById('delete-overlay');
    const deleteContent = document.getElementById('delete-content');
    const deleteForm = document.getElementById('delete-form');
    const deleteUserName = document.getElementById('delete-user-name');

    function openDeleteModal(actionUrl, userName) {
        deleteForm.action = actionUrl;
        deleteUserName.textContent = userName;
        
        deleteModal.classList.remove('hidden'); deleteModal.classList.add('flex');
        void deleteModal.offsetWidth;
        deleteOverlay.classList.remove('opacity-0');
        deleteContent.classList.remove('scale-95', 'opacity-0');
    }

    function closeDeleteModal() {
        deleteOverlay.classList.add('opacity-0');
        deleteContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => { 
            deleteModal.classList.add('hidden'); deleteModal.classList.remove('flex'); 
        }, 300);
    }

    deleteOverlay.addEventListener('click', closeDeleteModal);
</script>
@endsection